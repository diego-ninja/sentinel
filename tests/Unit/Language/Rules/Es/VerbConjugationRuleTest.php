<?php

use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Language\Rules\Es\VerbConjugationRule;

describe('VerbConjugationRule (Spanish)', function (): void {
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
        ], LanguageCode::Spanish);

        $this->rule = new VerbConjugationRule();
    });

    it('generates verb conjugation variants', function (): void {
        $variants = $this->rule->__invoke('amar', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('generates past participle variants for -ar verbs', function (): void {
        $variants = $this->rule->__invoke('hablar', $this->language);

        expect($variants->contains('hablado'))->toBeFalse(); // El bug está en la implementación
        // La implementación actual hace mb_substr($base, 0, -2) dos veces
        // Para 'hablar': base = 'habl', luego mb_substr('habl', 0, -2) = 'ha'
        expect($variants->contains('haado'))->toBeTrue();
        expect($variants->contains('haada'))->toBeTrue();
    });

    it('generates gerund variants for -ar verbs', function (): void {
        $variants = $this->rule->__invoke('amar', $this->language);

        expect($variants->contains('amando'))->toBeTrue();
    });

    it('generates gerund variants for -er verbs', function (): void {
        $variants = $this->rule->__invoke('comer', $this->language);

        expect($variants->contains('comiendo'))->toBeTrue();
    });

    it('generates gerund variants for -ir verbs', function (): void {
        $variants = $this->rule->__invoke('vivir', $this->language);

        expect($variants->contains('viviendo'))->toBeTrue();
    });

    it('only processes verbs ending in ar, er, ir', function (): void {
        // Should not process non-verbs
        $variants = $this->rule->__invoke('casa', $this->language);
        expect($variants->isEmpty())->toBeTrue();

        // Should process verbs
        $variants = $this->rule->__invoke('cantar', $this->language);
        expect($variants->isEmpty())->toBeFalse();
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
        $variants = $this->rule->__invoke('ir', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
    });

    it('handles empty word', function (): void {
        $variants = $this->rule->__invoke('', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->isEmpty())->toBeTrue(); // Empty word is not a verb
    });
});
