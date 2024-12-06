<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Profanity threshold score
    |--------------------------------------------------------------------------
    |
    | Define the threshold score to consider a text as profane
    |
    |
    */
    'threshold_score' => env('CENSOR_THRESHOLD_SCORE', 0.5),

    /*
    |--------------------------------------------------------------------------
    | Default language
    |--------------------------------------------------------------------------
    |
    | Define the default language
    |
    |
    */
    'default_language' => env('CENSOR_DEFAULT_LANGUAGE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    |
    | Define the list of languages available in the package
    |
    |
    */
    'languages' => explode(',', env('CENSOR_LANGUAGES', 'en')),

    /*
    |--------------------------------------------------------------------------
    | Default profanity service
    |--------------------------------------------------------------------------
    | Define the default profanity service to use
    |
    */
    'default_service' => \Ninja\Censor\Enums\Service::PurgoMalum,

    /*
    |--------------------------------------------------------------------------
    | Mask character
    |--------------------------------------------------------------------------
    |
    | Define the character to use to mask the profanity
    |
    |
    */
    'mask_char' => env('CENSOR_MASK_CHAR', '*'),

    /*
    |--------------------------------------------------------------------------
    | Character replacements
    |--------------------------------------------------------------------------
    |
    | Define the character replacements used to generate the regular expression
    | to match the profanity
    |
    */
    'replacements' => [
        'a' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)',
        'b' => '(b|b\.|b\-|8|\|3|ß|Β|β)',
        'c' => '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)',
        'd' => '(d|d\.|d\-|&part;|\|\)|Þ|��|Ð|ð)',
        'e' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑|ë|Ë)',
        'f' => '(f|f\.|f\-|ƒ)',
        'g' => '(g|g\.|g\-|6|9)',
        'h' => '(h|h\.|h\-|Η)',
        'i' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)',
        'j' => '(j|j\.|j\-)',
        'k' => '(k|k\.|k\-|Κ|κ)',
        'l' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)',
        'm' => '(m|m\.|m\-)',
        'n' => '(n|n\.|n\-|η|Ν|Π)',
        'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø|ô|ö|ò|ó|õ)',
        'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ)',
        'q' => '(q|q\.|q\-)',
        'r' => '(r|r\.|r\-|®)',
        's' => '(s|s\.|s\-|5|\$|§)',
        't' => '(t|t\.|t\-|Τ|τ|7)',
        'u' => '(u|u\.|u\-|υ|µ|û|ü|ù|ú|ū|ů)',
        'v' => '(v|v\.|v\-|υ|ν)',
        'w' => '(w|w\.|w\-|ω|ψ|Ψ)',
        'x' => '(x|x\.|x\-|Χ|χ)',
        'y' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)',
        'z' => '(z|z\.|z\-|Ζ)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Whitelisted words
    |--------------------------------------------------------------------------
    |
    | Define the list of words that should not be censored
    |
    */
    'whitelist' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Dictionary path
    |--------------------------------------------------------------------------
    |
    | Define the path to the dictionary files used to generate the regular expression
    | to match the profanity
    |
    */
    'dictionary_path' => resource_path('dict'),

    /*
    |--------------------------------------------------------------------------
    | Profanity services configuration
    |--------------------------------------------------------------------------
    | Define the configuration for each profanity service
    |
    */
    'services' => [
        'perspective_ai' => [
            'key' => env('PERSPECTIVE_AI_API_KEY'),
        ],
        'tisane_ai' => [
            'key' => env('TISANE_AI_API_KEY'),
        ],
        'azure_ai' => [
            'key' => env('AZURE_AI_API_KEY'),
            'endpoint' => env('AZURE_AI_ENDPOINT'),
            'version' => env('AZURE_AI_VERSION', \Ninja\Censor\Checkers\AzureAI::DEFAULT_API_VERSION),
        ],
        'purgomalum' => [],
        'local' => [
            'levenshtein_threshold' => env('CENSOR_LEVENSHTEIN_THRESHOLD', 1),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache configuration
    |--------------------------------------------------------------------------
    | Define the configuration for the cache
    |
    */
    'cache' => [
        'enabled' => env('CENSOR_CACHE_ENABLED', true),
        'store' => env('CENSOR_CACHE_STORE', 'file'),
        'ttl' => env('CENSOR_CACHE_TTL', 60),
    ],
];
