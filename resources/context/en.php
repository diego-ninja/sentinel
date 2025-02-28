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
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'you', 'your', 'yourself', 'they', 'them', 'their', 'he', 'him', 'his', 'she', 'her',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'said', 'says', 'quoted', 'according', 'claimed', 'stated', 'wrote', 'mentioned', 'tweeted',
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
];