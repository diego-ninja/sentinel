# 💀 Censor - A censor and word filtering library for Laravel 10+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/diego-ninja/laravel-censor.svg?style=flat&color=blue)](https://packagist.org/packages/diego-ninja/laravel-censor)
[![Total Downloads](https://img.shields.io/packagist/dt/diego-ninja/laravel-censor.svg?style=flat&color=blue)](https://packagist.org/packages/diego-ninja/laravel-censor)
![PHP Version](https://img.shields.io/packagist/php-v/diego-ninja/laravel-censor.svg?style=flat&color=blue)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/diego-ninja/laravel-censor?color=blue)
[![Hits-of-Code](https://hitsofcode.com/github/diego-ninja/laravel-censor?branch=main&label=hits-of-code)](https://hitsofcode.com/github/diego-ninja/laravel-censor/view?branch=main&label=hits-of-code)
[![wakatime](https://wakatime.com/badge/user/bd65f055-c9f3-4f73-92aa-3c9810f70cc3/project/f5c4a047-d754-4ef3-b7b0-89ff0099a601.svg)](https://wakatime.com/badge/user/bd65f055-c9f3-4f73-92aa-3c9810f70cc3/project/f5c4a047-d754-4ef3-b7b0-89ff0099a601)

# Introduction

A powerful and flexible profanity filtering package for Laravel 10+ applications. Filter offensive content using multiple services or local dictionaries.

## ❤️ Features

- Multiple profanity checking services support (Local, PurgoMalum, Azure AI, Perspective AI, Tisane AI)
- Multi-language support
- Whitelist functionality
- Character replacement options
- Laravel Facade and helper functions
- Custom validation rule
- Configurable dictionaries
- Character substitution detection

## Installation

You can install the package via composer:

```bash
composer require diego-ninja/laravel-censor
```

After installing, publish the configuration file and dictionaries:

```bash
php artisan vendor:publish --tag="censor-config"
php artisan vendor:publish --tag="censor-dictionaries"
```

## Configuration

The package configuration file will be published at `config/censor.php`. Here you can configure:

- Default language
- Available languages
- Default profanity service
- Mask character for censored words
- Character replacements for evasion detection
- Whitelist of allowed words
- Dictionary path
- Service-specific configurations

### API Keys Configuration

Some services require API keys. Add these to your `.env` file:

```env
PERSPECTIVE_AI_API_KEY=your-perspective-api-key
TISANE_AI_API_KEY=your-tisane-api-key
AZURE_AI_API_KEY=your-azure-api-key
AZURE_AI_ENDPOINT=your-azure-endpoint
```

## Basic Usage

You can use Laravel Censor in three ways:

### 1. Facade

```php
use Ninja\Censor\Facades\Censor;

// Check if text contains offensive content
$isOffensive = Censor::offensive('some text');

// Get cleaned version of text
$cleanText = Censor::clean('some text');

// Get detailed analysis
$result = Censor::check('some text');
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
    'comment' => ['required', 'string', 'censor_check']
];
```

## Available Services

### Local Censor

Uses local dictionaries for offline profanity checking.

```php
use Ninja\Censor\Enums\Service;

$result = Censor::with(Service::Local, 'text to check');
```

### PurgoMalum

Free web service for profanity filtering.

```php
$result = Censor::with(Service::PurgoMalum, 'text to check');
```

### Azure AI Content Safety

Uses Azure's AI content moderation service.

```php
$result = Censor::with(Service::Azure, 'text to check');
```

### Perspective AI

Uses Google's Perspective API for content analysis.

```php
$result = Censor::with(Service::Perspective, 'text to check');
```

### Tisane AI

Natural language processing service for content moderation.

```php
$result = Censor::with(Service::Tisane, 'text to check');
```

## Working with Results

All services return a Result object with consistent methods:

```php
$result = Censor::check('some text');

$result->offensive();    // bool: whether the text contains offensive content
$result->words();        // array: list of matched offensive words
$result->replaced();     // string: text with offensive words replaced
$result->original();     // string: original text
$result->score();        // ?float: offensive content score (if available)
$result->confidence();   // ?float: confidence level (if available)
$result->categories();   // ?array: detected categories (if available)
```

## Custom Dictionaries

You can add your own dictionaries or modify existing ones:

1. Create a new PHP file in your `resources/dict` directory
2. Return an array of words to be censored
3. Update your config to include the new language

```php
// resources/dict/custom.php
return [
    'word1',
    'word2',
    // ...
];

// config/censor.php
'languages' => ['en', 'custom'],
```

## Whitelist

You can whitelist words to prevent them from being censored:

```php
// config/censor.php
'whitelist' => [
    'word1',
    'word2',
],
```

## Character Substitution

The package detects common character substitutions (e.g., @ for a, 1 for i). Configure these in:

```php
// config/censor.php
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
- [Snipe](https://github.com/snipe) for developing the [inital code](https://github.com/snipe/banbuilder) that serves Laravel Censor as starting point.
- All the contributors and testers who have helped to improve this project through their contributions.

If you find this project useful, please consider giving it a ⭐ on GitHub!
