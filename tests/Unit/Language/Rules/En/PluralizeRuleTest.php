<?php

use Ninja\Sentinel\Language\Rules\En\PluralizeRule;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Enums\LanguageCode;

describe('PluralizeRule (English)', function () {
    beforeEach(function () {
        $this->language = new Language([
            'words' => [
                'offensive' => [],
                'intensifiers' => [],
                'modifiers' => ['negative' => [], 'positive' => []],
                'quote' => [],
                'excuse' => []
            ],
            'pronouns' => [],
            'prefixes' => [],
            'suffixes' => [],
            'markers' => [],
            'contexts' => [],
            'patterns' => ['word_specific' => []],
            'rules' => []
        ], LanguageCode::English);

        $this->rule = new PluralizeRule();
    });

    it('generates plural variants', function () {
        $variants = $this->rule->__invoke('word', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($variants->count())->toBeGreaterThan(0);
        expect($variants->contains('words'))->toBeTrue();
    });

    it('handles words ending in s, x, z, ch, sh', function () {
        $variants = $this->rule->__invoke('box', $this->language);
        expect($variants->contains('boxes'))->toBeTrue();

        $variants = $this->rule->__invoke('church', $this->language);
        expect($variants->contains('churches'))->toBeTrue();

        $variants = $this->rule->__invoke('wash', $this->language);
        expect($variants->contains('washes'))->toBeTrue();
    });

    it('handles words ending in y', function () {
        $variants = $this->rule->__invoke('city', $this->language);
        expect($variants->contains('cities'))->toBeTrue();

        $variants = $this->rule->__invoke('boy', $this->language);  
        expect($variants->contains('boys'))->toBeTrue();
    });

    it('handles words ending in f or fe', function () {
        $variants = $this->rule->__invoke('leaf', $this->language);
        expect($variants->contains('leaves'))->toBeTrue();

        $variants = $this->rule->__invoke('knife', $this->language);
        expect($variants->contains('knives'))->toBeTrue();
    });

    it('handles words ending in o', function () {
        $variants = $this->rule->__invoke('hero', $this->language);
        expect($variants->contains('heroes'))->toBeTrue();

        $variants = $this->rule->__invoke('photo', $this->language);
        expect($variants->contains('photos'))->toBeTrue();
    });

    it('returns unique variants only', function () {
        $variants = $this->rule->__invoke('test', $this->language);

        $originalCount = $variants->count();
        $uniqueCount = $variants->unique()->count();

        expect($originalCount)->toBe($uniqueCount);
    });

    it('has correct rule name', function () {
        expect($this->rule->name())->toBe('pluralize');
    });

    it('handles irregular plurals', function () {
        $variants = $this->rule->__invoke('child', $this->language);
        expect($variants->contains('children'))->toBeTrue();

        $variants = $this->rule->__invoke('mouse', $this->language);
        expect($variants->contains('mice'))->toBeTrue();

        $variants = $this->rule->__invoke('foot', $this->language);
        expect($variants->contains('feet'))->toBeTrue();
    });

    it('handles empty word', function () {
        $variants = $this->rule->__invoke('', $this->language);

        expect($variants)->toBeInstanceOf(Illuminate\Support\Collection::class);
    });
});