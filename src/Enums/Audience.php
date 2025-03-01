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

    public function prompt(): string
    {
        return match ($this) {
            Audience::Children => "  This content is intended for children. Apply very strict moderation standards. Flag even mild profanity, innuendo, or mature themes.\n",
            Audience::Teen => "  This content is intended for teenagers. Apply moderately strict moderation standards. Flag strong profanity and explicit content but allow mild language.\n",
            Audience::Adult => "  This content is intended for adults. Apply standard moderation focused on hate speech, severe toxicity, and truly offensive content.\n",
            Audience::Professional => "  This content is intended for professional contexts. Apply moderation focused on inappropriate workplace language while allowing technical terminology.\n",
        };
    }
}
