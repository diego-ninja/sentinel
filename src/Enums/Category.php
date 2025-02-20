<?php

namespace Ninja\Sentinel\Enums;

use InvalidArgumentException;

enum Category: string
{
    case Profanity = 'profanity';
    case Threat = 'threat';
    case Toxicity = 'toxicity';
    case Insult = 'insult';
    case PersonalAttack = 'personal_attack';
    case Sexual = 'sexual';
    case AdultContent = 'adult_content';
    case MentalHealth = 'mental_health';
    case SelfHarm = 'self_harm';
    case Obscenity = 'obscenity';
    case Crime = 'crime';
    case HateSpeech = 'hate_speech';
    case Harassment = 'harassment';
    case Violence = 'violence';

    public static function fromTisane(string $type): self
    {
        return match ($type) {
            'personal_attack' => self::PersonalAttack,
            'bigotry' => self::HateSpeech,
            'profanity' => self::Profanity,
            'sexual_advances' => self::Sexual,
            'criminal_activity' => self::Crime,
            'adult_only' => self::AdultContent,
            'mental_issues' => self::MentalHealth,
            'allegation' => self::Threat,
            'provocation' => self::Insult,
            'disturbing' => self::Obscenity,
            default => throw new InvalidArgumentException("Unknown category: {$type}"),
        };
    }

    public static function fromPerspective(string $type): self
    {
        return match ($type) {
            'TOXICITY', 'SEVERE_TOXICITY' => self::Toxicity,
            'IDENTITY_ATTACK' => self::HateSpeech,
            'INSULT' => self::Insult,
            'PROFANITY' => self::Profanity,
            'THREAT' => self::Threat,
            'SEXUALLY_EXPLICIT', 'FLIRTATION' => self::Sexual,
            default => throw new InvalidArgumentException("Unknown category: {$type}"),
        };
    }

    public static function fromAzure(string $type): self
    {
        return match ($type) {
            'Hate' => self::HateSpeech,
            'SelfHarm' => self::SelfHarm,
            'Sexual' => self::Sexual,
            'Violence' => self::Violence,
            default => throw new InvalidArgumentException("Unknown category: {$type}"),
        };
    }
}
