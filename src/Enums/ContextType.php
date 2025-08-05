<?php

namespace Ninja\Sentinel\Enums;

enum ContextType: string
{
    case Educational = 'educational';
    case Quoted = 'quoted';
    case Technical = 'technical';
    case Medical = 'medical';
    case Legal = 'legal';
    case WordSpecific = 'word_specific';

}
