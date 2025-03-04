<?php

namespace Ninja\Sentinel\Detection\Strategy;

use InvalidArgumentException;
use Ninja\Sentinel\Cache\Contracts\PatternCache;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\Support\PatternGenerator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class PatternStrategy extends AbstractStrategy
{
    /** @var array<string> */
    private array $patterns;

    /** @var array<string> */
    private array $partialPatterns;

    /** @var array<string> */
    private array $originalWords;

    public function __construct(
        protected LanguageCollection $languages,
        private readonly PatternGenerator $generator,
        private readonly PatternCache $cache,
    ) {
        $this->patterns = $this->generator->getPatterns();

        // Generar patrones sin límites de palabra para detectar combinaciones
        $partialGenerator = clone $this->generator;
        $partialGenerator->setFullWords(false);
        $this->partialPatterns = $partialGenerator->getPatterns();

        $this->originalWords = [];

        foreach ($this->patterns as $pattern) {
            if (false === @preg_match($pattern, '')) {
                throw new InvalidArgumentException("Invalid regex pattern: {$pattern}");
            }

            $this->cache->set(md5($pattern), $pattern);
        }

        foreach ($this->partialPatterns as $pattern) {
            if (false === @preg_match($pattern, '')) {
                continue;
            }

            $this->cache->set(md5($pattern) . '_partial', $pattern);
        }

        parent::__construct($this->languages);
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        // Guardar palabras originales para verificar después
        $this->originalWords = iterator_to_array($language->words());

        // Primero intenta con patrones exactos (con límites de palabra)
        foreach ($this->patterns as $pattern) {
            $cachedPattern = $this->cache->get(md5($pattern));
            if (null === $cachedPattern) {
                continue;
            }

            if (preg_match_all($cachedPattern, $text, $found, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($found[0] as [$match, $offset]) {
                    // Verificar que no sea una letra individual
                    if (mb_strlen($match) < 2) {
                        continue;
                    }

                    $occurrences = new OccurrenceCollection([
                        new Position($offset, mb_strlen($match)),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::Pattern,
                            score: Calculator::score($text, $match, MatchType::Pattern, $occurrences, $language),
                            confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: ['pattern' => $pattern],
                        ),
                    );
                }
            }
        }

        // Luego usa patrones parciales (sin límites de palabra estrictos)
        foreach ($this->partialPatterns as $pattern) {
            $cachedPattern = $this->cache->get(md5($pattern) . '_partial');
            if (null === $cachedPattern) {
                continue;
            }

            if (preg_match_all($cachedPattern, $text, $found, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($found[0] as [$match, $offset]) {
                    // Verificar que no sea una letra individual o demasiado corta
                    if (mb_strlen($match) < 2) {
                        continue;
                    }

                    // Verificar que la coincidencia es relevante para alguna palabra en el diccionario
                    if ( ! $this->isRelevantMatch($match)) {
                        continue;
                    }

                    // Verificar que no esté ya incluido en coincidencias exactas
                    $isSubMatch = false;
                    foreach ($matches as $existingMatch) {
                        foreach ($existingMatch->occurrences() as $occurrence) {
                            if ($offset >= $occurrence->start() &&
                                $offset + mb_strlen($match) <= $occurrence->start() + $occurrence->length()) {
                                $isSubMatch = true;
                                break 2;
                            }
                        }
                    }

                    if ( ! $isSubMatch) {
                        $occurrences = new OccurrenceCollection([
                            new Position($offset, mb_strlen($match)),
                        ]);

                        $matches->addCoincidence(
                            new Coincidence(
                                word: $match,
                                type: MatchType::Pattern,
                                score: Calculator::score($text, $match, MatchType::Pattern, $occurrences, $language),
                                confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                                occurrences: $occurrences,
                                language: $language->code(),
                                context: ['pattern' => $pattern, 'partial' => true],
                            ),
                        );
                    }
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Pattern->weight();
    }

    /**
     * Determina si una coincidencia es relevante para alguna palabra en el diccionario
     * Evita falsas alarmas con letras individuales o coincidencias parciales no significativas
     *
     * @param string $match La palabra o texto encontrado
     * @return bool
     */
    private function isRelevantMatch(string $match): bool
    {
        if (mb_strlen($match) < 3) {
            return in_array(mb_strtolower($match), array_map('mb_strtolower', $this->originalWords));
        }

        $matchLower = mb_strtolower($match);
        foreach ($this->originalWords as $word) {
            $wordLower = mb_strtolower($word);

            if ($matchLower === $wordLower || false !== mb_strpos($matchLower, $wordLower)) {
                return true;
            }

            $similarity = similar_text($matchLower, $wordLower);
            if ($similarity > 65) {  // 65% de similitud es un buen umbral
                return true;
            }
        }

        return false;
    }
}
