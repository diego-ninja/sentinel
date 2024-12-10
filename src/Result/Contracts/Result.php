<?php

namespace Ninja\Censor\Result\Contracts;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

interface Result
{
    public function offensive(): bool;

    /**
     * @return string[]
     */
    public function words(): array;

    public function replaced(): string;

    public function original(): string;

    public function score(): ?Score;

    public function confidence(): ?Confidence;

    /**
     * @return string[]
     */
    public function categories(): array;

    public function matches(): ?MatchCollection;
}
