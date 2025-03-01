<?php

namespace Ninja\Sentinel\Context\Detectors;

use Exception;
use Ninja\Sentinel\Context\ContextLoader;
use Ninja\Sentinel\Context\Contracts\ContextDetector;
use Ninja\Sentinel\Context\Enums\ContextType;

abstract readonly class AbstractContextDetector implements ContextDetector
{
    /**
     * Get a category of context data from the language file
     *
     * @param string $language Language code
     * @param string $category Category name in the context file
     * @return mixed The context data
     */
    protected function getContextCategory(string $language, string $category): mixed
    {
        try {
            return ContextLoader::getCategory($language, $category);
        } catch (Exception $e) {
            // Fallback in case of errors with context loading
            return [];
        }
    }

    abstract public function getContextType(): ContextType;
}
