<?php

/**
 * German context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'sehr', 'wirklich', 'absolut', 'total', 'komplett', 'völlig', 'vollkommen',
        'ganz', 'voll', 'extrem', 'unglaublich', 'verdammt', 'verflucht', 'verdammte',
        'verfickte', 'scheiß', 'beschissene', 'gottverdammte', 'so', 'derart', 'dermaßen',
        'wahnsinnig', 'irrsinnig', 'unfassbar', 'krass', 'heftig', 'brutal', 'enorm',
        'massiv', 'außerordentlich', 'außergewöhnlich', 'besonders', 'höchst', 'überaus',
        'zutiefst', 'gründlich', 'entschieden', 'regelrecht', 'richtig', 'geradezu',
        'unverschämt', 'unheimlich', 'saumäßig', 'saustark', 'hammermäßig', 'tierisch',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'hass', 'hassen', 'töten', 'morden', 'sterben', 'tot', 'zerstören', 'dumm',
        'idiotisch', 'blöd', 'dämlich', 'bescheuert', 'bekloppt', 'angreifen', 'verletzen',
        'hässlich', 'eklig', 'ekelhaft', 'schrecklich', 'furchtbar', 'schlimm', 'schlecht',
        'widerlich', 'abstoßend', 'ärgerlich', 'nervtötend', 'wütend', 'zornig', 'hölle',
        'verlierer', 'versager', 'missraten', 'verachten', 'verabscheuen', 'abscheulich',
        'nutzlos', 'wertlos', 'gemein', 'böse', 'übel', 'grausam', 'brutal', 'rücksichtslos',
        'unmenschlich', 'pervers', 'krank', 'verdorben', 'gestört', 'irre', 'wahnsinnig',
        'verrückt', 'unverschämt', 'frech', 'respektlos', 'beleidigend', 'aggressiv',
        'gewalttätig', 'bedrohlich', 'feindselig', 'angriffslustig', 'schikanierend',
        'belästigend', 'missbräuchlich', 'anstößig', 'kränkend', 'müll', 'abfall',
        'versagen', 'unfähig', 'unbeholfen', 'unzulänglich', 'hoffnungslos', 'elend',
        'jämmerlich', 'verächtlich', 'abstoßend', 'widerwärtig', 'abscheulich',
        'hasserfüllt', 'gehässig', 'rachsüchtig', 'bösartig', 'überwältigend',
        'giftig', 'schädlich', 'zerstörerisch', 'ruinierend', 'verheerend',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'liebe', 'lieben', 'liebevoll', 'mögen', 'gut', 'großartig', 'toll', 'super',
        'wunderbar', 'erstaunlich', 'ausgezeichnet', 'hervorragend', 'fantastisch',
        'außergewöhnlich', 'brillant', 'cool', 'nett', 'freundlich', 'beste', 'schön',
        'hübsch', 'genießen', 'glücklich', 'froh', 'zufrieden', 'begeistert', 'beeindruckend',
        'perfekt', 'spektakulär', 'fabelhaft', 'phänomenal', 'herrlich', 'prächtig',
        'prachtvoll', 'exzellent', 'optimal', 'ideal', 'vortrefflich', 'tadellos',
        'einwandfrei', 'meisterhaft', 'mustergültig', 'vorbildlich', 'beispielhaft',
        'makellos', 'fehlerlos', 'vollkommen', 'vollständig', 'unbeschreiblich', 'unübertroffen',
        'unvergleichlich', 'unschlagbar', 'einzigartig', 'originell', 'einfallsreich',
        'kreativ', 'innovativ', 'erfinderisch', 'bahnbrechend', 'wegweisend', 'visionär',
        'zukunftsweisend', 'fortschrittlich', 'fortgeschritten', 'entwickelt', 'ausgereift',
        'elegant', 'stilvoll', 'geschmackvoll', 'ansprechend', 'attraktiv', 'anziehend',
        'fesselnd', 'packend', 'spannend', 'aufregend', 'belebend', 'erfrischend',
        'erquickend', 'belebend', 'vitalisierend', 'energiegeladen', 'schwungvoll',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'forschung', 'studie', 'analyse', 'bildung', 'bildungs', 'pädagogisch', 'akademisch',
        'wissenschaftlich', 'medizinisch', 'biologisch', 'geschichte', 'historisch', 'literatur',
        'psychologie', 'soziologie', 'anthropologie', 'linguistik', 'arbeit', 'these', 'dissertation',
        'vortrag', 'erklären', 'erklärung', 'definition', 'definieren', 'analysieren', 'untersuchen',
        'diskutieren', 'kurs', 'universität', 'hochschule', 'professor', 'doktor', 'theorie', 'konzept',
        'essay', 'artikel', 'veröffentlichung', 'forschen', 'experimentieren', 'experiment', 'labor',
        'wissenschaft', 'seminar', 'kolloquium', 'symposium', 'kongress', 'klasse', 'schule', 'institut',
        'lehre', 'unterricht', 'schulung', 'ausbildung', 'lernen', 'studieren', 'lehrbuch', 'handbuch',
        'kompendium', 'nachschlagewerk', 'enzyklopädie', 'wörterbuch', 'lexikon', 'bibliothek', 'archiv',
        'dokumentation', 'katalog', 'verzeichnis', 'sammlung', 'übersicht', 'zusammenfassung', 'resümee',
        'fazit', 'schlussfolgerung', 'ergebnis', 'resultat', 'erkenntnisse', 'einsichten', 'wissen',
        'kenntnisse', 'fertigkeiten', 'kompetenzen', 'fähigkeiten', 'qualifikationen', 'expertise',
        'sachverstand', 'fachwissen', 'spezialkenntnisse', 'spezialwissen', 'daten', 'fakten',
        'information', 'informationen', 'details', 'einzelheiten', 'zusammenhänge', 'kontext',
        'hintergrund', 'grundlagen', 'prinzipien', 'gesetzmäßigkeiten', 'regeln', 'normen',
        'standards', 'richtlinien', 'leitlinien', 'vorgaben', 'anforderungen', 'maßstäbe',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'du', 'dich', 'dir', 'dein', 'deine', 'deiner', 'deines', 'deinem', 'deinen',
        'ihr', 'euch', 'eure', 'eurer', 'eures', 'eurem', 'euren', 'sie', 'ihnen',
        'ihrer', 'ihres', 'ihrem', 'ihren', 'er', 'ihn', 'ihm', 'sein', 'seine',
        'seiner', 'seines', 'seinem', 'seinen', 'wir', 'uns', 'unser', 'unsere',
        'unserer', 'unseres', 'unserem', 'unseren', 'ich', 'mich', 'mir', 'mein',
        'meine', 'meiner', 'meines', 'meinem', 'meinen', 'dieser', 'diese', 'dieses',
        'diesem', 'diesen', 'jener', 'jene', 'jenes', 'jenem', 'jenen', 'solcher',
        'solche', 'solches', 'solchem', 'solchen', 'wer', 'wen', 'wem', 'wessen',
        'welcher', 'welche', 'welches', 'welchem', 'welchen', 'der', 'die', 'das',
        'dem', 'den', 'dessen', 'deren', 'denen', 'selbst', 'selber', 'einander',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'sagt', 'sagte', 'gesagt', 'zitiert', 'zitierte', 'laut', 'nach', 'gemäß', 'zufolge',
        'behauptet', 'behauptete', 'erklärt', 'erklärte', 'schreibt', 'schrieb', 'geschrieben',
        'erwähnt', 'erwähnte', 'twittert', 'twitterte', 'getwittert', 'äußert', 'äußerte',
        'geäußert', 'berichtet', 'berichtete', 'kommentiert', 'kommentierte', 'bemerkt',
        'bemerkte', 'hingewiesen', 'hingewiesen auf', 'betont', 'betonte', 'hervorgehoben',
        'hervorgehoben', 'unterstrichen', 'unterstrichen', 'angemerkt', 'angemerkt', 'vorgeschlagen',
        'vorgeschlagen', 'angedeutet', 'angedeutet', 'verkündet', 'verkündete', 'verkündet',
        'geschrien', 'geschrien', 'ausgerufen', 'ausgerufen', 'erklärt', 'erklärt', 'erzählt',
        'erzählte', 'schildert', 'schilderte', 'beschreibt', 'beschrieb', 'kommuniziert',
        'kommunizierte', 'übermittelt', 'übermittelte', 'enthüllt', 'enthüllte', 'bestätigt',
        'bestätigte', 'berichtet', 'berichtete', 'informierte', 'informiert', 'mitteilte', 'mitteilt',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'entschuldigung', 'entschuldige', 'entschuldigen', 'verzeihung', 'verzeihen',
        'verzeiht', 'tut mir leid', 'tut uns leid', 'bedaure', 'bedauern', 'bedauerlich',
        'leider', 'unglücklicherweise', 'traurig', 'traurigerweise', 'schade', 'schändlich',
        'peinlich', 'missverständnis', 'missverstandene', 'missverstanden', 'fehlinterpretation',
        'fehlinterpretiert', 'fehler', 'irrtum', 'irrtümlich', 'falsch', 'falsche', 'versehen',
        'unabsichtlich', 'nicht beabsichtigt', 'nicht gewollt', 'ungewollt', 'nicht geplant',
        'nicht vorgesehen', 'unpassend', 'unangebracht', 'unangemessen', 'ungeeignet',
        'unerhört', 'unschicklich', 'respektlos', 'pietätlos', 'taktlos', 'geschmacklos',
        'stillos', 'unmanierlich', 'unhöflich', 'unfreundlich', 'unverschämt', 'rücksichtslos',
    ],

    // Common words used for language detection
    'language_markers' => [
        'der', 'die', 'das', 'ein', 'eine', 'und', 'oder', 'aber', 'wenn', 'weil', 'denn',
        'von', 'mit', 'zu', 'auf', 'in', 'an', 'aus', 'nach', 'bei', 'um', 'für', 'durch',
        'gegen', 'ohne', 'zwischen', 'hinter', 'vor', 'neben', 'über', 'unter', 'ich', 'du',
        'er', 'sie', 'es', 'wir', 'ihr', 'sein', 'haben', 'werden', 'können', 'müssen', 'sollen',
        'wollen', 'dürfen', 'mögen', 'gehen', 'kommen', 'machen', 'sagen', 'sehen', 'hören',
        'denken', 'glauben', 'meinen', 'wissen', 'kennen', 'finden', 'suchen', 'geben', 'nehmen',
        'bringen', 'holen', 'stellen', 'legen', 'setzen', 'hier', 'dort', 'heute', 'morgen',
        'gestern', 'jetzt', 'später', 'früher', 'immer', 'nie', 'oft', 'selten', 'manchmal',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // Als in "anale Phase" (Psychologie)
        'sex',              // Biologisches Geschlecht, Geschlechterstudien
        'sexuell',          // Wissenschaftliche Kontexte
        'sexualität',       // Akademische Diskussionen
        'geschlechtsverkehr', // Biologie, Wissenschaft
        'reproduktion',     // Biologie, Wissenschaft
        'penis',            // Anatomie, Biologie
        'vagina',           // Anatomie, Biologie
        'brust',            // Anatomie, Biologie
        'busen',            // Anatomie, Biologie
        'rektum',           // Anatomie, Biologie
        'hoden',            // Anatomie, Biologie
        'eierstock',        // Anatomie, Biologie
        'gebärmutter',      // Anatomie, Biologie
        'menstruation',     // Anatomie, Biologie
        'ejakulation',      // Anatomie, Biologie
        'erektion',         // Anatomie, Biologie
        'orgasmus',         // Anatomie, Biologie
        'sperma',           // Anatomie, Biologie
        'eizelle',          // Anatomie, Biologie
        'zygote',           // Anatomie, Biologie
        'embryo',           // Anatomie, Biologie
        'fötus',            // Anatomie, Biologie
        'konzeption',       // Anatomie, Biologie
        'befruchtung',      // Anatomie, Biologie
        'schwangerschaft',  // Anatomie, Biologie
        'geburt',           // Anatomie, Biologie
        'pubertät',         // Anatomie, Biologie
        'adoleszenz',       // Anatomie, Biologie
        'erwachsenenalter', // Anatomie, Biologie
        'homosexuell',      // Akademische Diskussion, nicht abwertend
        'heterosexuell',    // Akademische Diskussion, nicht abwertend
        'bisexuell',        // Akademische Diskussion, nicht abwertend
        'transgender',      // Akademische Diskussion, nicht abwertend
        'geschlecht',       // Akademische Diskussion, nicht abwertend
        'identität',        // Akademische Diskussion, nicht abwertend
        'orientierung',     // Akademische Diskussion, nicht abwertend
        'präferenz',        // Akademische Diskussion, nicht abwertend
        'anziehung',        // Akademische Diskussion, nicht abwertend
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'schraube',         // Hardware, Konstruktion
        'bang',             // Programmierung (!) Operator
        'strich',           // Grafik, Medizin, Sport
        'ausführen',        // Programmierung, Recht
        'töten',            // Programmierung, Prozessverwaltung
        'selbstmord',       // In Diskussionen über Prävention, psychische Gesundheit
        'master',           // Master/Slave in technischen Kontexten
        'slave',            // Master/Slave in technischen Kontexten
        'ausführung',       // Programmierung, Recht
        'abbrechen',        // Programmierbegriff
        'dummy',            // Testfall, Platzhalter
        'crack',            // Software-Cracking, Geologie
        'kugel',            // Typografie, Munition
        'schießen',         // Fotografie, Sport
        'injektion',        // Medizinisch, Programmierung (SQL-Injektion)
        'penetration',      // Sicherheitstests
        'kraft',            // Physik, Sicherheit (Brute-Force)
        'ausnutzen',        // Sicherheit, Schwachstelle
        'angriff',          // Sicherheit, Netzwerk
        'tot',              // Informatik (toter Link, toter Code)
        'tod',              // Informatik (Tod eines Prozesses)
        'hardcore',         // Informatik (Hardcore-Gaming)
        'hart',             // Informatik (Hardware, Festplatte)
        'weich',            // Informatik (Software)
        'nackt',            // Informatik (nackte Domain)
        'missbrauch',       // Informatik (Missbrauchsberichte)
        'verletzung',       // Informatik (Richtlinienverletzung)
        'treffer',          // Webanalyse, Baseball
        'spülen',           // Informatik (Cache leeren), Sanitär
        'schmutzig',        // Informatik (schmutziges Bit, schmutziges Lesen)
        'haken',            // Programmierung, Sport
        'rennen',           // Informatik (Race Condition)
        'dump',             // Informatik (Memory Dump)
        'loch',             // Sicherheit (Loch), Golf
        'finger',           // Unix-Befehl
        'rohr',             // Programmierung, Sanitär
        'sockel',           // Programmierung, Elektrik
        'dämon',            // Unix-Prozess
        'waise',            // Informatik (Waisenprozess)
        'zombie',           // Informatik (Zombie-Prozess)
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'arsch' => [
            '/\b(schmerz|untersuchung|prüfung|arzt) (des|im|am) arsch\b/i',  // Medizinischer Kontext
            '/\b(esel|maultier|pferd).*\barsch\b/i',           // Tierbezogene Referenzen
            '/\b(arsch) (der welt|vom dienst|kalt|klar|voll)\b/i', // Idiomatische Ausdrücke
            '/\b(arschtritt|arschgeweih|arschkriecher|arschkarte|arschloch)\b/i',  // Zusammengesetzte Wörter
            '/\b(marsch|barsch|harsch|karsch)\b/i',  // Wörter, die "arsch" enthalten
        ],
        'scheiße' => [
            '/\b(kuh|rind|pferd|hund|katze|vogel|tier).*\bscheiße\b/i', // Tierische Ausscheidungen
            '/\b(dünger|kot|exkremente|stuhl|ausscheidung|fäkalien|abfall|kompost).*\bscheiße\b/i', // Landwirtschaftlicher/medizinischer Kontext
            '/\b(archäologie|fossil|koprolith).*\bscheiße\b/i', // Wissenschaftlicher Kontext
            '/\b(schei(ss|ß)e) (bauen|sein|haben|passieren|laufen|gehen)\b/i', // Idiomatische Ausdrücke
        ],
        'ficken' => [
            '/\b(etymologie|linguistik|historischer slang|tabusprache|fluch|schimpfwort).*\bficken\b/i', // Linguistische Studienkontext
            '/\b(soziolinguistik|sprachtabus|verbotenes vokabular).*\bficken\b/i', // Akademischer Kontext
            '/\b(fick) (dich|du|dein|euch|ihr)\b/i', // Grundlegende Beleidigungsformen
        ],
        'schwanz' => [
            '/\b(tier|hund|katze|pferd|vogel|reptil|hahn).*\bschwanz\b/i', // Tiere
            '/\b(schwanz) (wedeln|wackeln|stutzen|einklemmen|einziehen)\b/i', // Tierbezogene Handlungen
            '/\b(schwanz) (flosse|feder|ruder)\b/i', // Tieranatomie
            '/\b(schwanz) (fahne|stern|flugzeug|signal|lampe|scheinwerfer)\b/i', // Gegenstände
        ],
        'mist' => [
            '/\b(bauernhof|stall|pferd|kuh|rind|schaf|ziege|landwirtschaft).*\bmist\b/i', // Landwirtschaftlicher Kontext
            '/\b(dünger|kompost|stroh|boden|erde|pflanze|feld|garten).*\bmist\b/i', // Gartenbau/Landwirtschaft
            '/\b(mist) (gabeln|harken|schaufeln|wenden|laden|streuen|fahren)\b/i', // Landwirtschaftliche Tätigkeiten
            '/\b(mist) (haufen|gabel|karren|lager|platz|grube)\b/i', // Landwirtschaftliche Objekte
        ],
    ],
];
