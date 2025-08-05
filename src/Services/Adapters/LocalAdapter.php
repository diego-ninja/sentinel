<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Result\Result;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

final readonly class LocalAdapter extends AbstractAdapter
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

            public function language(): LanguageCode
            {
                return $this->result->language();
            }
        };
    }
}
