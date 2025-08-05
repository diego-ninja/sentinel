# Configuration

## Configuration File

The main configuration file is located at `config/sentinel.php`. Key configuration options include:

### General Settings

```php
return [
    // Default threshold for offensive content
    'threshold_score' => env('SENTINEL_THRESHOLD_SCORE', 0.5),

    // Supported languages
    'languages' => explode(',', env('SENTINEL_LANGUAGES', 'en')),

    // Default service provider
    'default_service' => Ninja\Sentinel\Enums\Provider::Local,

    // Mask character for offensive words
    'mask_char' => env('SENTINEL_MASK_CHAR', '*'),
];
```

## Threshold Configuration

You can define custom thresholds for different contexts:

```php
'thresholds' => [
    'categories' => [
        'hate_speech' => 0.3,
        'sexual' => 0.4,
        'profanity' => 0.6,
    ],
    'content_types' => [
        'social_media' => 0.5,
        'educational' => 0.7,
    ],
    'audiences' => [
        'children' => 0.3,
        'adult' => 0.6,
    ],
],
```

## Character Replacements

Configure character substitutions for obfuscation detection:

```php
'replacements' => [
    'a' => '(a|@|4)',
    'i' => '(i|1|!)',
    // More replacements
],
```

## Dictionary Configuration

Add custom dictionaries in `resources/dict/`:

```php
// resources/dict/custom.php
return [
    'word1',
    'word2',
    // Custom offensive words
];
```

## Whitelist Configuration

Configure words to ignore during moderation:

```php
'whitelist' => [
    'example',
    'words',
],
```

## Service Providers

Configure individual service providers:

```php
'services' => [
    'perspective_ai' => [
        'key' => env('PERSPECTIVE_AI_API_KEY'),
    ],
    'local' => [
        'strategies' => [
            // Detection strategies to use
            Ninja\Sentinel\Detection\Strategy\IndexStrategy::class,
            Ninja\Sentinel\Detection\Strategy\PatternStrategy::class,
            // More strategies
        ],
    ],
],
```

## Caching

Configure caching options:

```php
'cache' => [
    'enabled' => env('SENTINEL_CACHE_ENABLED', true),
    'store' => env('SENTINEL_CACHE_STORE', 'file'),
    'ttl' => env('SENTINEL_CACHE_TTL', 3600),
],
```
