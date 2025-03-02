# Contributing to Sentinel

## Code of Conduct

We are committed to providing a friendly, safe, and welcoming environment for all contributors.

## How to Contribute

### Reporting Issues

1. Check existing issues before creating a new one
2. Provide a clear and descriptive title
3. Include detailed steps to reproduce the issue
4. Add your environment details (PHP version, Laravel version, etc.)

### Pull Request Process

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Development Setup

### Prerequisites

- PHP 8.3+
- Composer
- Laravel 10+

### Installation

```bash
# Clone the repository
git clone https://github.com/diego-ninja/sentinel.git

# Install dependencies
cd sentinel
composer install

# Run tests
composer test
```

## Coding Standards

- Follow Laravel and PHP-FIG standards
- Use PSR-12 coding style
- Write clean, readable, and well-documented code
- Add PHPDoc blocks
- Maintain high PHPStan level (level 10)

### Code Quality Tools

```bash
# Run code style fixer
composer fix

# Static analysis
composer analyse

# Run tests
composer test
```

## Adding New Features

1. Discuss proposed changes in an issue first
2. Ensure comprehensive test coverage
3. Update documentation
4. Follow existing code structure

### Adding Detection Strategies

```php
use Ninja\Sentinel\Detection\Strategy\AbstractStrategy;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\MatchType;

class NewDetectionStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        // Implement detection logic
    }

    public function weight(): float
    {
        return 0.8; // Strategy weight
    }
}
```

### Adding Context Detectors

```php
use Ninja\Sentinel\Context\Contracts\ContextDetector;
use Ninja\Sentinel\Context\Enums\ContextType;

class NewContextDetector implements ContextDetector
{
    public function isInContext(
        string $fullText, 
        string $word, 
        int $position, 
        array $words, 
        string $language
    ): bool {
        // Implement context detection
    }

    public function getContextType(): ContextType
    {
        return ContextType::Custom;
    }
}
```

## Testing Guidelines

### Test Types

1. **Unit Tests**: Test individual components and methods
2. **Integration Tests**: Test interactions between components
3. **Functional Tests**: Test entire workflows
4. **Edge Case Tests**: Cover unusual scenarios

### Writing Tests

Use Pest testing framework:

```php
test('detects offensive content', function () {
    $result = Sentinel::check('offensive text');
    
    expect($result)
        ->toBeOffensive()
        ->and($result->words())
        ->toHaveCount(1);
});

test('handles context-specific scenarios', function () {
    $result = Sentinel::check(
        'Academic study of sexual behavior', 
        ContentType::Educational
    );
    
    expect($result)
        ->not()->toBeOffensive();
});
```

### Test Coverage Requirements

- Aim for 90%+ code coverage
- Test all detection strategies
- Cover multiple languages
- Test edge cases and unusual inputs

## Performance Testing

```bash
# Run performance benchmarks
composer benchmark
```

### Performance Test Scenarios

- Large text processing
- Multiple detection strategies
- Different language dictionaries
- Varied input types

## Documentation

### Updating Docs

- Keep documentation in sync with code changes
- Use clear, concise language
- Provide code examples
- Update changelog

## Release Process

1. Update `CHANGELOG.md`
2. Bump version in `composer.json`
3. Create git tag
4. Push to GitHub
5. Publish to Packagist

### Semantic Versioning

- `MAJOR.MINOR.PATCH`
- Major: Breaking changes
- Minor: New features, backwards compatible
- Patch: Bug fixes, small improvements

## Language and Localization

### Adding New Languages

1. Create dictionary file in `resources/dict/`
2. Add context file in `resources/context/`
3. Update language configuration
4. Write comprehensive tests

```php
// Example language dictionary
return [
    'offensive_word1',
    'offensive_word2',
    // More words
];
```

## Security

### Reporting Security Issues

- Do not open public issues for security vulnerabilities
- Email security@diego.ninja directly
- Include detailed description
- Provide reproduction steps

## Community

- Join our Discord
- Follow on GitHub
- Share your use cases
- Contribute back to the project

## Recognition

Contributors will be:
- Listed in `CONTRIBUTORS.md`
- Recognized in release notes
- Potentially invited to core team

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [PHP-FIG Standards](https://www.php-fig.org/)
- [Pest Testing Framework](https://pestphp.com/)

## Legal

- Project is MIT licensed
- Contributions must be your own
- Sign CLA for significant contributions

## Questions?

If you have any questions about contributing:
- Open an issue
- Ask in discussions
- Contact project maintainers