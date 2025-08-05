<?php

namespace Ninja\Sentinel\Language;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\ContextType;
use Ninja\Sentinel\Language\Contracts\Context as ContextContract;

readonly class Context implements ContextContract
{
    /**
     * @param string[] $markers
     * @param string[] $whitelist
     */
    public function __construct(private ContextType $type, private array $markers, private array $whitelist) {}

    /** {@inheritDoc} */
    public function getContextType(): ContextType
    {
        return $this->type;
    }

    /** {@inheritDoc} */
    public function markers(): Collection
    {
        return new Collection($this->markers);
    }

    /** {@inheritDoc} */
    public function whitelist(): Collection
    {
        return new Collection($this->whitelist);
    }

    /** {@inheritDoc} */
    public function isSafe(string $fullText, string $word, string $offensiveRoot, int $position, array $words): bool
    {
        $lowerWord = mb_strtolower($word);

        // REG_EX 1: Si la palabra encontrada en el texto NO es la palabra ofensiva del diccionario
        // (ej. palabra="assignment", raíz ofensiva="ass"), SOLO es segura si la palabra completa
        // ("assignment") está explícitamente en la whitelist de ESTE contexto.
        if ($lowerWord !== $offensiveRoot) {
            return in_array($lowerWord, $this->whitelist, true);
        }

        // REG_EX 2: Si la palabra encontrada ES la palabra ofensiva (ej. "sexual"),
        // se considera segura si está en la whitelist O si está rodeada de marcadores de contexto.
        if (in_array($lowerWord, $this->whitelist, true)) {
            return true;
        }

        $contextWindow = 20;
        $start = max(0, $position - $contextWindow);
        $end = min(count($words) - 1, $position + $contextWindow);

        for ($i = $start; $i <= $end; $i++) {
            if ($i === $position) {
                continue;
            }

            $contextWord = mb_strtolower($words[$i]);
            if (in_array($contextWord, $this->markers, true)) {
                return true;
            }
        }

        return false;
    }
}
