<?php

namespace Ninja\Sentinel\Language;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ninja\Sentinel\Dictionary\LazyDictionary;
use Ninja\Sentinel\Enums\ContextType;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Collections\RuleCollection;
use Ninja\Sentinel\Language\Contracts\Context as ContextContract;
use Ninja\Sentinel\Language\Contracts\Language as LanguageContract;
use Ninja\Sentinel\Language\Contracts\Rule;
use Ninja\Sentinel\Language\DTO\DetectionResult;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;

/**
 * @phpstan-type LanguageDetectionDetails array{
 *     pronouns: string[],
 *     markers: string[],
 *     intensifiers: string[],
 *     modifiers: string[],
 *     quotes: string[],
 *     excuses: string[],
 *     common_words: string[],
 *     word_count: int,
 *     unique_word_count: int,
 *     total_language_elements: int,
 *     percentage_of_language_elements: float,
 *     raw_score: int
 * }
 */
final readonly class Language implements LanguageContract
{
    private LazyDictionary $dictionary;

    /** @var Collection<int, string> */
    private Collection $intensifiers;

    /** @var Collection<int, string> */
    private Collection $positive_modifiers;

    /** @var Collection<int, string> */
    private Collection $negative_modifiers;

    /** @var Collection<int, string> */
    private Collection $pronouns;
    /** @var Collection<int, string> */
    private Collection $prefixes;

    /** @var Collection<int, string> */
    private Collection $suffixes;

    /** @var Collection<int, string> */
    private Collection $language_markers;

    /** @var Collection<int, string> */
    private Collection $quote_markers;

    /** @var Collection<int, string> */
    private Collection  $excuse_markers;

    /** @var Collection<int, ContextContract> */
    private Collection $contexts;

    private RuleCollection $rules;


    /**
     * @param array{
     *      words: array{
     *          offensive: array<int, string>,
     *          intensifiers: array<int, string>,
     *          modifiers: array{
     *              negative: array<int, string>,
     *              positive: array<int, string>
     *          },
     *          quote: array<int, string>,
     *          excuse: array<int, string>
     *      },
     *      pronouns: array<int, string>,
     *      prefixes: array<int, string>,
     *      suffixes: array<int, string>,
     *      markers: array<int, string>,
     *      contexts: array<string, array{
     *          markers: array<int, string>,
     *          whitelist: array<int, string>
     *      }>,
     *      patterns: array{
     *          word_specific: array<string, array<int, string>>
     *      },
     *     rules: array<string, callable>|array{}
     *  } $data
     * @param LanguageCode $code
     */
    public function __construct(public array $data, public LanguageCode $code)
    {
        $this->dictionary = LazyDictionary::withWords($this->data['words']['offensive']);
        $this->intensifiers = collect($this->data['words']['intensifiers']);
        $this->negative_modifiers = collect($this->data['words']['modifiers']['negative']);
        $this->positive_modifiers = collect($this->data['words']['modifiers']['positive']);
        $this->pronouns = collect($this->data['pronouns']);
        $this->prefixes = collect($this->data['prefixes']);
        $this->suffixes = collect($this->data['suffixes']);
        $this->language_markers = collect($this->data['markers']);
        $this->quote_markers = collect($this->data['words']['quote']);
        $this->excuse_markers = collect($this->data['words']['excuse']);

        $this->contexts = new Collection();
        $this->rules = new RuleCollection();

        $this->loadContexts();
        $this->loadRules();
    }

    public function code(): LanguageCode
    {
        return $this->code;
    }

    public function detect(string $text): DetectionResult
    {
        if (empty($text)) {
            return DetectionResult::empty();
        }

        $text = Str::lower($text);
        $words = preg_split('/\s+/', $text);
        if (empty($words)) {
            return DetectionResult::empty();
        }

        $words = collect($words)->filter()->values();
        $details = [
            'pronouns' => [],
            'markers' => [],
            'intensifiers' => [],
            'modifiers' => [],
            'quotes' => [],
            'excuses' => [],
            'common_words' => [],
            'word_count' => $words->count(),
            'unique_word_count' => $words->unique()->count(),
            'total_language_elements' => 0,
            'percentage_of_language_elements' => 0.0,
            'raw_score' => 0,
        ];

        $rawScore = (int) $words->reduce(function ($carry, $word) use (&$details) {
            $wordScore = $this->analyzeWord($word, $details);
            return $carry + $wordScore;
        }, 0);

        foreach ($details as $key => $detail) {
            if (is_array($detail)) {
                $details[$key] = array_unique($detail);
            }
        }

        $details["total_language_elements"] = (fn(array $details): int => array_reduce($details, fn($carry, $item) => $carry + (is_array($item) ? count($item) : 0), 0))($details);
        $details["percentage_of_language_elements"] = $words->count() > 0 ? ($details["total_language_elements"] / $words->count()) * 100 : 0;
        $details["raw_score"] = $rawScore;

        return new DetectionResult(
            code: $this->code,
            score: $this->calculateScore($words, $details, $rawScore),
            confidence: $this->calculateConfidence($words, $details),
            details: $details,
        );
    }

    public function getContextModifier(string $text, int $position, int $length): float
    {
        $before = mb_substr($text, max(0, $position - 100), min(100, $position));
        $after = mb_substr($text, $position + $length, min(100, mb_strlen($text) - $position - $length));

        $beforeWords = array_map(
            fn(string $word) => mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $word)),
            array_filter(explode(' ', $before), fn($word) => mb_strlen($word) > 0),
        );

        $afterWords = array_map(
            fn(string $word) => mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $word)),
            array_filter(explode(' ', $after), fn($word) => mb_strlen($word) > 0),
        );

        $context = array_merge($beforeWords, $afterWords);
        $modifier = 1.0;

        foreach ($context as $word) {
            if ($this->isNegative($word)) {
                $modifier *= 1.3; // Increase score - negative language
            }

            if ($this->isPositive($word)) {
                $modifier *= 0.7; // Decrease score - positive language
            }

            if ($this->isIntensifier($word)) {
                $modifier *= 1.1; // Slight increase - intensified
            }

            foreach ($this->contexts() as $context) {
                if ($context->markers()->contains($word)) {
                    $modifier *= 0.5; // Significant decrease - educational language
                    break;
                }
            }

        }

        foreach ($afterWords as $word) {
            if ($this->isPronoun($word)) {
                $modifier *= 1.5; // Significant increase - targeted at someone
                break;
            }
        }

        if ($this->detectCommonPhrases($beforeWords)) {
            $modifier *= 0.5; // Significant decrease - common phrase
        }


        return $modifier;
    }

    public function words(): LazyDictionary
    {
        return $this->dictionary;
    }

    /**
     * @return Collection<int, string>
     */
    public function intensifiers(): Collection
    {
        return $this->intensifiers;
    }

    public function modifiers(string $type): Collection
    {
        return match ($type) {
            'positive' => $this->positive_modifiers,
            'negative' => $this->negative_modifiers,
            default => new Collection(),
        };
    }

    public function contexts(): Collection
    {
        return $this->contexts;
    }

    /**
     * @return Collection<int, string>
     */
    public function prefixes(): Collection
    {
        return $this->prefixes;
    }

    /**
     * @return Collection<int, string>
     */
    public function suffixes(): Collection
    {
        return $this->suffixes;
    }

    public function isPronoun(string $word): bool
    {
        return $this->pronouns->contains($word);
    }

    public function isMarker(string $word): bool
    {
        return $this->language_markers->contains($word);
    }

    public function isIntensifier(string $word): bool
    {
        return $this->intensifiers->contains($word);
    }

    public function isModifier(string $word): bool
    {
        return
            $this->positive_modifiers->contains($word) ||
            $this->negative_modifiers->contains($word);
    }

    public function isPositive(string $word): bool
    {
        return $this->positive_modifiers->contains($word);
    }

    public function isNegative(string $word): bool
    {
        return $this->negative_modifiers->contains($word);
    }

    public function isQuoteMarker(string $word): bool
    {
        return $this->quote_markers->contains($word);
    }

    public function isExcuseMarker(string $word): bool
    {
        return $this->excuse_markers->contains($word);
    }

    /**
     * @return Collection<int, string>
     */
    public function pronouns(): Collection
    {
        return $this->pronouns;
    }

    public function rules(): RuleCollection
    {
        return $this->rules;
    }

    private function loadContexts(): void
    {
        foreach ($this->data['contexts'] as $type => $data) {
            $contextType = ContextType::tryFrom($type);
            if (null === $contextType) {
                continue;
            }

            $this->contexts->add(new Context($contextType, $data['markers'], $data['whitelist']));
        }
    }

    private function loadRules(): void
    {
        foreach ($this->data['rules'] as $rule) {
            if (is_callable($rule)) {
                $this->rules->add($rule);
                continue;
            }

            if (is_string($rule)) {
                /** @var Rule $rule */
                $rule = new $rule();
            }

            $this->rules->add($rule);
        }
    }

    /**
     * @param string[] $words
     * @return bool
     */
    private function detectCommonPhrases(array $words): bool
    {
        // Check for phrases like "excuse my language"
        foreach ($this->excuse_markers as $word) {
            if (in_array($word, $words, true)) {
                return true;
            }
        }

        // Check for quoted content or reported speech
        foreach ($this->quote_markers as $word) {
            if (in_array($word, $words, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $word
     * @param LanguageDetectionDetails $details
     * @return int
     */
    private function analyzeWord(string $word, array &$details): int
    {
        $wordScore = 0;

        // Verificar pronombres (peso muy alto - son muy específicos del idioma)
        if ($this->isPronoun($word)) {
            $wordScore += 10;
            $details['pronouns'][] = $word;
        }

        // Verificar marcadores generales (peso alto)
        if ($this->isMarker($word)) {
            $wordScore += 5;
            $details['markers'][] = $word;
        }

        // Verificar intensificadores (peso medio)
        if ($this->isIntensifier($word)) {
            $wordScore += 3;
            $details['intensifiers'][] = $word;
        }

        // Verificar modificadores (peso medio)
        if ($this->isModifier($word)) {
            $wordScore += 3;
            $details['modifiers'][] = $word;
        }

        // Verificar marcadores de cita (peso bajo)
        if ($this->isQuoteMarker($word)) {
            $wordScore += 2;
            $details['quotes'][] = $word;
        }

        // Verificar marcadores de disculpa (peso bajo)
        if ($this->isExcuseMarker($word)) {
            $wordScore += 2;
            $details['excuses'][] = $word;
        }

        // Si la palabra tiene alguna puntuación, considerarla una palabra común del idioma
        if ($wordScore > 0) {
            $details['common_words'][] = $word;
        }

        return $wordScore;
    }

    /**
     * @param Collection<int,non-falsy-string> $words
     * @param LanguageDetectionDetails $details
     * @return Confidence
     */
    private function calculateConfidence(Collection $words, array $details): Confidence
    {
        $elementRatio = $words->count() > 0
            ? count($details['common_words']) / $words->count()
            : 0;

        $pronounFactor = min(1.0, count($details['pronouns']) / 5);
        $confidence = ($elementRatio * 0.7) + ($pronounFactor * 0.3);

        if ($details['total_language_elements'] < 3) {
            $confidence *= 0.5;
        }

        return new Confidence($confidence);
    }

    /**
     * @param Collection<int, non-falsy-string> $words
     * @param LanguageDetectionDetails $details
     * @param int $rawScore
     * @return Score
     */
    private function calculateScore(Collection $words, array $details, int $rawScore): Score
    {
        $maxTheoreticalScore = $words->count() * 10;
        $normalizedScore = $maxTheoreticalScore > 0
            ? $rawScore / $maxTheoreticalScore
            : 0;

        $adjustedScore = min(1.0, sqrt($normalizedScore));
        $pronounBoost = count($details['pronouns']) > 0
            ? min(0.2, count($details['pronouns']) / 20)
            : 0;

        $finalScore = min(1.0, $adjustedScore + $pronounBoost);
        if ($words->count() < 5) {
            $finalScore *= 0.7;
        }

        return new Score($finalScore);
    }
}
