# Advanced Features

## Custom Detection Strategies

Create a custom detection strategy:

```php
use Ninja\Sentinel\Detection\Strategy\AbstractStrategy;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\MatchType;

class CustomDetectionStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        // Implement custom detection logic
        return $matches;
    }

    public function weight(): float
    {
        return 0.8; // Strategy weight
    }
}

// Register in config/sentinel.php
'services' => [
    'local' => [
        'strategies' => [
            CustomDetectionStrategy::class,
            // Other strategies
        ],
    ],
],
```

## Context Detectors

Create a custom context detector:

```php
use Ninja\Sentinel\Context\Contracts\ContextDetector;
use Ninja\Sentinel\Context\Enums\ContextType;

class CustomContextDetector implements ContextDetector
{
    public function isInContext(
        string $fullText, 
        string $word, 
        int $position, 
        array $words, 
        string $language
    ): bool {
        // Implement custom context detection
        return false;
    }

    public function getContextType(): ContextType
    {
        return ContextType::Educational;
    }
}
```

## Custom Dictionary Management

Dynamically manage dictionaries:

```php
use Ninja\Sentinel\Dictionary\LazyDictionary;

// Create a dictionary with custom words
$dictionary = LazyDictionary::withWords([
    'custom', 
    'offensive', 
    'words'
]);

// Add to configuration
config(['sentinel.languages' => ['custom']]);
```

## Extending Providers

Create a custom service provider:

```php
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

class CustomProfanityChecker implements ProfanityChecker
{
    public function __construct(
        private ServiceAdapter $adapter,
        private TransformationPipeline $pipeline
    ) {}

    public function check(
        string $text, 
        ?ContentType $contentType = null, 
        ?Audience $audience = null
    ): Result {
        // Implement custom checking logic
    }
}
```

## Performance Optimization

Configure detection strategies:

```php
'services' => [
    'local' => [
        'strategies' => [
            // Order matters - more precise strategies first
            IndexStrategy::class,
            PatternStrategy::class,
            // Other strategies
        ],
    ],
],
```

## Caching Strategies

Configure caching:

```php
'cache' => [
    'enabled' => true,
    'store' => 'redis', // file, redis, octane
    'ttl' => 3600, // Cache duration in seconds
],
```

## Whitelist Management

Dynamic whitelist handling:

```php
use Ninja\Sentinel\Whitelist;

$whitelist = new Whitelist();
$whitelist->add(['safe', 'words']);

// Check if a word is whitelisted
$whitelist->protected($start, $length);
```

## Multilingual Support

Add custom language dictionaries:

```php
// resources/dict/custom-language.php
return [
    'offensive',
    'words',
    'in',
    'custom',
    'language'
];
```

## Sentiment Analysis Integration

```php
$result = Sentinel::check($text);

// Sentiment details
$sentiment = $result->sentiment();
$type = $sentiment->type(); // Positive, Negative, etc.
$score = $sentiment->value(); // -1.0 to 1.0
```
