<?php

use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Language\Rules\Fr\VerbConjugationRule;

describe('VerbConjugationRule (French)', function (): void {
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
        ], LanguageCode::French);

        $this->rule = new VerbConjugationRule();
    });

    it('generates verb conjugation variants', function (): void {
        $variants = $this->rule->__invoke('parler', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('generates past participle variants', function (): void {
        $variants = $this->rule->__invoke('aimer', $this->language);

        expect($variants->contains('aimé'))->toBeTrue();
    });

    it('generates gerund variants', function (): void {
        $variants = $this->rule->__invoke('manger', $this->language);

        expect($variants->contains('mangeant'))->toBeTrue();
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
        $variants = $this->rule->__invoke('être', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('handles empty word', function (): void {
        $variants = $this->rule->__invoke('', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });
});
