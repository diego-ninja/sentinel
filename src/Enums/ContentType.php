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

    public function prompt(): string
    {
        return match ($this) {
            ContentType::Educational => "  This is educational content. Consider academic terms and scientific contexts that may use words in non-offensive ways. Be more permissive with technical terminology.\n",
            ContentType::Research => "  This is research content. Give significant leeway to academic terms, scientific discussions, and scholarly quotes.\n",
            ContentType::Medical => "  This is medical content. Medical terminology should generally not be flagged as offensive unless used in a derogatory manner.\n",
            ContentType::Legal => "  This is legal content. Legal terminology and case discussions may include potentially offensive terms in a professional context.\n",
            ContentType::Gaming => "  This is gaming content. Consider gaming community standards while still identifying genuinely offensive content.\n",
            ContentType::SocialMedia => "  This is social media content. Apply standard moderation rules but consider internet slang and evolving language use.\n",
            ContentType::News => "  This is news content. Consider journalistic context and quoted material when assessing offensive content.\n",
            ContentType::Blog => "  This is blog content. Apply standard moderation with consideration for opinion writing and personal expression.\n",
            ContentType::Forum => "  This is forum content. Consider community discussion norms while identifying genuinely offensive content.\n",
            ContentType::Chat => "  This is chat content. Apply stricter moderation as this is likely direct interpersonal communication.\n",
        };
    }
}
