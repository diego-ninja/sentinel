<?php

namespace Ninja\Censor\Enums;

enum Service: string
{
    case Perspective = 'perspective_ai';
    case PurgoMalum = 'purgomalum';
    case Tisane = 'tisane_ai';
    case Azure = 'azure_ai';
    case Censor = 'censor';

    /**
     * @return array<Service>
     */
    public static function values(): array
    {
        return [
            self::Perspective,
            self::PurgoMalum,
            self::Tisane,
            self::Azure,
            self::Censor,
        ];
    }
}
