<?php

namespace Ninja\Censor\Checkers;

use EchoLabs\Prism\Prism;
use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Contracts\Result;
use Ninja\Censor\Result\PrismResult;
use Ninja\Censor\Schemas\CensorPrismSchema;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

/**
 * LLM-based profanity checker using Laravel Prism.
 */
final readonly class PrismAI implements ProfanityChecker
{
    public function __construct(
        private Prism $prism,
    ) {}

    public function check(string $text): Result
    {
        $instructions =
            'Analyze the following text for inappropriate content, profanity, and offensive language. '.
            'Consider the context and provide detailed detection results. '.
            'Pay attention to attempted obfuscation or creative spelling of offensive words. '.
            'Only mark content as offensive if it would be inappropriate in a professional context.';

        $response = $this->prism->structured()
            ->using(
                provider: config('censor.services.prism.provider'),
                model: config('censor.services.prism.model')
            )
            ->withSystemPrompt($instructions)
            ->withSchema(new CensorPrismSchema)
            ->withPrompt($text)
            ->generate();

        /** @var array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float} $data */
        $data = $response->structured;

        // Map categories from response to internal categories
        $categories = array_map(
            function (string $category) {
                return match (strtolower($category)) {
                    'hate_speech', 'hate' => Category::HateSpeech,
                    'harassment' => Category::Harassment,
                    'sexual', 'adult' => Category::Sexual,
                    'violence' => Category::Violence,
                    'threat' => Category::Threat,
                    'toxicity' => Category::Toxicity,
                    default => Category::Profanity
                };
            },
            array_unique($data['categories'])
        );

        return new PrismResult(
            offensive: $data['is_offensive'],
            words: $data['offensive_words'],
            replaced: $this->replaceWords($text, $data['offensive_words']),
            original: $text,
            matches: null,
            score: new Score($data['severity']),
            confidence: new Confidence($data['confidence']),
            categories: $categories
        );
    }

    /**
     * Replace offensive words with asterisks
     *
     * @param  string  $text  Original text
     * @param  array<string>  $words  List of words to replace
     * @return string Text with offensive words replaced
     */
    private function replaceWords(string $text, array $words): string
    {
        $replaced = $text;
        foreach ($words as $word) {
            $replaced = str_replace(
                $word,
                str_repeat('*', mb_strlen($word)),
                $replaced
            );
        }

        return $replaced;
    }
}
