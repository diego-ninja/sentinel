<?php

namespace Ninja\Sentinel\Detection\Strategy;

use InvalidArgumentException;
use Ninja\Sentinel\Cache\Contracts\PatternCache;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
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
    }

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        // Guardar palabras originales para verificar después
        $this->originalWords = is_array($words) ? $words : iterator_to_array($words);

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
                            score: Calculator::score($text, $match, MatchType::Pattern, $occurrences),
                            confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                            occurrences: $occurrences,
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
                                score: Calculator::score($text, $match, MatchType::Pattern, $occurrences),
                                confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                                occurrences: $occurrences,
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
        // Si la coincidencia es demasiado corta, no es relevante
        if (mb_strlen($match) < 3) {
            // Excepto si es exactamente una palabra del diccionario
            return in_array(mb_strtolower($match), array_map('mb_strtolower', $this->originalWords));
        }

        // Para coincidencias más largas, verificar si podría ser una variación de alguna palabra
        $matchLower = mb_strtolower($match);
        foreach ($this->originalWords as $word) {
            $wordLower = mb_strtolower($word);

            // Si es igual o contiene la palabra, es relevante
            if ($matchLower === $wordLower || false !== mb_strpos($matchLower, $wordLower)) {
                return true;
            }

            // Calcular la similitud (solapamiento) entre las dos palabras
            $similarity = similar_text($matchLower, $wordLower, $percent);
            if ($percent > 65) {  // 65% de similitud es un buen umbral
                return true;
            }
        }

        return false;
    }
}
