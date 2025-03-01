<?php

/**
 * English context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'very', 'really', 'fucking', 'absolutely', 'totally', 'completely',
        'utterly', 'actual', 'literal', 'literally', 'seriously', 'damn',
        'super', 'extreme', 'extremely', 'so', 'such', 'truly',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'hate', 'hating', 'hated', 'kill', 'killing', 'killed', 'die', 'dying', 'died',
        'destroy', 'destroying', 'destroyed', 'stupid', 'idiot', 'moron', 'dumb',
        'attack', 'attacking', 'attacked', 'hurt', 'hurting', 'hurts', 'ugly',
        'awful', 'terrible', 'horrible', 'worst', 'bad', 'worst', 'disgusting',
        'angry', 'angry', 'pissed', 'mad', 'loser', 'hell', 'annoying', 'annoy',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'love', 'loving', 'loved', 'like', 'liking', 'liked', 'good', 'great', 'awesome',
        'amazing', 'wonderful', 'excellent', 'fantastic', 'terrific', 'outstanding',
        'brilliant', 'cool', 'nice', 'best', 'beautiful', 'enjoy', 'enjoying', 'enjoyed',
        'happy', 'glad', 'pleased', 'delighted', 'impressive', 'perfect', 'impressive',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'research', 'study', 'analysis', 'education', 'educational', 'academic', 'scholarly',
        'scientific', 'medical', 'biological', 'history', 'historical', 'literature',
        'psychology', 'sociology', 'anthropology', 'linguistics', 'paper', 'thesis', 'dissertation',
        'lecture', 'explain', 'explanation', 'definition', 'define', 'analyze', 'examine', 'discuss',
        'course', 'university', 'college', 'professor', 'doctoral', 'theory', 'concept',
        'science', 'experiment', 'laboratory', 'clinical', 'anatomy', 'physiology', 'biology',
        'textbook', 'curriculum', 'journal', 'publication', 'article', 'investigation',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'you', 'your', 'yourself', 'they', 'them', 'their', 'he', 'him', 'his', 'she', 'her',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'said', 'says', 'quoted', 'according', 'claimed', 'stated', 'wrote', 'mentioned', 'tweeted',
        'reported', 'commented', 'noted', 'expressed', 'testified', 'admitted', 'confessed',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'excuse', 'pardon', 'forgive', 'sorry', 'apologize',
    ],

    // Common words used for language detection
    'language_markers' => [
        'the', 'a', 'an', 'and', 'or', 'of', 'in', 'on', 'with', 'by', 'for', 'that',
        'this', 'these', 'those', 'my', 'your', 'his', 'her',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // As in "anal retentive" or "anal stage" (psychology)
        'sex',              // Biological sex, gender studies
        'sexual',           // Scientific contexts
        'sexuality',        // Academic discussions
        'intercourse',      // Social or sexual contexts in academic discussions
        'reproduction',     // Biology, science
        'penis',            // Anatomy, biology
        'vagina',           // Anatomy, biology
        'breast',           // Anatomy, biology
        'rectum',           // Anatomy, biology
        'testicle',         // Anatomy, biology
        'homosexual',       // Academic discussion, not pejorative
        'heterosexual',     // Academic discussion, not pejorative
        'transgender',      // Academic discussion, not pejorative
        'dyke',             // In academic discussions about reclaiming terms
        'queer',            // Academic discussions, gender studies
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'screw',            // Hardware, construction
        'bang',             // Programming (!) operator
        'stroke',           // Graphics, medical, sports
        'execute',          // Programming, legal
        'kill',             // Programming, process management
        'suicide',          // In discussions about prevention, mental health
        'master',           // Master/slave in technical contexts
        'slave',            // Master/slave in technical contexts
        'execution',        // Programming, legal
        'abort',            // Programming term
        'dummy',            // Test case, placeholder
        'crack',            // Software cracking, geology
        'bullet',           // Typography, ammunition
        'shoot',            // Photography, sports
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'ass' => [
            '/donkey|burro|mule/i',   // References to animals
            '/\bass(et|ignment|ociation|embly|essment|istant)/i', // Words starting with "ass"
        ],
        'cock' => [
            '/\b(pea|wea|ban|han|shu|hi)cock\b/i',  // Various bird species
            '/\bcock(pit|tail|roach)\b/i',          // Aviation, drinks, insects
        ],
        'dick' => [
            '/\b(moby|herman|philip|private|detective) dick\b/i',  // Names and detective novels
            '/\bdickens\b/i',                                      // Charles Dickens
        ],
        'pussy' => [
            '/\bcat|kitten|feline|pet\b/i',         // References to cats
        ],
    ],
];