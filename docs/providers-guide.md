# Service Providers

## Overview

Sentinel supports multiple content moderation service providers, each with unique capabilities and integration methods.

## Available Providers

### 1. Local Dictionary Provider
- Fastest and most customizable
- No external API dependencies
- Comprehensive detection strategies
- Fully configurable

```php
use Ninja\Sentinel\Enums\Provider;

$result = Sentinel::with(Provider::Local, $text);
```

### 2. PurgoMalum Provider
- Free web service
- Simple content filtering
- Limited customization
- Quick response times

```php
$result = Sentinel::with(Provider::PurgoMalum, $text);
```

### 3. Perspective AI Provider
- Google's advanced toxicity detection
- Detailed confidence scoring
- Multiple toxicity attributes
- Requires API key

```php
$result = Sentinel::with(Provider::Perspective, $text);
```

### 4. Tisane AI Provider
- Advanced NLP-based analysis
- Multilingual support
- Detailed sentiment analysis
- Requires API key

```php
$result = Sentinel::with(Provider::Tisane, $text);
```

### 5. Azure AI Provider
- Enterprise-grade content safety
- Comprehensive category detection
- Configurable thresholds
- Requires Azure subscription

```php
$result = Sentinel::with(Provider::Azure, $text);
```

### 6. Prism LLM Provider
- Large Language Model-based analysis
- Most flexible and adaptive
- Multiple LLM providers
- Advanced context understanding

```php
$result = Sentinel::with(Provider::Prism, $text);
```

## Configuration

Configure providers in `.env`:

```env
# Perspective AI
PERSPECTIVE_AI_API_KEY=your-key

# Tisane AI
TISANE_AI_API_KEY=your-key

# Azure AI
AZURE_AI_KEY=your-key
AZURE_AI_ENDPOINT=your-endpoint

# Prism Configuration
PRISM_PROVIDER=anthropic
PRISM_MODEL=claude-3-sonnet-latest
```

## Configuring Default Provider

```php
// config/sentinel.php
return [
    'default_service' => Provider::Local,
    'fallback_service' => Provider::Local,
];
```

## Creating Custom Providers

Implement a custom provider:

```php
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\Audience;

class CustomProfanityChecker implements ProfanityChecker
{
    public function check(
        string $text, 
        ?ContentType $contentType = null, 
        ?Audience $audience = null
    ): Result {
        // Implement custom checking logic
    }
}
```

## Provider Comparison

| Provider | Speed | Accuracy | API Dependency | Customization | Cost |
|----------|-------|----------|----------------|--------------|------|
| Local | Very Fast | Moderate | No | High | Free |
| PurgoMalum | Fast | Basic | Yes | Low | Free |
| Perspective AI | Moderate | High | Yes | Moderate | Paid |
| Tisane AI | Moderate | High | Yes | High | Paid |
| Azure AI | Slow | Very High | Yes | High | Paid |
| Prism LLM | Slow | Highest | Yes | Highest | Paid |

## Best Practices

1. Use local provider for development
2. Choose provider based on your specific needs
3. Implement fallback mechanisms
4. Cache provider results
5. Monitor API usage and costs

## Error Handling

```php
try {
    $result = Sentinel::with(Provider::Perspective, $text);
} catch (ProviderException $e) {
    // Fallback to local provider
    $result = Sentinel::with(Provider::Local, $text);
}
```

## Performance Considerations

- Enable caching for external providers
- Set reasonable timeouts
- Implement circuit breaker patterns

```php
config([
    'sentinel.cache.enabled' => true,
    'sentinel.services.timeout' => 5, // seconds
]);
```

## Debugging Providers

Enable detailed logging:

```php
config(['sentinel.providers.debug' => true]);
```

This provides insights into:
- API request/response details
- Performance metrics
- Error conditions
