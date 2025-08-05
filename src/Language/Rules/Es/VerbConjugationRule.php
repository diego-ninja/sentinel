<?php

namespace Ninja\Sentinel\Language\Rules\Es;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class VerbConjugationRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();

        if ( ! $this->isVerb($word)) {
            return $variants;
        }

        // Formas no personales
        $variants->push($word); // Infinitivo
        $this->addRegularParticiple($word, $variants);
        $this->addRegularGerund($word, $variants);

        return $variants->unique();
    }
    public function name(): string
    {
        return 'conjugation';
    }

    /**
     * @param string $word
     * @param Collection<int, string> $variants
     * @return void
     */
    private function addRegularParticiple(string $word, Collection $variants): void
    {
        $base = mb_substr($word, 0, -2);
        $lastTwoChars = mb_substr($word, -2);
        if ('ar' === $lastTwoChars) {
            $variants->push(mb_substr($base, 0, -2) . 'ado');
            $variants->push(mb_substr($base, 0, -2) . 'ada');
        }

        if (in_array($lastTwoChars, ['er', 'ir'])) {
            $variants->push(mb_substr($base, 0, -2) . 'ido');
            $variants->push(mb_substr($base, 0, -2) . 'ida');
        }
    }

    /**
     * @param string $word
     * @param Collection<int, string> $variants
     * @return void
     */
    private function addRegularGerund(string $word, Collection $variants): void
    {
        $base = mb_substr($word, 0, -2);
        $lastTwoChars = mb_substr($word, -2);

        // Gerundios
        if ('ar' === $lastTwoChars) {
            $variants->push($base . 'ando');
        } elseif (in_array($lastTwoChars, ['er', 'ir'])) {
            $variants->push($base . 'iendo');
        } else {
            if (in_array(mb_substr($word, -3), ['aer', 'eer', 'oír', 'eír'])) {
                $variants->push($base . 'yendo');
            } else {
                $variants->push($base . 'iendo');
            }
        }
    }

    private function isVerb(string $word): bool
    {
        $lastTwoChars = mb_substr($word, -2);
        return in_array($lastTwoChars, ['ar', 'er', 'ir']);
    }
}
