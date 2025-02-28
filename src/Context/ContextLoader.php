<?php

namespace Ninja\Sentinel\Context;

use InvalidArgumentException;
use Ninja\Sentinel\Context\Exceptions\ContextFileNotFound;

/**
 * Class to load and manage contextual data for different languages
 */
final class ContextLoader
{
    /**
     * Cache of loaded context data by language
     *
     * @var array<string, array<string, array<string>>>
     */
    private static array $contextCache = [];

    /**
     * Get all context data for a specific language
     *
     * @param string $language The language code ('en', 'es', 'fr')
     * @return array<string, array<string>> The complete context data for the language
     *
     * @throws ContextFileNotFound If the context file for the language doesn't exist
     */
    public static function getContextForLanguage(string $language): array
    {
        // Return from cache if already loaded
        if (isset(self::$contextCache[$language])) {
            return self::$contextCache[$language];
        }

        // Try to load the context file
        $contextPath = self::getContextPath($language);

        if ( ! file_exists($contextPath)) {
            if ('en' !== $language) {
                return self::getContextForLanguage('en');
            }

            throw ContextFileNotFound::forLanguage($language);
        }

        /** @var array<string, array<string>> $context */
        $context = include $contextPath;

        // Cache the results
        self::$contextCache[$language] = $context;

        return $context;
    }

    /**
     * Get a specific context category for a language
     *
     * @param string $language The language code ('en', 'es', 'fr')
     * @param string $category The context category name
     * @return array<string> The words in the requested category
     *
     * @throws InvalidArgumentException If the category doesn't exist
     */
    public static function getCategory(string $language, string $category): array
    {
        $context = self::getContextForLanguage($language);

        if ( ! isset($context[$category])) {
            // Fall back to English for missing categories
            if ('en' !== $language) {
                return self::getCategory('en', $category);
            }

            throw new InvalidArgumentException("Context category '{$category}' not found for language '{$language}'");
        }

        return $context[$category];
    }

    /**
     * Determine if a language has context support
     *
     * @param string $language The language code to check
     * @return bool True if the language has context support
     */
    public static function hasContextSupport(string $language): bool
    {
        return file_exists(self::getContextPath($language));
    }

    /**
     * Get the supported languages for context analysis
     *
     * @return array<string> List of supported language codes
     */
    public static function getSupportedLanguages(): array
    {
        $contextPath = resource_path('context');
        if ( ! is_dir($contextPath)) {
            return ['en']; // Default if directory doesn't exist
        }

        $files = scandir($contextPath);
        if (false === $files) {
            return ['en'];
        }

        $languages = [];
        foreach ($files as $file) {
            if (preg_match('/^([a-z]{2})\.php$/', $file, $matches)) {
                $languages[] = $matches[1];
            }
        }

        return ! empty($languages) ? $languages : ['en'];
    }

    /**
     * Gets the path to the context file for a language
     *
     * @param string $language The language code
     * @return string The full path to the context file
     */
    private static function getContextPath(string $language): string
    {
        return resource_path(sprintf('context/%s.php', $language));
    }
}
