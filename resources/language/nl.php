<?php

/**
 * Dutch language definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Offensive words from the dictionary
    'offensive_words' => [
        'abortus', 'achterlijk', 'bosneger', 'debiel', 'etterbak', 'flikker', 'flikker op',
        'fock', 'geil', 'godver', 'godverju', 'hoer', 'hoertje', 'homofiel', 'huppelkut',
        'kak', 'kakker', 'kanker', 'kankeren', 'kankerjoch', 'kankerlyer', 'klerelijer',
        'klojo', 'klootzak', 'kut', 'lijer', 'lul', 'lulhannes', 'makak', 'makakken',
        'mof', 'mongool', 'mongolen', 'neger', 'negerin', 'neuk', 'neuken', 'nikker',
        'nsb', 'nsber', 'ouwehoeren', 'paardelul', 'pik', 'pleuris', 'poep', 'poepen', 'pokke',
        'pokkelijer', 'pokkelyer', 'pokken', 'pokkenlyer', 'roetmop', 'rotzak', 'seks', 'slet',
        'sloerie', 'snol', 'spleetoog', 'stoephoer', 'stront', 'sukkel', 'tering', 'teringlyer',
        'tiet', 'tieten', 'tietjes', 'trut', 'tyfus', 'tyfuslijer', 'tyfuslyer', 'verdomme',
        'vetzak', 'zakkewassr', 'zandneger',
    ],

    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'zeer', 'echt', 'absoluut', 'totaal', 'compleet', 'volledig',
        'letterlijk', 'serieus', 'verdomd', 'godverdomme', 'extreem',
        'super', 'ongelooflijk', 'belachelijk', 'ontzettend', 'verschrikkelijk',
        'enorm', 'gigantisch', 'kolossaal', 'overduidelijk', 'intens',
        'zwaar', 'hard', 'stevig', 'knap', 'goed', 'flink', 'serieus',
        'te', 'veel', 'zo', 'zulke', 'dermate', 'dusdanig',
    ],

    // Words that indicate a more aggressive/negative language
    'negative_modifiers' => [
        'haat', 'haten', 'doden', 'vermoorden', 'sterven', 'doodgaan',
        'vernietigen', 'stom', 'idioot', 'dom', 'aanvallen', 'aanval',
        'verwonden', 'lelijk', 'walgelijk', 'afschuwelijk', 'verschrikkelijk',
        'ergste', 'slecht', 'smerig', 'erg', 'boos', 'woedend', 'kwaad',
        'klootzak', 'hel', 'loser', 'verliezer', 'irritant', 'irriteren',
        'verachten', 'minachten', 'afschuw', 'verachtelijk', 'nutteloos',
        'waardeloos', 'vies', 'gemeen', 'kwaadaardig', 'slecht', 'rot',
        'gestoord', 'ziek', 'geschifit', 'beledigend', 'grof', 'agressief',
        'gewelddadig', 'bedreigend', 'vijandig', 'intimiderend', 'pesten',
        'lastigvallen', 'misbruik', 'beledigend', 'afval', 'mislukking',
        'incompetent', 'onbekwaam', 'hopeloos', 'ellendig', 'zielig',
        'verachtelijk', 'weerzinwekkend', 'hatelijk', 'kwaadaardig', 'giftig',
    ],

    // Words that indicate a mitigating/positive language
    'positive_modifiers' => [
        'liefde', 'houden van', 'leuk', 'aardig', 'goed', 'geweldig', 'fantastisch',
        'amazing', 'prachtig', 'mooi', 'uitstekend', 'excellent', 'schitterend',
        'briljant', 'cool', 'fijn', 'beste', 'genieten', 'gelukkig', 'blij',
        'tevreden', 'indrukwekkend', 'perfect', 'geweldig', 'schitterend',
        'fenomenaal', 'prachtig', 'magnifiek', 'buitengewoon', 'uitzonderlijk',
        'opmerkelijk', 'spectaculair', 'adembenemend', 'mooi', 'lief', 'schattig',
        'bekoorlijk', 'aangenaam', 'bevredigend', 'opwindend', 'spannend',
        'vermakelijk', 'leuk', 'grappig', 'hilarisch', 'komisch', 'interessant',
        'boeiend', 'fascinerend', 'intrigerend', 'aantrekkelijk', 'bewonderenswaardig',
        'lovenswaardig', 'indrukwekkend', 'bekwaam', 'vaardig', 'getalenteerd',
        'creatief', 'slim', 'intelligent', 'wijs', 'inzichtelijk', 'attent',
        'vriendelijk', 'warm', 'zorgzaam', 'behulpzaam', 'ondersteunend',
        'bemoedigend', 'positief', 'optimistisch', 'hoopvol', 'inspirerend',
    ],

    // Words that indicate a scientific or educational language
    'educational_context' => [
        'onderzoek', 'studie', 'analyse', 'opleiding', 'educatief', 'academisch',
        'wetenschappelijk', 'medisch', 'biologisch', 'geschiedenis', 'historisch',
        'literatuur', 'politiek', 'psychologie', 'sociologie', 'anthropologie',
        'taalkunde', 'paper', 'thesis', 'dissertatie', 'lezing', 'uitleg',
        'verklaring', 'definitie', 'definiëren', 'analyseren', 'onderzoeken',
        'bespreken', 'cursus', 'universiteit', 'hogeschool', 'professor', 'doctoraal',
        'theorie', 'concept', 'klaslokaal', 'wetenschap', 'experiment', 'laboratorium',
        'klinisch', 'anatomie', 'fysiologie', 'biologie', 'leerboek', 'curriculum',
        'tijdschrift', 'publicatie', 'artikel', 'onderzoeken',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'je', 'jij', 'jou', 'jouw', 'jullie', 'u', 'uw', 'uzelf',
        'zij', 'ze', 'hun', 'hen', 'zichzelf', 'hij', 'hem', 'zijn',
        'hemzelf', 'zij', 'haar', 'haarzelf', 'wij', 'we', 'ons', 'onze',
        'onszelf', 'het', 'zijn', 'zichzelf', 'wie', 'welke', 'dat', 'die',
        'dit', 'deze', 'die',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'zei', 'zegt', 'zeggen', 'geciteerd', 'citeert', 'citeren', 'volgens',
        'beweerde', 'beweert', 'beweren', 'verklaarde', 'verklaart', 'verklaren',
        'schreef', 'schrijft', 'schrijven', 'vermeld', 'vermeldt', 'vermelden',
        'tweette', 'twittert', 'twitteren', 'rapporteerde', 'rapporteert',
        'rapporteren', 'reageerde', 'reageert', 'reageren', 'merkte op', 'merkt op',
        'opmerken', 'uitte', 'uit', 'uiten', 'getuigde', 'getuigt', 'getuigen',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'sorry', 'excuses', 'verontschuldiging', 'verontschuldigen', 'excuseren',
        'spijt', 'berouw', 'pardon', 'neem me niet kwalijk', 'vergeef me',
        'vergeving', 'vergeven', 'het spijt me', 'neem het me niet kwalijk',
        'excuus', 'vergeef', 'vergeeft', 'vergiffenis', 'verontschuldig',
    ],

    // Common words used for language detection
    'language_markers' => [
        'de', 'het', 'een', 'en', 'of', 'in', 'op', 'bij', 'door',
        'voor', 'met', 'van', 'naar', 'over', 'aan', 'om', 'is', 'zijn',
        'was', 'waren', 'ben', 'bent', 'hebben', 'heeft', 'had', 'hadden',
        'zal', 'zullen', 'zou', 'zouden', 'kan', 'kunnen', 'kon', 'konden',
        'mag', 'mogen', 'mocht', 'mochten', 'moet', 'moeten', 'moest', 'moesten',
        'die', 'dat', 'deze', 'dit', 'er', 'hier', 'daar', 'toen',
        'nu', 'dan', 'als', 'wanneer', 'hoe', 'wat', 'waarom', 'wie', 'wiens',
        'welke', 'welk', 'ik', 'mij', 'me', 'mijn', 'jij', 'je', 'jou', 'jouw',
        'hij', 'hem', 'zijn', 'zij', 'ze', 'haar', 'het', 'wij', 'we', 'ons',
        'onze', 'jullie', 'je', 'jou', 'jouw', 'zij', 'ze', 'hen', 'hun', 'zeer',
        'erg', 'veel', 'weinig', 'meer', 'meest', 'minder', 'minst', 'zo', 'hoe',
        'niet', 'geen', 'wel', 'ja', 'nee', 'maar', 'want', 'omdat', 'daarom',
        'dus', 'hoewel', 'toch', 'terwijl',
    ],

    // Word-specific safe language patterns (regex patterns)
    'word_specific_patterns' => [
        'kut' => [
            '/\b(ongeluk|kortste|afkort).*\bkut\b/i',  // Palabras con 'kut' como parte de otra palabra
            '/\b(computerkut|toetsenbordkut|laptopkut)\b/i',  // Términos técnicos o compuestos
            '/\b(snij|mes|werk).*\bkut\b/i',  // Contextos de corte o trabajo
        ],
        'lul' => [
            '/\b(fluit|instrument|muziek).*\blul\b/i',  // Contexto musical (flauta en holandés arcaico)
            '/\b(waterlul|tuinlul|sproeilul)\b/i',  // Términos de jardinería o riego
            '/\b(lullaby|lullend|lullig)\b/i',  // Palabras que contienen 'lul' sin sentido ofensivo
        ],
        'neuk' => [
            '/\b(ver|door|af|aan|in|uit|weg)neuk/i',  // Usos como prefijo con neutralidad técnica
            '/\b(meubel|hout|timmer).*\bneuk\b/i',  // Contexto de carpintería
        ],
        'pik' => [
            '/\b(specht|vogel|duif|kip).*\bpik\b/i',  // Contexto de aves (picoteo)
            '/\b(pikeren|piket|pikant|pikeur|pikken)\b/i',  // Palabras que contienen 'pik' sin sentido ofensivo
            '/\b(hout|ijs|steen).*\bpik\b/i',  // Herramientas o contextos de materiales
        ],
        'slet' => [
            '/\b(af|door|uit|weg).*\bslet\b/i',  // Contextos de desgaste o uso (verbo 'slijten')
            '/\b(ver|ont)sleten\b/i',  // Formas del verbo 'slijten' (desgastar)
        ],
        'hoer' => [
            '/\b(historisch|geschiedkundig|verleden).*\bhoer\b/i',  // Contexto histórico
            '/\b(studie|onderzoek|artikel).*\bprostitutie\b.*\bhoer\b/i',  // Contexto académico
        ],
    ],
];
