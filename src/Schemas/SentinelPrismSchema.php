<?php

namespace Ninja\Sentinel\Schemas;

use EchoLabs\Prism\Schema\ArraySchema;
use EchoLabs\Prism\Schema\BooleanSchema;
use EchoLabs\Prism\Schema\NumberSchema;
use EchoLabs\Prism\Schema\ObjectSchema;
use EchoLabs\Prism\Schema\StringSchema;

class SentinelPrismSchema extends ObjectSchema
{
    public function __construct()
    {
        parent::__construct(
            name: 'profanity_analysis',
            description: 'Profanity, sentiment and content analysis',
            properties: [
                // Base analysis properties
                new BooleanSchema('is_offensive', 'Whether the text contains offensive content'),
                new ArraySchema(
                    name: 'offensive_words',
                    description: 'List of offensive words found in the text',
                    items: new StringSchema('word', 'An offensive word'),
                ),
                new ArraySchema(
                    name: 'categories',
                    description: 'Categories of offensive content found',
                    items: new StringSchema('category', 'The category of offensive content'),
                ),
                new NumberSchema('confidence', 'Confidence score between 0 and 1'),
                new NumberSchema('severity', 'Severity score of offensive content between 0 and 1'),

                // Sentiment analysis
                new ObjectSchema(
                    name: 'sentiment',
                    description: 'Sentiment analysis result',
                    properties: [
                        new StringSchema(
                            name: 'type',
                            description: 'Sentiment type: positive, negative, neutral, mixed',
                        ),
                        new NumberSchema(
                            name: 'score',
                            description: 'Sentiment score from -1.0 (negative) to 1.0 (positive)',
                        ),
                    ],
                    requiredFields: ['type', 'score'],
                ),

                // Detailed matches with occurrences
                new ArraySchema(
                    name: 'matches',
                    description: 'Detailed offensive content matches',
                    items: new ObjectSchema(
                        name: 'match',
                        description: 'Individual content match information',
                        properties: [
                            new StringSchema('text', 'The matched text'),
                            new StringSchema('match_type', 'Type of match (exact, pattern, variation)'),
                            new NumberSchema('score', 'Match-specific score between 0 and 1'),
                            new NumberSchema('confidence', 'Match-specific confidence between 0 and 1'),
                            new ArraySchema(
                                name: 'occurrences',
                                description: 'Locations where this match appears in the text',
                                items: new ObjectSchema(
                                    name: 'occurrence',
                                    description: 'Position and length of a match occurrence',
                                    properties: [
                                        new NumberSchema('start', 'Starting position in the text'),
                                        new NumberSchema('length', 'Length of the match'),
                                    ],
                                    requiredFields: ['start', 'length'],
                                ),
                            ),
                            new ObjectSchema(
                                name: 'context',
                                description: 'Match context information',
                                properties: [
                                    new StringSchema(
                                        'original',
                                        'Original form if modified or obfuscated',
                                    ),
                                    new StringSchema(
                                        'surrounding',
                                        'Text surrounding the match (brief context)',
                                    ),
                                ],
                                requiredFields: [],
                            ),
                        ],
                        requiredFields: ['text', 'match_type', 'score', 'confidence', 'occurrences'],
                    ),
                ),
            ],
            requiredFields: [
                'is_offensive',
                'offensive_words',
                'categories',
                'confidence',
                'severity',
                'sentiment',
                'matches',
            ],
        );
    }
}
