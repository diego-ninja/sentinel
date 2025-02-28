<?php

namespace Ninja\Sentinel\Support;

use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;

/**
 * Manages dynamic thresholds for offensive content detection
 */
final class ThresholdManager
{
    /**
     * Default threshold value
     */
    private const float DEFAULT_THRESHOLD = 0.5;

    /**
     * Get the threshold for specific content
     *
     * @param array<Category> $categories Content categories if available
     * @param ContentType|null $contentType Content type if available
     * @param Audience|null $audience Target audience if available
     * @return float The appropriate threshold value
     */
    public static function getThreshold(
        array        $categories = [],
        ?ContentType $contentType = null,
        ?Audience    $audience = null,
    ): float {
        if (null !== $audience) {
            return $audience->threshold();
        }

        if (null !== $contentType) {
            return $contentType->threshold();
        }

        if ( ! empty($categories)) {
            $lowestThreshold = 1.0;

            foreach ($categories as $category) {
                $lowestThreshold = min($lowestThreshold, $category->threshold());
            }

            return $lowestThreshold;
        }

        /** @var float  $threshold */
        $threshold = config('sentinel.threshold_score', self::DEFAULT_THRESHOLD);
        return $threshold;
    }
}
