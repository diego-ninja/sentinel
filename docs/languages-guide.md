# Multilingual Support

## Overview

Sentinel provides comprehensive multilingual support for content moderation, with sophisticated language-specific detection capabilities.

## Supported Languages

Currently supported languages:
- English (US, UK)
- Spanish
- French
- German
- Italian
- Portuguese
- Dutch
- Finnish

## Language Configuration

Configure languages in `.env`:

```env
# Comma-separated list of languages
SENTINEL_LANGUAGES=en,es,fr,de
```

Or in `config/sentinel.php`:

```php
'languages' => ['en', 'es', 'fr', 'de'],
```

## Dictionary Structure

Each language has two key files:
1. Dictionary file (`resources/dict/{lang}.php`)
2. Context file (`resources/context/{lang}.php`)

### Dictionary File Example

```php
// resources/dict/es.php
return [
    'palabra_ofensiva1',
    'palabra_ofensiva2',
    // More offensive words
];
```

### Context File Components

```php
return [
    // Words that intensify offensive content
    'intensifiers' => [
        'muy', 'realmente', 'jodidamente', // ...
    ],

    // Negative modifier words
    'negative_modifiers' => [
        'odio', 'odiar', 'matar', // ...
    ],

    // Positive modifier words
    'positive_modifiers' => [
        'amor', 'amar', 'gustar', // ...
    ],

    // Educational context markers
    'educational_context' => [
        'investigación', 'estudio', 'análisis', // ...
    ],

    // And more context-specific lists
];
```

## Adding a New Language

### Steps to Add Language Support

1. Create Dictionary File
```php
// resources/dict/new-language.php
return [
    'offensive_word1',
    'offensive_word2',
    // Comprehensive list of offensive words
];
```

2. Create Context File
```php
// resources/context/new-language.php
return [
    'intensifiers' => [ /* context-specific words */ ],
    'negative_modifiers' => [ /* context-specific words */ ],
    // Other context sections
];
```

3. Update Configuration
```php
// config/sentinel.php
'languages' => [
    'en', 'es', 'fr', 'new-language'
],
```

## Language-Specific Strategies

Different languages may require unique detection approaches:

```php
class SpanishDetectionStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        // Language-specific detection logic
        $matches = new MatchCollection();
        
        // Implement Spanish-specific matching
        return $matches;
    }
}
```

## Context Detection Nuances

Languages have unique context markers:

```php
// English context detection
$englishEducationalMarkers = [
    'research', 'study', 'analysis', // ...
];

// Spanish context detection
$spanishEducationalMarkers = [
    'investigación', 'estudio', 'análisis', // ...
];
```

## Performance Considerations

- Use lazy loading for dictionaries
- Cache language-specific patterns
- Optimize regex for each language

```php
$dictionary = LazyDictionary::withLanguages(['en', 'es']);
```

## Advanced Language Handling

### Unicode Support

```php
// Handle Unicode characters
$text = 'Föck this šhit';
$result = Sentinel::check($text);
```

### Multilingual Matching

```php
// Configure multiple language support
config(['sentinel.languages' => ['en', 'es', 'fr']]);
```

## Best Practices

1. Use native speakers for dictionary creation
2. Regularly update dictionaries
3. Consider cultural nuances
4. Test with diverse input scenarios
5. Implement language fallback mechanisms

## Common Challenges

- Handling unicode characters
- Detecting context in different languages
- Managing language-specific variations
- Accounting for cultural differences

## Community Contributions

We welcome contributions to expand language support:
- Add new dictionaries
- Improve context detection
- Share language-specific insights

## Debugging Language Detection

Enable detailed logging:

```php
config(['sentinel.languages.debug' => true]);
```

Provides insights into:
- Language detection process
- Context matching
- Dictionary usage
- Potential issues

## Future Roadmap

- More language support
- Improved context detection
- Machine learning-based language models
- Community-driven dictionary expansion
