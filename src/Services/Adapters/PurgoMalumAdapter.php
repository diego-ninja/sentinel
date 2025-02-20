<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

final readonly class PurgoMalumAdapter extends AbstractAdapter
{
    public function adapt(string $text, array $response): ServiceResponse
    {
        /** @var string $replacedText */
        $replacedText = $response['result'];

        $matches = $this->findDifferences($text, $replacedText);

        return new readonly class ($text, $replacedText, $matches) implements ServiceResponse {
            public function __construct(
                private string          $original,
                private string          $replaced,
                private MatchCollection $matches,
            ) {}

            public function original(): string
            {
                return $this->original;
            }

            public function replaced(): string
            {
                return $this->replaced;
            }

            public function matches(): MatchCollection
            {
                return $this->matches;
            }

            public function score(): Score
            {
                return $this->matches->score();
            }

            public function confidence(): Confidence
            {
                return $this->matches->confidence();
            }

            public function categories(): ?array
            {
                return null;
            }

            public function sentiment(): ?Sentiment
            {
                return null;
            }
        };
    }

    private function findDifferences(string $original, string $replaced): MatchCollection
    {
        $matches = new MatchCollection();
        $pattern = '/\*+/';

        if (preg_match_all($pattern, $replaced, $found, PREG_OFFSET_CAPTURE)) {
            foreach ($found[0] as [$match, $position]) {
                $length = mb_strlen($match);
                $originalWord = mb_substr($original, $position, $length);

                $occurrences = new OccurrenceCollection([
                    new Position($position, $length),
                ]);

                $matches->addCoincidence(
                    new Coincidence(
                        word: $originalWord,
                        type: MatchType::Exact,
                        score: Calculator::score($original, $originalWord, MatchType::Exact, $occurrences),
                        confidence: Calculator::confidence($original, $originalWord, MatchType::Exact, $occurrences),
                        occurrences: $occurrences,
                        context: ['replaced' => $match],
                    ),
                );
            }
        }

        return $matches;
    }
}
