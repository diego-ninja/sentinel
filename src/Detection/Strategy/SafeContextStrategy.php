<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Context;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;

/**
 * Strategy for detecting potentially offensive terms in safe/legitimate contexts
 * to reduce false positives by assigning negative scores to these matches.
 */
final class SafeContextStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 1.5;

    /**
     * Negative score value for safe language matches
     */
    private const float SAFE_CONTEXT_SCORE = -0.4;

    /**
     * Confidence value for safe language detection
     */
    private const float SAFE_CONTEXT_CONFIDENCE = 0.85;


    /**
     * Detect potentially offensive terms in safe contexts
     *
     * @param string $text Text to analyze
     * @param Language|null $language |null Language for text
     * @return MatchCollection Collection of matches in safe contexts
     */
    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        // 1. Usamos preg_match_all para obtener todas las "palabras" y su posición (offset) exacta.
        // Esto soluciona el problema de las palabras repetidas.
        preg_match_all('/[\p{L}\p{N}]+/u', $text, $textWords, PREG_OFFSET_CAPTURE);

        if (empty($textWords[0])) {
            return $matches;
        }

        // Creamos un array de palabras para pasarlo a isSafe
        $allWords = array_column($textWords[0], 0);

        // Iteramos sobre las palabras encontradas con su offset
        foreach ($textWords[0] as $position => [$textWord, $startPos]) {
            $cleanWord = mb_strtolower($textWord);

            if (mb_strlen($cleanWord) < 3) {
                continue;
            }

            // Check if this is a potentially offensive word
            foreach ($language->words() as $offensiveWord) {
                $offensiveWord = mb_strtolower($offensiveWord);

                // Comprobamos si la palabra limpia es o contiene una palabra ofensiva
                if ($cleanWord === $offensiveWord || false !== mb_strpos($cleanWord, $offensiveWord)) {
                    // Si es potencialmente ofensiva, revisamos los contextos de lenguaje seguro
                    foreach ($language->contexts() as $context) {
                        /** @var Context $context */
                        if ($context->isSafe($text, $cleanWord, $position, $allWords)) {
                            $occurrences = new OccurrenceCollection([
                                // Usamos la posición y longitud correctas obtenidas de preg_match_all
                                new Position($startPos, mb_strlen($textWord)),
                            ]);

                            // Add as a match with safe language flag and negative score to counteract
                            $matches->addCoincidence(
                                new Coincidence(
                                    word: $textWord,
                                    type: MatchType::SafeContext,
                                    score: new Score(self::SAFE_CONTEXT_SCORE),
                                    confidence: new Confidence(self::SAFE_CONTEXT_CONFIDENCE),
                                    occurrences: $occurrences,
                                    language: $language->code(),
                                    context: [
                                        'safe_context' => true,
                                        'original' => $offensiveWord,
                                        'context_type' => $context->getContextType(),
                                    ],
                                ),
                            );

                            // 2. **LA CLAVE DEL ARREGLO**:
                            // Una vez encontrada una coincidencia segura para $textWord,
                            // salimos de los bucles de `contexts` y `words` para pasar
                            // a la siguiente palabra del texto. Esto evita duplicados.
                            continue 3;
                        }
                    }
                }
            }
        }

        return $matches;
    }

    /**
     * Returns the weight of this strategy
     *
     * @return float Strategy weight
     */
    public function weight(): float
    {
        // This strategy has high weight since it can override other strategies
        return 0.9;
    }
}