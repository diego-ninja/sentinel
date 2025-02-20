# Sentinel for Laravel

<p align="center">
    <img src="./.github/assets/logo.png" alt="Sentinel Logo"/>
</p>

[![Laravel Package](https://img.shields.io/badge/Laravel%2010+%20Package-red?logo=laravel&logoColor=white)](https://www.laravel.com)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/diego-ninja/sentinel.svg?style=flat&color=blue)](https://packagist.org/packages/diego-ninja/sentinel)
[![Total Downloads](https://img.shields.io/packagist/dt/diego-ninja/sentinel.svg?style=flat&color=blue)](https://packagist.org/packages/diego-ninja/sentinel)
![PHP Version](https://img.shields.io/packagist/php-v/diego-ninja/sentinel.svg?style=flat&color=blue)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/diego-ninja/sentinel?color=blue)
[![PHPStan Level](https://img.shields.io/badge/phpstan-level%2010-blue?logo=php)]()

# Introduction

A powerful and flexible content analysis package for Laravel 10+ applications. Analyze and filter offensive content using multiple services, local dictionaries, and advanced detection strategies.

This documentation has been generated almost in its entirety using 🦠 [Claude 3.5 Sonnet](https://claude.ai/) based on source code analysis. Some sections may be incomplete, outdated or may contain documentation for planned or not-released features. For the most accurate information, please refer to the source code or open an issue on the package repository.

## ❤️ Features

- Multiple service providers support:
    - Local dictionary-based analysis
    - [PurgoMalum](https://www.purgomalum.com/)
    - [Tisane AI](https://tisane.ai/)
    - [Prism LLM](https://prism.echolabs.dev/) (with support for multiple LLMs)
    - [Azure AI](https://azure.microsoft.com/en-us/pricing/details/cognitive-services/content-safety/)
    - [Perspective AI](https://perspectiveapi.com/)
- Advanced detection strategies:
    - Exact match with Trie indexing
    - Pattern matching with character substitutions
    - N-gram analysis for phrase detection
    - Variation detection for obfuscated content
    - Repeated character detection
    - Levenshtein distance matching
- Rich analysis results:
    - Sentiment analysis
    - Content categorization
    - Match position tracking
    - Context and confidence scoring
- Multi-language support
- Whitelist functionality
- Configurable dictionaries
- Laravel Facade and helper functions
- Laravel validation rule
- Caching system
- Full Octane compatibility

## Planned Features
- Unicode support enhancement
- More service providers
- Machine learning enhancements

## 📦 Installation

You can install the package via composer:

```bash
composer require diego-ninja/sentinel
```

After installing, publish the configuration file and dictionaries:

```bash
php artisan vendor:publish --tag="sentinel-config"
php artisan vendor:publish --tag="sentinel-dictionaries"
```

## 🎛️ Configuration

The package configuration file will be published at `config/sentinel.php`. Here you can configure:

- Default language and available languages
- Default profanity service
- Mask character for moderated words
- Character replacements for evasion detection
- Whitelisted words
- Dictionary path
- Service-specific configurations
- Cache settings
- Analysis thresholds

### API Keys Configuration

Some services require API keys. Add these to your `.env` file:

```env
SENTINEL_THRESHOLD_SCORE=0.5
SENTINEL_CACHE_ENABLED=true
SENTINEL_CACHE_TTL=3600
SENTINEL_CACHE_STORE=redis

PERSPECTIVE_AI_API_KEY=your-perspective-api-key
TISANE_AI_API_KEY=your-tisane-api-key
AZURE_AI_API_KEY=your-azure-api-key
AZURE_AI_ENDPOINT=your-azure-endpoint

# Prism Configuration
PRISM_PROVIDER=anthropic
PRISM_MODEL=claude-3-sonnet-latest
```

## ⚙️ Basic Usage

You can use Sentinel in three ways:

### 1. Facade

```php
use Ninja\Sentinel\Facades\Sentinel;

// Check if text contains offensive content
$isOffensive = Sentinel::offensive('some text');

// Get cleaned version of text
$cleanText = Sentinel::clean('some text');

// Get detailed analysis with sentiment and matches
$result = Sentinel::check('some text');

// Use a specific provider
$result = Sentinel::with(Provider::Prism, 'some text');
```

### 2. Helper Functions

```php
// Check if text is offensive
$isOffensive = is_offensive('some text');

// Clean offensive content
$cleanText = clean('some text');
```

### 3. Validation Rule

```php
$rules = [
    'comment' => ['required', 'string', 'offensive']
];
```

## Available Moderation Providers

### Local Provider

Uses local dictionaries with multiple detection strategies for offline profanity checking.

```php
use Ninja\Sentinel\Enums\Provider;

$result = Sentinel::with(Provider::Local, 'text to check');
```

Features:
- Multiple detection strategies
- Fast performance
- No API dependencies
- Configurable pattern matching

### PurgoMalum

Free web service for basic profanity filtering.

```php
$result = Sentinel::with(Provider::PurgoMalum, 'text to check');
```

### Azure AI Content Safety

Uses Azure's AI content moderation service with advanced content analysis.

```php
$result = Sentinel::with(Provider::Azure, 'text to check');
```

### Perspective AI

Uses Google's Perspective API for toxicity and content analysis.

```php
$result = Sentinel::with(Provider::Perspective, 'text to check');
```

### Tisane AI

Natural language processing service for content moderation.

```php
$result = Sentinel::with(Provider::Tisane, 'text to check');
```

### Prism LLM Support

Access various Large Language Models through Prism:

```php
use Ninja\Sentinel\Enums\Provider;

$result = Sentinel::with(Provider::Prism, 'text to check');
```

Supported models through Prism:
- Anthropic (Claude models)
- OpenAI (GPT models)
- Gemini
- Mistral
- Ollama
- DeepSeek
- Groq
- xAI

## Working with Results

All services return a Result object with consistent methods:

```php
$result = Sentinel::check('some text');

// Basic information
$result->offensive();    // bool: whether the text contains offensive content
$result->words();        // array: list of matched offensive words
$result->replaced();     // string: text with offensive words replaced
$result->original();     // string: original text
$result->score();        // Score: offensive content score
$result->confidence();   // Confidence: confidence level

// Detailed analysis
$result->sentiment();    // Sentiment: text sentiment analysis
$result->categories();   // array: detected content categories

// Match information
$result->matches();      // MatchCollection: detailed matches with positions
```

### Working with Matches

The MatchCollection provides detailed information about each match:

```php
$matches = $result->matches();

foreach ($matches as $match) {
    echo "Word: " . $match->word();
    echo "Type: " . $match->type();          // exact, pattern, variation, etc.
    echo "Score: " . $match->score();
    echo "Confidence: " . $match->confidence();
    
    // Get all occurrences of the match
    foreach ($match->occurrences() as $occurrence) {
        echo "Position: " . $occurrence->start();
        echo "Length: " . $occurrence->length();
    }
    
    // Context information if available
    if ($context = $match->context()) {
        echo "Original form: " . $context['original'];
        echo "Surrounding text: " . $context['surrounding'];
    }
}
```

### Categories

The package can detect various content categories:

```php
use Ninja\Sentinel\Enums\Category;

$categories = $result->categories();
// Can include:
// - Category::HateSpeech
// - Category::Harassment
// - Category::Sexual
// - Category::Violence
// - Category::Threat
// - Category::Toxicity
// - Category::Profanity
```

### Sentiment Analysis

Results include sentiment analysis when available:

```php
$sentiment = $result->sentiment();

echo $sentiment->type();    // positive, negative, neutral, mixed
echo $sentiment->score();   // -1.0 to 1.0
```

## Response Caching

External service responses are automatically cached to improve performance and reduce API calls. By default, all external services will cache their responses for 1 hour.

The local provider is not cached as it's already performant enough.

### Configuring Cache

You can configure the cache in your `.env` file:

```env
SENTINEL_CACHE_ENABLED=true # Enable caching (default: true)
SENTINEL_CACHE_TTL=3600 # Cache duration in seconds (default: 1 hour)
SENTINEL_CACHE_STORE=redis # Cache store (default: file)
```

Or in your `config/sentinel.php`:

```php
    'cache' => [
        'enabled' => env('SENTINEL_CACHE_ENABLED', true),
        'store' => env('SENTINEL_CACHE_STORE', 'file'),
        'ttl' => env('SENTINEL_CACHE_TTL', 60),
    ],
```

### Cache Keys

Cache keys are generated using the following format:
```
sentinel:{ServiceName}:{md5(text)}
```

## Detection Strategies

The local checker uses a multi-strategy approach to detect offensive content accurately. Each piece of text is processed through different detection strategies in sequence:

1. **Trie Index Strategy**: Fast exact matching using a Trie data structure
2. **Pattern Strategy**: Handles exact matches and character substitutions
3. **NGram Strategy**: Detects offensive phrases by analyzing word combinations
4. **Variation Strategy**: Catches attempts to evade detection through character separation
5. **Repeated Chars Strategy**: Identifies words with intentionally repeated characters
6. **Levenshtein Strategy**: Uses string distance comparison for similar words

Each strategy can operate in either full word or partial matching mode. Results from all strategies are combined, deduplicated, and scored based on the type and quantity of matches found.

## Custom Dictionaries

You can add your own dictionaries or modify existing ones:

1. Create a new PHP file in your `resources/dict` directory
2. Return an array of words to be moderated
3. Update your config to include the new language

```php
// resources/dict/custom.php
return [
    'word1',
    'word2',
    // ...
];

// config/sentinel.php
'languages' => ['en', 'custom'],
```

## Whitelist

You can whitelist words to prevent them from being moderated:

```php
// config/sentinel.php
'whitelist' => [
    'word1',
    'word2',
],
```

## Character Substitution

The package detects common character substitutions. Configure these in:

```php
// config/sentinel.php
'replacements' => [
    'a' => '(a|@|4)',
    'i' => '(i|1|!)',
    // ...
],
```

## 🙏 Credits

This project is developed and maintained by 🥷 [Diego Rin](https://diego.ninja) in his free time.

Special thanks to:

- [Laravel Framework](https://laravel.com/) for providing the most exciting and well-crafted PHP framework.
- [Snipe](https://github.com/snipe) for developing the [initial code](https://github.com/snipe/banbuilder) that serves Sentinel as starting point.
- All the contributors and testers who have helped to improve this project through their contributions.

If you find this project useful, please consider giving it a ⭐ on GitHub!