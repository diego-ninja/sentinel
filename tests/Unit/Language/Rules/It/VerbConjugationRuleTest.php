<?php

use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Language\Rules\It\VerbConjugationRule;

describe('VerbConjugationRule (Italian)', function (): void {
    beforeEach(function (): void {
        $this->language = new Language([
            'words' => [
                'offensive' => [],
                'intensifiers' => [],
                'modifiers' => ['negative' => [], 'positive' => []],
                'quote' => [],
                'excuse' => [],
            ],
            'pronouns' => [],
            'prefixes' => [],
            'suffixes' => [],
            'markers' => [],
            'contexts' => [],
            'patterns' => ['word_specific' => []],
            'rules' => [],
        ], LanguageCode::Italian);

        $this->rule = new VerbConjugationRule();
    });

    it('generates verb conjugation variants', function (): void {
        $variants = $this->rule->__invoke('parlare', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('generates past participle variants', function (): void {
        $variants = $this->rule->__invoke('amare', $this->language);

        expect($variants->contains('amareato'))->toBeTrue();
    });

    it('generates gerund variants', function (): void {
        $variants = $this->rule->__invoke('mangiare', $this->language);

        expect($variants->contains('mangiareando'))->toBeTrue();
    });

    it('returns unique variants only', function (): void {
        $variants = $this->rule->__invoke('test', $this->language);

        $originalCount = $variants->count();
        $uniqueCount = $variants->unique()->count();

        expect($originalCount)->toBe($uniqueCount);
    });

    it('has correct rule name', function (): void {
        expect($this->rule->name())->toBe('conjugation');
    });

    it('handles short words', function (): void {
        $variants = $this->rule->__invoke('essere', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('handles empty word', function (): void {
        $variants = $this->rule->__invoke('', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });
});
