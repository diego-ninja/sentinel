<?php

namespace Ninja\Censor\Contracts;

interface Result
{
    public function offensive(): bool;

    /**
     * @return string[]
     */
    public function words(): array;

    public function replaced(): string;

    public function original(): string;

    public function score(): ?float;

    public function confidence(): ?float;

    /**
     * @return string[]|null
     */
    public function categories(): ?array;
}
