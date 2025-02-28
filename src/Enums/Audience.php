<?php

namespace Ninja\Sentinel\Enums;

enum Audience: string
{
    case Children = 'children';
    case Teen = 'teen';
    case Adult = 'adult';
    case Professional = 'professional';

    public function threshold(): float
    {
        /** @var float  $threshold */
        $threshold = config(sprintf('sentinel.thresholds.audiences.%s', $this->value));
        return $threshold;
    }
}
