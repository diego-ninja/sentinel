<?php

namespace Ninja\Sentinel\Context;

use Ninja\Sentinel\Context\Contracts\ContextDetector;
use Ninja\Sentinel\Context\Detectors\EducationalContextDetector;
use Ninja\Sentinel\Context\Detectors\QuotedContextDetector;
use Ninja\Sentinel\Context\Detectors\TechnicalContextDetector;
use Ninja\Sentinel\Context\Detectors\WordSpecificContextDetector;
use Ninja\Sentinel\Context\Enums\ContextType;

/**
 * Factory for creating and retrieving context detectors
 */
final class ContextDetectorFactory
{
    /**
     * @var array<string, ContextDetector>
     */
    private array $detectors = [];

    /**
     * Get all available context detectors
     *
     * @return array<ContextDetector>
     */
    public function getDetectors(): array
    {
        if (empty($this->detectors)) {
            $this->initializeDetectors();
        }

        return array_values($this->detectors);
    }

    /**
     * Get a specific detector by type
     *
     * @param ContextType $type The detector type
     * @return ContextDetector|null The detector or null if not found
     */
    public function getDetector(ContextType $type): ?ContextDetector
    {
        if (empty($this->detectors)) {
            $this->initializeDetectors();
        }

        return $this->detectors[$type->value] ?? null;
    }

    /**
     * Initialize all built-in detectors
     */
    private function initializeDetectors(): void
    {
        /** @var array<class-string<ContextDetector>> $detectorClasses */
        $detectorClasses = [
            EducationalContextDetector::class,
            QuotedContextDetector::class,
            TechnicalContextDetector::class,
            WordSpecificContextDetector::class,
        ];

        foreach ($detectorClasses as $class) {
            $detector = new $class();
            $this->detectors[$detector->getContextType()->value] = $detector;
        }
    }
}