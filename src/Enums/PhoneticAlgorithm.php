<?php

namespace Ninja\Sentinel\Enums;

enum PhoneticAlgorithm: string
{
    case Soundex = 'soundex';
    case Metaphone = 'metaphone';
}
