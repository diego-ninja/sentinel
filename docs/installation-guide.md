# Installation

## Requirements

- PHP 8.3+
- Laravel 10+

## Composer Installation

Install the package via Composer:

```bash
composer require diego-ninja/sentinel
```

## Publishing Configuration

Publish the configuration and dictionary files:

```bash
php artisan vendor:publish --tag="sentinel-config"
php artisan vendor:publish --tag="sentinel-dictionaries"
```

## Environment Configuration

Add the following to your `.env` file:

```env
# General Settings
SENTINEL_THRESHOLD_SCORE=0.5
SENTINEL_CACHE_ENABLED=true
SENTINEL_CACHE_TTL=3600

# Service-specific API keys
PERSPECTIVE_AI_API_KEY=your-perspective-api-key
TISANE_AI_API_KEY=your-tisane-api-key
AZURE_AI_API_KEY=your-azure-api-key
AZURE_AI_ENDPOINT=your-azure-endpoint
```

## Supported Providers

- Local dictionary-based detection
- PurgoMalum
- Tisane AI
- Perspective AI
- Azure AI
- Prism LLM

## Troubleshooting

- Ensure all required extensions are installed
- Check API keys for external services
- Verify Laravel configuration
