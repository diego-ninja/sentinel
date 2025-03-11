<?php

namespace Ninja\Sentinel\Language\Collections;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\DTO\DetectionResult;
use Ninja\Sentinel\Language\Exceptions\LanguageFileNotFound;
use Ninja\Sentinel\Language\Language;

/**
 * Collection of languages.
 *
 * @extends Collection<int, Language>
 */
class LanguageCollection extends Collection
{
    /**
     * Load languages from configuration.
     *
     * @param string[]|null $codes
     * @throws LanguageFileNotFound
     */
    public static function fromConfig(?array $codes = null): self
    {
        $collection = new self();

        $languages = self::getSupportedLanguages($codes);
        foreach ($languages as $languageCode) {
            $collection->add(self::loadLanguage($languageCode));
        }

        return $collection;
    }
    /**
     * Detects the language of a given text.
     *
     * @param string $text The text to analyze
     * @return Collection<int, DetectionResult> The detected languages
     */
    public function detect(string $text): Collection
    {
        $results = new Collection();
        $this->each(function (Language $item) use (&$results, $text): void {
            $results->push($item->detect($text));
        });

        return $results;
    }

    public function findByCode(LanguageCode $code): ?Language
    {
        return $this->first(fn(Language $language) => $language->code->value === $code->value);
    }

    public function bestFor(string $text): ?Language
    {
        if (1 === $this->count()) {
            return $this->first();
        }

        $results = $this->detect($text);
        $bestResult = $results->sortByDesc(fn(DetectionResult $result) => $result->score)->first();
        if (null === $bestResult) {
            /** @var string $defaultLanguage */
            $defaultLanguage = config('sentinel.default_language', 'en');

            return $this->findByCode(LanguageCode::from($defaultLanguage));
        }

        return $this->findByCode($bestResult->code);
    }

    /**
     * Get the supported languages for language analysis.
     *
     * @param string[] $codes
     * @return LanguageCode[] List of supported language codes
     */
    private static function getSupportedLanguages(?array $codes): array
    {
        $languagePath = resource_path('language');
        if ( ! is_dir($languagePath)) {
            return [LanguageCode::English]; // Default if directory doesn't exist
        }

        $files = scandir($languagePath);
        if (false === $files) {
            return [LanguageCode::English];
        }

        $languages = [];
        foreach ($files as $file) {
            if (preg_match('/^([a-z]{2})\.php$/', $file, $matches)) {
                if (null === $codes || in_array($matches[1], $codes)) {
                    $languages[] = LanguageCode::from($matches[1]);
                }
            }
        }

        return ! empty($languages) ? $languages : [LanguageCode::English];
    }
    private static function getLanguagePath(LanguageCode $language): string
    {
        return resource_path(sprintf('language/%s.php', $language->value));
    }

    /**
     * @throws LanguageFileNotFound
     */
    private static function loadLanguage(LanguageCode $code): Language
    {
        $languagePath = self::getLanguagePath($code);

        if ( ! file_exists($languagePath)) {
            if (LanguageCode::English !== $code) {
                return self::loadLanguage(LanguageCode::English);
            }

            throw LanguageFileNotFound::forLanguage($code);
        }

        /** @var array{
         * words: array{
         * offensive: array<int, string>,
         * intensifiers: array<int, string>,
         * modifiers: array{
         * negative: array<int, string>,
         * positive: array<int, string>
         * },
         * quote: array<int, string>,
         * excuse: array<int, string>
         * },
         * pronouns: array<int, string>,
         * prefixes: array<int, string>,
         * suffixes: array<int, string>,
         * markers: array<int, string>,
         * contexts: array<string, array{
         * markers: array<int, string>,
         * whitelist: array<int, string>
         * }>,
         * patterns: array{
         * word_specific: array<string, array<int, string>>
         * }
         * } $data */
        $data = include $languagePath;
        return new Language($data, $code);
    }
}
