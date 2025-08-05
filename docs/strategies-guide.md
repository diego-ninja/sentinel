# Detection Strategies

Sentinel employs multiple sophisticated strategies to detect offensive content:

## Available Strategies

### 1. Index Strategy
- Fast exact matching using Trie data structure
- Efficient for large dictionaries
- Prioritizes full word matches

### 2. Pattern Strategy
- Handles character substitutions
- Detects obfuscated offensive words
- Supports complex replacement patterns

### 3. N-Gram Strategy
- Detects offensive phrases
- Analyzes word combinations
- Supports multi-word offensive content

### 4. Variation Strategy
- Catches variations of offensive words
- Handles separated characters
- Supports different word formations

### 5. Repeated Character Strategy
- Identifies words with intentionally repeated characters
- Catches attempts to bypass filters
- Example: "fuuuuck" → detected

### 6. Levenshtein Strategy
- Uses string distance comparison
- Detects similar words with minor variations
- Configurable similarity threshold

### 7. Alphanumeric Variation Strategy
- Detects words mixed with numbers
- Handles variations like "f0ck", "fuck88"
- Configurable affix length

### 8. Reversed Words Strategy
- Catches words written backwards
- Example: "kcuf" (fuck backwards)

### 9. Zero-Width Strategy
- Detects hidden characters
- Identifies words with zero-width spaces
- Prevents character-based obfuscation

### 10. Safe Context Strategy
- Identifies potentially safe contexts
- Reduces false positives
- Considers 

## Strategy Configuration

Configure strategies in `config/sentinel.php`:

```php
'services' => [
    'local' => [
        'strategies' => [
            Ninja\Sentinel\Detection\Strategy\IndexStrategy::class,
            Ninja\Sentinel\Detection\Strategy\PatternStrategy::class,
            // More strategies...
        ],
        'levenshtein_threshold' => 1,
    ],
],
```

## Strategy Weighting

Each strategy has a weight that influences its impact on the final detection:

```php
public function weight(): float
{
    return match ($this) {
        MatchType::Exact,
        MatchType::Trie => 1.0,
        MatchType::Pattern,
        MatchType::NGram => 0.9,
        MatchType::Variation => 0.8,
        MatchType::Levenshtein => 0.7,
        MatchType::Repeated => 0.6,
    };
}
```

## Creating Custom Strategies

Implement a custom detection strategy:

```php
use Ninja\Sentinel\Detection\Strategy\AbstractStrategy;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\MatchType;

class CustomDetectionStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        
        // Implement custom detection logic
        foreach ($words as $word) {
            // Your custom matching algorithm
            if ($this->matchesCustomCriteria($text, $word)) {
                // Add match to collection
                $matches->addCoincidence(
                    new Coincidence(
                        word: $word,
                        type: MatchType::Custom,
                        score: Calculator::score($text, $word, MatchType::Custom, $occurrences),
                        confidence: Calculator::confidence($text, $word, MatchType::Custom, $occurrences),
                        occurrences: $occurrences
                    )
                );
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return 0.75; // Custom strategy weight
    }

    private function matchesCustomCriteria(string $text, string $word): bool
    {
        // Implement your custom matching logic
        return false;
    }
}
```

## Strategy Voting System

Sentinel uses a sophisticated voting system to combine strategy results:

- Strategies are weighted
- Matches are aggregated across strategies
- Confidence is calculated based on multiple detections

```php
class StrategyVotingSystem
{
    private const float MIN_CONFIDENCE_THRESHOLD = 0.35;
    private const float MAX_AGREEMENT_BOOST = 0.3;

    public function detect(string $text, iterable $words): MatchCollection
    {
        // Weighted voting logic
        $matchesByWord = $this->groupMatchesByWord($results);
        return $this->combineVotedMatches($matchesByWord, $totalWeight, $text);
    }
}
```

## Performance Considerations

- Strategies are executed in order of weight
- More precise strategies are prioritized
- Lazy loading of dictionaries
- Caching of detection results

## Best Practices

1. Order strategies from most specific to most general
2. Configure Levenshtein threshold carefully
3. Use context detectors to reduce false positives
4. Regularly update dictionaries
5. Test with diverse input scenarios

## Debugging Strategies

Enable detailed logging:

```php
config(['sentinel.debug' => true]);
```

This will provide insights into:
- Matched words
- Strategy performance
- Confidence scores
- Context detection