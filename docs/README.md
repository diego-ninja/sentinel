# Sentinel Documentation

## Quick Start

Sentinel is an advanced content moderation package for Laravel that provides comprehensive text analysis and offensive content detection.

### Installation

```bash
composer require diego-ninja/sentinel
```

### Basic Usage

```php
use Ninja\Sentinel\Facades\Sentinel;

// Check if text is offensive
$isOffensive = Sentinel::offensive('Some text');

// Clean offensive content
$cleanText = Sentinel::clean('Some text');
```

## Documentation Contents

1. [Installation](INSTALLATION.md)
2. [Configuration](CONFIGURATION.md)
3. [Usage](USAGE.md)
4. [Advanced Features](ADVANCED_FEATURES.md)
5. [Detection Strategies](STRATEGIES.md)
6. [Context Detection](CONTEXT_DETECTION.md)
7. [Service Providers](PROVIDERS.md)
8. [Languages](LANGUAGES.md)
9. [Contributing](CONTRIBUTING.md)

## Key Features

- Multiple detection strategies
- Context-aware analysis
- Multilingual support
- Flexible configuration
- Multiple service providers

## Quick Example

```php
use Ninja\Sentinel\Facades\Sentinel;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\Audience;

$result = Sentinel::check(
    'Some potentially offensive text', 
    ContentType::Educational, 
    Audience::Professional
);

// Check if offensive
$isOffensive = $result->offensive();

// Get cleaned text
$cleanedText = $result->replaced();
```

## Requirements

- PHP 8.3+
- Laravel 10+

## License

MIT License

## Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Support

- Open GitHub issues for questions
- Community support via discussions
- Professional support available

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for recent changes.