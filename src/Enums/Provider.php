<?php

namespace Ninja\Censor\Enums;

enum Provider: string
{
    case Perspective = 'perspective_ai';
    case PurgoMalum = 'purgomalum';
    case Tisane = 'tisane_ai';
    case Azure = 'azure_ai';
    case Local = 'local';

    /**
     * @return array<Provider>
     */
    public static function values(): array
    {
        return [
            self::Perspective,
            self::PurgoMalum,
            self::Tisane,
            self::Azure,
        ];
    }
}
