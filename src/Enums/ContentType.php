<?php

namespace Ninja\Sentinel\Enums;

enum ContentType: string
{
    case SocialMedia = 'social_media';
    case News = 'news';
    case Blog = 'blog';
    case Forum = 'forum';
    case Educational = 'educational';
    case Research = 'research';
    case Medical = 'medical';
    case Legal = 'legal';
    case Gaming = 'gaming';
    case Chat = 'chat';

    public function threshold(): float
    {
        /** @var float  $threshold */
        $threshold = config(sprintf('sentinel.thresholds.content_types.%s', $this->value));
        return $threshold;
    }
}
