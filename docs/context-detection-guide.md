# Context Detection

## Overview

Context detection is a sophisticated mechanism to reduce false positives by understanding the surrounding text and intent.

## Context Detector Types

### 1. Educational Context Detector
- Identifies academic and scientific contexts
- Recognizes legitimate use of potentially offensive terms
- Checks surrounding words for educational markers

```php
$detector = new EducationalContextDetector();
$isInContext = $detector->isInContext(
    $fullText, 
    $word, 
    $position, 
    $words, 
    $language
);
```

### 2. Quoted Context Detector
- Detects words within quotation marks
- Recognizes reported speech
- Identifies attribution verbs

```php
$detector = new QuotedContextDetector();
$isInQuotedContext = $detector->isInContext(
    $fullText, 
    $word, 
    $position, 
    $words, 
    $language
);
```

### 3. Technical Context Detector
- Identifies technical and professional terminology
- Recognizes domain-specific word usage
- Prevents flagging of legitimate technical terms

```php
$detector = new TechnicalContextDetector();
$isInTechnicalContext = $detector->isInContext(
    $fullText, 
    $word, 
    $position, 
    $words, 
    $language
);
```

### 4. Word-Specific Context Detector
- Handles context for specific problematic words
- Uses regex patterns for complex context matching
- Prevents false positives for words with multiple meanings

## Configuring Context Detection

Update configuration in `config/sentinel.php`:

```php
'language' => [
    'enabled' => true,
    'detectors' => [
        EducationalContextDetector::class,
        QuotedContextDetector::class,
        // Add or remove detectors
    ],
],
```

## Creating Custom Context Detectors

Implement a custom context detector:

```php
use Ninja\Sentinel\Context\Contracts\ContextDetector;use Ninja\Sentinel\Enums\ContextType;

class CustomContextDetector implements ContextDetector
{
    public function isInContext(
        string $fullText, 
        string $word, 
        int $position, 
        array $words, 
        string $language
    ): bool {
        // Custom language detection logic
        return false;
    }

    public function getContextType(): ContextType
    {
        return ContextType::Custom;
    }
}
```

## Context Score Modification

Contexts can modify the offensive score:

```php
$contextModifier = ContextModifier::getContextModifier(
    $text,
    $position->start(),
    $position->length(),
    $language
);

// Modifier < 1 reduces score
// Modifier > 1 increases score
$adjustedScore = $originalScore * $contextModifier;
```

## Language-Specific Context

Different languages have unique context markers:

```php
// En language markers
$educationalMarkers = [
    'research', 'study', 'analysis', 
    'academic', 'scientific', // ...
];

// Spanish language markers
$spanishEducationalMarkers = [
    'investigación', 'estudio', 'análisis', 
    'académico', 'científico', // ...
];
```

## Performance Considerations

- Context detection is computationally expensive
- Use caching to improve performance
- Configure context window size

```php
'language' => [
    'window_size' => 10, // Words before/after to analyze
    'cache_enabled' => true,
],
```

## Best Practices

1. Regularly update context dictionaries
2. Test with diverse input scenarios
3. Balance detection accuracy with performance
4. Consider language-specific nuances
5. Use logging to understand context decisions

## Debugging Context Detection

Enable detailed logging:

```php
config(['sentinel.language.debug' => true]);
```

This provides insights into:
- Context detection decisions
- Matched context markers
- Score modifications
- Detailed reasoning
