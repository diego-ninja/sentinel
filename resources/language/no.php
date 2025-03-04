<?php

/**
 * Norwegian language definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Offensive words from the dictionary
    'offensive_words' => [
        'dritt', 'drittsekk', 'dust', 'faen', 'fæn', 'fanden', 'helvete', 'helvette', 'hora',
        'hore', 'jævel', 'jævla', 'kjerring', 'ludder', 'pedo', 'pedofil', 'pokker', 'porn',
        'porno', 'quisling', 'satan', 'sattan', 'søren', 'bæsj', 'dildo', 'ereksjon', 'fitta',
        'fitte', 'forpult', 'fuck', 'fucking', 'føkk', 'føkking', 'førpult', 'førrpult', 'hæstkug',
        'hæstkuk', 'hestkug', 'hestkuk', 'klitoris', 'klitt', 'knull', 'kug', 'kugost', 'kuk',
        'kukk', 'kukkost', 'kukost', 'kåt', 'lort', 'masturbasjon', 'masturbere', 'patte', 'penis',
        'pess', 'pikk', 'piss', 'pong', 'pul', 'pule', 'pult', 'pung', 'pupp', 'pæss', 'pæss',
        'rape', 'rass', 'rasshøl', 'rasshøl', 'rompe', 'ronk', 'runk', 'ræv', 'ræva', 'rævhøl',
        'rævva', 'sæd', 'shit', 'skit', 'sodom', 'stivas', 'stiven', 'utpult', 'vagina', 'voldta',
        'voldtekt', 'fittetryne', 'kukklest', 'kukkpeis', 'kukkskalle', 'kuklest', 'kukpeis',
        'kukskalle', 'kuktryne', 'rasstryne', 'rautryne', 'rævtryne', 'rævvtryne', 'bruning',
        'hviting', 'neger', 'nigger', 'pakkis', 'svarting', 'homo', 'homse', 'lesbe', 'lespe',
        'pøke', 'skinkerytter', 'soper', 'teppetygger',
    ],

    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'veldig', 'virkelig', 'jævlig', 'absolutt', 'totalt', 'fullstendig',
        'bokstavelig', 'seriøst', 'fordømt', 'ekstremt', 'super', 'utrolig',
        'latterlig', 'enormt', 'gigantisk', 'kolossalt', 'åpenbart', 'intenst',
        'tungt', 'hardt', 'solid', 'pent', 'godt', 'riktig', 'seriøst',
        'for', 'mye', 'så', 'slik', 'sånn', 'så jævlig', 'så faen',
    ],

    // Words that indicate a more aggressive/negative language
    'negative_modifiers' => [
        'hat', 'hater', 'drepe', 'dø', 'død', 'ødelegge', 'dum', 'idiot',
        'moron', 'tåpe', 'elendig', 'angripe', 'skade', 'stygg', 'motbydelig',
        'forferdelig', 'fæl', 'verst', 'dårlig', 'ekkel', 'avskyelig', 'sint',
        'rasende', 'forbannet', 'helvete', 'irriterende', 'irriterer', 'forakt',
        'avsky', 'foraktelig', 'ubrukelig', 'verdiløs', 'ekkel', 'slem', 'ond',
        'grusom', 'brutal', 'vill', 'tispe', 'drittsekk', 'dritt', 'syk',
        'forvridd', 'pervers', 'forstyrret', 'gal', 'sprø', 'psyko', 'psykotisk',
        'galning', 'sinnsyk', 'uhøflig', 'slem', 'aggressiv', 'voldelig',
        'truende', 'fiendtlig', 'skremmende', 'mobbing', 'trakassering',
        'fornærmende', 'søppel', 'søppelbøtte', 'taper', 'fiasko', 'inkompetent',
        'udugelig', 'utilstrekkelig', 'håpløs', 'elendig', 'ynkelig', 'foraktelig',
        'motbydelig', 'avskyelig', 'hatsk', 'ondsinnet', 'giftig',
    ],

    // Words that indicate a mitigating/positive language
    'positive_modifiers' => [
        'kjærlighet', 'elske', 'like', 'god', 'flott', 'fantastisk', 'utrolig',
        'vidunderlig', 'utmerket', 'ypperlig', 'strålende', 'brilliant', 'kul',
        'fin', 'beste', 'vakker', 'nyte', 'fornøyd', 'glad', 'lykkelig', 'henrykt',
        'imponerende', 'perfekt', 'fenomenal', 'praktfull', 'storslagen',
        'enestående', 'ekstraordinær', 'eksepsjonell', 'bemerkelsesverdig',
        'spektakulær', 'pustløs', 'vakker', 'nydelig', 'søt', 'sjarmerende',
        'behagelig', 'tilfredsstillende', 'givende', 'spennende', 'opphissende',
        'underholdende', 'morsom', 'festlig', 'humoristisk', 'interessant',
        'engasjerende', 'fengslende', 'fascinerende', 'intrigerende',
        'overbevisende', 'attraktiv', 'beundringsverdig', 'prisverdig',
        'imponerende', 'dyktig', 'talentfull', 'kreativ', 'oppfinnsom', 'smart',
        'intelligent', 'klok', 'innsiktsfull', 'gjennomtenkt', 'hensynsfull',
        'snill', 'vennlig', 'varm', 'omsorgsfull', 'hjelpsom', 'støttende',
        'oppmuntrende', 'positiv', 'optimistisk', 'håpefull', 'inspirerende',
    ],

    // Words that indicate a scientific or educational language
    'educational_context' => [
        'forskning', 'studie', 'analyse', 'utdanning', 'pedagogisk', 'akademisk',
        'vitenskapelig', 'medisinsk', 'biologisk', 'historie', 'historisk',
        'litteratur', 'politisk', 'psykologi', 'sosiologi', 'antropologi',
        'lingvistikk', 'avhandling', 'avhandling', 'doktoravhandling', 'forelesning',
        'forklare', 'forklaring', 'definisjon', 'definere', 'analysere', 'undersøke',
        'diskutere', 'kurs', 'universitet', 'høgskole', 'professor', 'doktorgrad',
        'teori', 'konsept', 'klasserom', 'vitenskap', 'eksperiment', 'laboratorium',
        'klinisk', 'anatomi', 'fysiologi', 'biologi', 'lærebok', 'pensum',
        'tidsskrift', 'publikasjon', 'artikkel', 'undersøke',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'du', 'deg', 'din', 'ditt', 'dine', 'de', 'dem', 'deres',
        'han', 'ham', 'hans', 'hun', 'henne', 'hennes', 'vi', 'oss', 'vår',
        'vårt', 'våre', 'det', 'den', 'denne', 'dette', 'disse', 'disse',
        'hvem', 'hva', 'hvilken', 'hvilket', 'hvilke', 'hvordan', 'hvorfor',
        'hvor', 'når', 'man', 'en', 'ens', 'meg', 'mitt', 'mine',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'sa', 'sier', 'si', 'siterte', 'siterer', 'ifølge', 'hevdet', 'hevder',
        'uttalte', 'uttaler', 'skrev', 'skriver', 'nevnte', 'nevner', 'twitret',
        'twitrer', 'rapporterte', 'rapporterer', 'kommenterte', 'kommenterer',
        'bemerket', 'bemerker', 'la til', 'legger til', 'påpekte', 'påpeker',
        'understreket', 'understreker', 'forklarte', 'forklarer',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'unnskyld', 'beklager', 'sorry', 'tilgi', 'tilgivelse', 'lei for det',
        'lei meg', 'beklagelig', 'dessverre', 'angrer', 'anger', 'skam',
        'skamfull', 'skyldig', 'skyld', 'forlegenhet', 'forlegen',
    ],

    // Common words used for language detection
    'language_markers' => [
        'og', 'eller', 'men', 'at', 'når', 'hvis', 'fordi', 'skjønt', 'som',
        'slik', 'samt', 'altså', 'derfor', 'så', 'dermed', 'således', 'ikke',
        'ingen', 'nei', 'ja', 'men', 'for', 'siden', 'var', 'er', 'har', 'hadde',
        'vil', 'ville', 'kan', 'kunne', 'må', 'måtte', 'skal', 'skulle', 'bør',
        'burde', 'jeg', 'du', 'han', 'hun', 'vi', 'dere', 'de', 'meg', 'deg',
        'ham', 'henne', 'oss', 'dem', 'denne', 'dette', 'disse', 'den', 'det',
        'de', 'min', 'din', 'sin', 'vår', 'deres', 'mitt', 'ditt', 'sitt',
        'vårt', 'hennes', 'hans', 'dens', 'dets',
    ],

    // Word-specific safe language patterns (regex patterns)
    'word_specific_patterns' => [
        'fitte' => [
            '/\b(anatomi|gynekologi|medisin|biologi).*\bfitte\b/i',  // Contexto médico
            '/\b(akademisk|studie|forskning).*\bfitte\b/i',  // Contexto académico
        ],
        'kuk' => [
            '/\b(hane|fugl|gjøk).*\bkuk\b/i',  // Referencia a aves (gallo, etc.)
            '/\b(anatomi|medisin|biologi).*\bkuk\b/i',  // Contexto médico
            '/\b(kukkeliku|kukkeli|kukkene)\b/i',  // Palabras relacionadas con el canto del gallo
        ],
        'faen' => [
            '/\b(djevelen|satan|religion|bibel).*\bfaen\b/i',  // Contexto religioso/demoniaco
            '/\b(uttryck|uttrykk|utrop|uttrykksform).*\bfaen\b/i',  // Como expresión lingüística
        ],
        'helvete' => [
            '/\b(religion|bibel|kristen|teologi).*\bhelvete\b/i',  // Contexto religioso
            '/\b(uttrykk|metafor|lignelse).*\bhelvete\b/i',  // Como expresión o metáfora
        ],
        'dritt' => [
            '/\b(avføring|ekskrement|gjødsel).*\bdritt\b/i',  // Contexto biológico/agrícola
            '/\b(kompost|jord|plante).*\bdritt\b/i',  // Contexto de jardinería
        ],
        'hore' => [
            '/\b(historisk|prostitusjon|forskning).*\bhore\b/i',  // Contexto histórico/académico
            '/\b(litteratur|film|karakter).*\bhore\b/i',  // Contexto literario/artístico
        ],
    ],
];
