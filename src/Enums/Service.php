<?php

namespace Ninja\Censor\Enums;

enum Service: string
{
    case Perspective = 'perspective';
    case PurgoMalum = 'purgomalum';
    case Tisane = 'tisane';
    case Azure = 'azure';
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
