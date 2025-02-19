<?php

namespace Ninja\Censor\Services\Adapters;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Result;
use Ninja\Censor\Services\Contracts\ServiceResponse;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;
use Ninja\Censor\ValueObject\Sentiment;

final readonly class CensorAdapter extends AbstractAdapter
{
    /**
     * @param  array{result: Result}  $response
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        /** @var Result $result */
        $result = $response['result'];

        return new readonly class ($result) implements ServiceResponse {
            public function __construct(
                private Result $result,
            ) {}

            public function original(): string
            {
                return $this->result->original();
            }

            public function replaced(): string
            {
                return $this->result->replaced();
            }

            public function matches(): ?MatchCollection
            {
                return $this->result->matches();
            }

            public function score(): ?Score
            {
                return $this->result->score();
            }

            public function confidence(): ?Confidence
            {
                return $this->result->confidence();
            }

            /**
             * @return array<Category>
             */
            public function categories(): array
            {
                return $this->result->categories();
            }

            public function sentiment(): ?Sentiment
            {
                return $this->result->sentiment();
            }
        };
    }
}
