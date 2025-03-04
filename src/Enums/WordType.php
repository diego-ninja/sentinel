<?php

namespace Ninja\Sentinel\Enums;

enum WordType: string
{
    case Pronoun = 'pronoun';
    case Prefix = 'prefix';
    case Suffix = 'suffix';
    case LanguageMarker = 'language_marker';
    case QuoteMarker = 'quote_marker';
    case ExcuseMarker = 'excuse_marker';
    case Intensifier = 'intensifier';
    case Modifier = 'modifier';
}
