<?php

namespace Ninja\Censor\Schemas;

use EchoLabs\Prism\Schema\ArraySchema;
use EchoLabs\Prism\Schema\BooleanSchema;
use EchoLabs\Prism\Schema\NumberSchema;
use EchoLabs\Prism\Schema\ObjectSchema;
use EchoLabs\Prism\Schema\StringSchema;

class CensorPrismSchema extends ObjectSchema
{
    public function __construct()
    {
        parent::__construct(
            name: 'profanity_analysis',
            description: 'Analyze text for profanity and inappropriate content',
            properties: [
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
            ],
            requiredFields: ['is_offensive', 'offensive_words', 'categories', 'confidence', 'severity'],
        );
    }
}
