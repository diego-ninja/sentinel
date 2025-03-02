# Usage

## Facade Methods

Sentinel provides multiple ways to interact with content moderation:

### Basic Offensive Check

```php
use Ninja\Sentinel\Facades\Sentinel;

// Check if text is offensive
$isOffensive = Sentinel::offensive('Some potentially offensive text');
```

### Cleaning Text

```php
// Remove offensive content
$cleanText = Sentinel::clean('Some potentially offensive text');
```

## Contextual Analysis

Provide additional context for more nuanced analysis:

```php
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\Audience;

$result = Sentinel::check(
    'Some text', 
    ContentType::Educational, 
    Audience::Professional
);

// Check if offensive
$isOffensive = $result->offensive();

// Get cleaned text
$cleanedText = $result->replaced();

// Get offensive words
$offensiveWords = $result->words();

// Get detailed match information
$matches = $result->matches();
```

## Helper Functions

Simple global helper functions are also available:

```php
// Check if text is offensive
$isOffensive = is_offensive('Some text');

// Clean offensive content
$cleanText = clean('Some text');
```

## Validation Rule

Use as a Laravel validation rule:

```php
$rules = [
    'comment' => ['required', 'string', 'offensive']
];
```

## Specific Service Provider

Choose a specific content moderation service:

```php
use Ninja\Sentinel\Enums\Provider;

$result = Sentinel::with(Provider::Prism, 'Some text');
```

## Accessing Detailed Results

```php
$result = Sentinel::check('Some text');

// Sentiment analysis
$sentiment = $result->sentiment();
$sentimentType = $sentiment->type(); // Positive, Negative, etc.
$sentimentScore = $sentiment->value(); // -1.0 to 1.0

// Content categories
$categories = $result->categories();

// Confidence and scoring
$score = $result->score();
$confidence = $result->confidence();
```

## Error Handling

Sentinel uses Laravel's exception handling:

```php
try {
    $result = Sentinel::check($text);
} catch (\Exception $e) {
    // Handle any service-related errors
    Log::error('Moderation failed: ' . $e->getMessage());
}
```
