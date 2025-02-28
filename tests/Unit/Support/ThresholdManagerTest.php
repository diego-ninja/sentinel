<?php

namespace Tests\Unit\Support;

use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Support\ThresholdManager;

test('threshold manager returns default threshold when no context is provided', function (): void {
    // Mock the config to return a known value
    config(['sentinel.threshold_score' => 0.55]);

    $threshold = ThresholdManager::getThreshold();

    expect($threshold)->toBe(0.55);
});

test('threshold manager returns category-specific threshold', function (): void {
    // Mock the config for categories
    config([
        'sentinel.thresholds.categories' => [
            'hate_speech' => 0.3,
            'toxicity' => 0.5,
        ],
    ]);

    $threshold = ThresholdManager::getThreshold([Category::HateSpeech]);

    expect($threshold)->toBe(0.3);
});

test('threshold manager returns lowest threshold when multiple categories provided', function (): void {
    // Mock the config for categories
    config([
        'sentinel.thresholds.categories' => [
            'hate_speech' => 0.3,
            'toxicity' => 0.5,
            'profanity' => 0.6,
        ],
    ]);

    $threshold = ThresholdManager::getThreshold([
        Category::HateSpeech,
        Category::Toxicity,
        Category::Profanity,
    ]);

    // Should return the lowest (most strict) threshold
    expect($threshold)->toBe(0.3);
});

test('threshold manager returns content-type threshold', function (): void {
    // Mock the config for content types
    config([
        'sentinel.thresholds.content_types' => [
            'educational' => 0.7,
            'social_media' => 0.5,
        ],
    ]);

    $threshold = ThresholdManager::getThreshold([], ContentType::Educational);

    expect($threshold)->toBe(0.7);
});

test('threshold manager gives priority to audience type', function (): void {
    // Mock the config
    config([
        'sentinel.thresholds.categories' => [
            'hate_speech' => 0.3,
        ],
        'sentinel.thresholds.content_types' => [
            'educational' => 0.7,
        ],
        'sentinel.thresholds.audiences' => [
            'children' => 0.2,
        ],
    ]);

    // Even with educational content, children's audience takes priority
    $threshold = ThresholdManager::getThreshold(
        [Category::HateSpeech],
        ContentType::Educational,
        Audience::Children,
    );

    expect($threshold)->toBe(0.2);
});
