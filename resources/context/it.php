<?php

/**
 * Italian context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that are considered offensive
    'offensive_words' => [
        'allupato', 'ammucchiata', 'anale', 'arrapato', 'arrusa', 'arruso', 'assatanato', 'bagascia',
        'bagassa', 'bagnarsi', 'baldracca', 'balle', 'battere', 'battona', 'belino', 'biga',
        'bocchinara', 'bocchino', 'bofilo', 'boiata', 'bordello', 'brinca', 'bucaiolo', 'budiùlo',
        'buona donna', 'busone', 'cacca', 'caccati in mano e prenditi a schiaffi', 'caciocappella',
        'cadavere', 'cagare', 'cagata', 'cagna', 'cammello', 'cappella', 'carciofo', 'carità',
        'casci', 'cazzata', 'cazzimma', 'cazzo', 'checca', 'chiappa', 'chiavare', 'chiavata',
        'ciospo', 'ciucciami il cazzo', 'coglione', 'coglioni', 'cornuto', 'cozza', 'culattina',
        'culattone', 'culo', 'di merda', 'ditalino', 'duro', 'fare unaŠ', 'fava', 'femminuccia',
        'fica', 'figa', 'figlio di buona donna', 'figlio di puttana', 'figone', 'finocchio',
        'fottere', 'fottersi', 'fracicone', 'fregna', 'frocio', 'froscio', 'fuori come un balcone',
        'goldone', 'grilletto', 'guanto', 'guardone', 'incazzarsi', 'incoglionirsi', 'ingoio',
        "l'arte bolognese", 'leccaculo', 'lecchino', 'lofare', 'loffa', 'loffare', 'lumaca',
        'manico', 'mannaggia', 'merda', 'merdata', 'merdoso', 'mignotta', 'minchia', 'minchione',
        'mona', 'monta', 'montare', 'mussa', 'nave scuola', 'nerchia', 'nudo', 'padulo', 'palle',
        'palloso', 'patacca', 'patonza', 'pecorina', 'pesce', 'picio', 'pincare', 'pipa', 'pipì',
        'pippone', 'pirla', 'pisciare', 'piscio', 'pisello', 'pistola', 'pistolotto', 'pomiciare',
        'pompa', 'pompino', 'porca', 'porca madonna', 'porca miseria', 'porca puttana', 'porco due',
        'porco zio', 'potta', 'puppami', 'puttana', 'quaglia', 'recchione', 'regina', 'rincoglionire',
        'rizzarsi', 'rompiballe', 'ruffiano', 'sbattere', 'sbattersi', 'sborra', 'sborrata',
        'sborrone', 'sbrodolata', 'scopare', 'scopata', 'scorreggiare', 'sega', 'slinguare',
        'slinguata', 'smandrappata', 'soccia', 'socmel', 'sorca', 'spagnola', 'spompinare',
        'sticchio', 'stronza', 'stronzata', 'stronzo', 'succhiami', 'sveltina', 'sverginare',
        'tarzanello', 'terrone', 'testa di cazzo', 'tette', 'tirare', 'topa', 'troia', 'trombare',
        'uccello', 'vacca', 'vaffanculo', 'vangare', 'venire', 'zinne', 'zio cantante', 'affanculo',
        'bagascia', 'baldracca', 'battona', 'bocchinara', 'bocchinaro', 'cazzi', 'cazzo',
        'chiavare', 'coglione', 'culattone', 'dio bestia', 'dio cane', 'dio porco',
        'fanculo', 'fica', 'figa', 'fottere', 'frocio', 'inculare', 'mignotta', 'minchia',
        'pompinara', 'pompino', 'porco dio', 'puttana', 'ricchione', 'rottinculo', 'sborra',
        'segaiolo', 'troia', 'troietta', 'troiona', 'troione', 'vaffanculo', 'zoccola',
    ],
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'molto', 'davvero', 'assolutamente', 'totalmente', 'completamente',
        'interamente', 'letteralmente', 'seriamente', 'estremamente', 'tremendamente',
        'incredibilmente', 'maledettamente', 'dannatamente', 'straordinariamente',
        'terribilmente', 'veramente', 'proprio', 'troppo', 'decisamente', 'super',
        'iper', 'ultra', 'mega', 'gran', 'grande', 'grosso', 'enorme', 'immenso',
        'pazzesco', 'folle', 'assurdo', 'pazzamente', 'follemente', 'smisuratamente',
        'fottutamente', 'cazzo', 'cavolo', 'diavolo', 'porco', 'porcodio', 'stramaledetto',
        'stracazzo', 'straordinario', 'assai', 'particolarmente', 'specialmente',
        'eccessivamente', 'oltremodo', 'talmente', 'così', 'tanto', 'altamente',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'odio', 'odiare', 'odiando', 'uccidere', 'uccidendo', 'morire', 'morendo',
        'distruggere', 'distruggendo', 'stupido', 'stupida', 'idiota', 'imbecille',
        'cretino', 'cretina', 'attaccare', 'attaccando', 'ferire', 'ferendo',
        'brutto', 'brutta', 'schifoso', 'schifosa', 'disgustoso', 'disgustosa',
        'orribile', 'terribile', 'peggiore', 'cattivo', 'cattiva', 'ripugnante',
        'irritante', 'arrabbiato', 'arrabbiata', 'inferno', 'perdente', 'fallito',
        'fallita', 'spregevole', 'miserabile', 'inutile', 'sporco', 'sporca', 'lurido',
        'lurida', 'malato', 'malata', 'pazzo', 'pazza', 'folle', 'violento', 'violenta',
        'brutale', 'sadico', 'sadica', 'perverso', 'perversa', 'crudele', 'maligno',
        'maligna', 'vendicativo', 'vendicativa', 'malizioso', 'maliziosa', 'velenoso',
        'velenosa', 'tossico', 'tossica', 'nocivo', 'nociva', 'dannoso', 'dannosa',
        'distruttivo', 'distruttiva', 'devastante', 'caotico', 'caotica', 'abusivo',
        'abusiva', 'offensivo', 'offensiva', 'grossolano', 'grossolana', 'volgare',
        'minaccioso', 'minacciosa', 'intimidatorio', 'intimidatoria', 'aggressivo',
        'aggressiva', 'ostile', 'nemico', 'nemica', 'sospetto', 'sospetta', 'intollerante',
        'intollerabile', 'aborrito', 'aborrita', 'aborrevole', 'abominevole', 'infame',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'amore', 'amare', 'amando', 'piacere', 'piacendo', 'buono', 'buona', 'ottimo',
        'ottima', 'incredibile', 'meraviglioso', 'meravigliosa', 'eccellente', 'fantastico',
        'fantastica', 'straordinario', 'straordinaria', 'brillante', 'magnifico',
        'magnifica', 'splendido', 'splendida', 'bello', 'bella', 'godere', 'godendo',
        'felice', 'contento', 'contenta', 'incantato', 'incantata', 'impressionante',
        'perfetto', 'perfetta', 'spettacolare', 'soddisfatto', 'soddisfatta', 'gradevole',
        'stupendo', 'stupenda', 'formidabile', 'fenomenale', 'divino', 'divina',
        'sublime', 'celestiale', 'celestial', 'paradisiaco', 'paradisiaca', 'superbo',
        'superba', 'eccezionale', 'squisito', 'squisita', 'delizioso', 'deliziosa',
        'delicato', 'delicata', 'armonioso', 'armoniosa', 'incantevole', 'affascinante',
        'attraente', 'seducente', 'ammaliante', 'avvincente', 'coinvolgente', 'interessante',
        'intrigante', 'stimolante', 'lodevole', 'ammirevole', 'adorabile', 'prezioso',
        'preziosa', 'gratificante', 'appagante', 'soddisfacente', 'piacevole', 'gradevole',
        'simpatico', 'simpatica', 'adorato', 'adorata', 'venerato', 'venerata', 'benedetto', 'benedetta',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'ricerca', 'studio', 'analisi', 'educazione', 'educativo', 'educativa', 'accademico', 'accademica',
        'scientifico', 'scientifica', 'medico', 'medica', 'biologico', 'biologica', 'storia', 'storico', 'storica',
        'letteratura', 'psicologia', 'sociologia', 'antropologia', 'linguistica', 'lavoro', 'tesi', 'dissertazione',
        'conferenza', 'spiegare', 'spiegazione', 'definizione', 'definire', 'analizzare', 'esaminare', 'discutere',
        'corso', 'università', 'collegio', 'professore', 'professoressa', 'dottorale', 'dottorato', 'teoria', 'concetto',
        'saggio', 'articolo', 'pubblicazione', 'ricercare', 'sperimentare', 'esperimento', 'laboratorio', 'scienza',
        'seminario', 'colloquio', 'simposio', 'congresso', 'classe', 'scuola', 'istituto', 'insegnamento',
        'apprendimento', 'studio', 'studente', 'studentessa', 'alunno', 'alunna', 'maestro', 'maestra',
        'docente', 'pedagogico', 'pedagogica', 'didattico', 'didattica', 'curriculum', 'materia', 'disciplina',
        'capitolo', 'volume', 'enciclopedia', 'dizionario', 'glossario', 'vocabolario', 'lessico', 'grammatica',
        'ortografia', 'sintassi', 'semantica', 'pragmatica', 'fonetica', 'fonologia', 'morfologia', 'etimologia',
        'filologia', 'linguistica', 'idioma', 'lingua', 'linguaggio', 'dialetto', 'parlato', 'accento', 'pronunzia',
        'articolazione', 'intonazione', 'prosodia', 'accentuazione', 'punteggiatura', 'scrittura', 'redazione',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'tu', 'te', 'ti', 'voi', 'vi', 'loro', 'lui', 'lei', 'esso', 'essa', 'essi', 'esse',
        'lo', 'la', 'li', 'le', 'gli', 'suo', 'sua', 'suoi', 'sue', 'tuo', 'tua', 'tuoi', 'tue',
        'nostro', 'nostra', 'nostri', 'nostre', 'vostro', 'vostra', 'vostri', 'vostre',
        'mi', 'ci', 'si', 'ne', 'questo', 'questa', 'questi', 'queste', 'quello', 'quella',
        'quelli', 'quelle', 'ciò', 'chi', 'che', 'cui', 'quale', 'quali', 'quanto', 'quanta',
        'quanti', 'quante', 'chiunque', 'qualunque', 'qualsiasi', 'ognuno', 'ognuna',
        'qualcosa', 'niente', 'nulla', 'alcuno', 'alcuna', 'alcuni', 'alcune', 'tutto',
        'tutta', 'tutti', 'tutte', 'altro', 'altra', 'altri', 'altre', 'stesso', 'stessa',
        'stessi', 'stesse', 'medesimo', 'medesima', 'medesimi', 'medesime',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'dice', 'ha detto', 'disse', 'dicendo', 'citato', 'citando', 'secondo', 'affermato',
        'afferma', 'affermando', 'dichiarato', 'dichiara', 'dichiarando', 'scritto', 'scrive',
        'scrivendo', 'menzionato', 'menziona', 'menzionando', 'twittato', 'twitta', 'twittando',
        'riferito', 'riferisce', 'riferendo', 'commentato', 'commenta', 'commentando',
        'notato', 'nota', 'notando', 'espresso', 'esprime', 'esprimendo', 'testimoniato',
        'testimonia', 'testimoniando', 'ammesso', 'ammette', 'ammettendo', 'confessato',
        'confessa', 'confessando', 'rivelato', 'rivela', 'rivelando', 'annunciato', 'annuncia',
        'annunciando', 'spiegato', 'spiega', 'spiegando', 'aggiunto', 'aggiunge', 'aggiungendo',
        'risposto', 'risponde', 'rispondendo', 'narrato', 'narra', 'narrando', 'raccontato',
        'racconta', 'raccontando', 'descritto', 'descrive', 'descrivendo', 'comunicato',
        'comunica', 'comunicando', 'trasmesso', 'trasmette', 'trasmettendo', 'suggerito',
        'suggerisce', 'suggerendo', 'consigliato', 'consiglia', 'consigliando',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'scusa', 'scusi', 'scusate', 'scusami', 'perdono', 'perdonare', 'perdonatemi',
        'mi dispiace', 'ci dispiace', 'spiacente', 'rammarico', 'rammaricarsi', 'dolente',
        'addolorato', 'addolorata', 'purtroppo', 'sfortunatamente', 'tristemente',
        'con rammarico', 'pentito', 'pentita', 'pentimento', 'rimorso', 'colpa',
        'colpevole', 'vergogna', 'vergognoso', 'vergognarsi', 'imbarazzato', 'imbarazzata',
        'imbarazzante', 'sconveniente', 'inappropriato', 'inappropriata', 'inadeguato',
        'inadeguata', 'improprio', 'impropria', 'inopportuno', 'inopportuna', 'fuori luogo',
        'inaccettabile', 'intollerabile', 'imperdonabile', 'ingiustificabile', 'indifendibile',
        'deplorevole', 'riprovevole', 'biasimevole', 'condannabile', 'censurabile',
    ],

    // Common words used for language detection
    'language_markers' => [
        'il', 'lo', 'la', 'i', 'gli', 'le', 'un', 'uno', 'una', 'e', 'o', 'ma', 'se', 'perché',
        'come', 'quando', 'dove', 'chi', 'che', 'quale', 'quali', 'quanto', 'quanta', 'di', 'a',
        'da', 'in', 'con', 'su', 'per', 'tra', 'fra', 'questo', 'questa', 'questi', 'queste',
        'quello', 'quella', 'quelli', 'quelle', 'mio', 'mia', 'miei', 'mie', 'tuo', 'tua',
        'tuoi', 'tue', 'suo', 'sua', 'suoi', 'sue', 'nostro', 'nostra', 'nostri', 'nostre',
        'vostro', 'vostra', 'vostri', 'vostre', 'loro', 'io', 'tu', 'lui', 'lei', 'noi', 'voi',
        'essi', 'esse', 'essere', 'avere', 'fare', 'dire', 'vedere', 'sapere', 'potere',
        'volere', 'dovere', 'andare', 'venire', 'parlare', 'mangiare', 'bere', 'dormire',
        'giocare', 'lavorare', 'studiare', 'leggere', 'scrivere', 'più', 'meno', 'molto',
        'poco', 'troppo', 'tanto', 'così', 'qui', 'qua', 'lì', 'là', 'oggi', 'ieri', 'domani',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anale',            // Come in "fase anale" (psicologia)
        'sesso',            // Sesso biologico, studi di genere
        'sessuale',         // Contesti scientifici
        'sessualità',       // Discussioni accademiche
        'coito',            // Biologia, medicina
        'riproduzione',     // Biologia, scienza
        'pene',             // Anatomia, biologia
        'vagina',           // Anatomia, biologia
        'seno',             // Anatomia, biologia
        'mammella',         // Anatomia, biologia
        'retto',            // Anatomia, biologia
        'testicolo',        // Anatomia, biologia
        'ovaio',            // Anatomia, biologia
        'utero',            // Anatomia, biologia
        'mestruazione',     // Anatomia, biologia
        'eiaculazione',     // Anatomia, biologia
        'erezione',         // Anatomia, biologia
        'orgasmo',          // Anatomia, biologia
        'sperma',           // Anatomia, biologia
        'ovulo',            // Anatomia, biologia
        'zigote',           // Anatomia, biologia
        'embrione',         // Anatomia, biologia
        'feto',             // Anatomia, biologia
        'concepimento',     // Anatomia, biologia
        'fecondazione',     // Anatomia, biologia
        'gestazione',       // Anatomia, biologia
        'gravidanza',       // Anatomia, biologia
        'parto',            // Anatomia, biologia
        'pubertà',          // Anatomia, biologia
        'adolescenza',      // Anatomia, biologia
        'età adulta',       // Anatomia, biologia
        'omosessuale',      // Discussione accademica, non peggiorativo
        'eterosessuale',    // Discussione accademica, non peggiorativo
        'bisessuale',       // Discussione accademica, non peggiorativo
        'transessuale',     // Discussione accademica, non peggiorativo
        'transgender',      // Discussione accademica, non peggiorativo
        'genere',           // Discussione accademica, non peggiorativo
        'identità',         // Discussione accademica, non peggiorativo
        'orientamento',     // Discussione accademica, non peggiorativo
        'preferenza',       // Discussione accademica, non peggiorativo
        'attrazione',       // Discussione accademica, non peggiorativo
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'vite',             // Hardware, costruzione
        'bang',             // Programmazione (operatore !)
        'colpo',            // Grafica, medicina, sport
        'eseguire',         // Programmazione, legale
        'uccidere',         // Programmazione, gestione processi
        'suicidio',         // In discussioni sulla prevenzione, salute mentale
        'master',           // Master/slave in contesti tecnici
        'slave',            // Master/slave in contesti tecnici
        'esecuzione',       // Programmazione, legale
        'abortire',         // Termine di programmazione
        'manichino',        // Test case, placeholder
        'crack',            // Software cracking, geologia
        'proiettile',       // Tipografia, munizioni
        'sparare',          // Fotografia, sport
        'iniezione',        // Medico, programmazione (SQL injection)
        'penetrazione',     // Test di sicurezza
        'forza',            // Fisica, sicurezza (forza bruta)
        'sfruttare',        // Sicurezza, vulnerabilità
        'attacco',          // Sicurezza, rete
        'morto',            // Informatica (link morto, codice morto)
        'morte',            // Informatica (morte di un processo)
        'hardcore',         // Informatica (giochi hardcore)
        'duro',             // Informatica (hardware, disco rigido)
        'morbido',          // Informatica (software)
        'nudo',             // Informatica (dominio nudo)
        'abuso',            // Informatica (rapporti di abuso)
        'violazione',       // Informatica (violazione di policy)
        'colpire',          // Web analytics, baseball
        'svuotare',         // Informatica (svuotare cache), idraulica
        'sporco',           // Informatica (bit sporco, lettura sporca)
        'gancio',           // Programmazione, sport
        'gara',             // Informatica (race condition)
        'scarico',          // Informatica (memory dump)
        'buco',             // Sicurezza (hole), golf
        'dito',             // Comando Unix
        'pipe',             // Programmazione, idraulica
        'socket',           // Programmazione, elettrico
        'demone',           // Processo Unix
        'orfano',           // Informatica (processo orfano)
        'zombie',           // Informatica (processo zombie)
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'culo' => [
            '/\b(dolore|esame|esplorazione|medico) (al|del|nel) culo\b/i',  // Contesto medico
            '/\b(asino|somaro|mulo).*\bculo\b/i',           // Riferimenti ad animali
            '/\b(culo) (del mondo|della camicia|di sacco)\b/i', // Espressioni idiomatiche
            '/\b(calcolo|ricircolo|ridicolo|curricolo|veicolo|articolo|muscolo|carbuncolo)\b/i',  // Parole contenenti "culo"
        ],
        'cazzo' => [
            '/\b(studio|ricerca|linguistica|etimologia|parolaccia).*\bcazzo\b/i',  // Contesto linguistico
            '/\b(sociolinguistica|tabù linguistici|lessico volgare).*\bcazzo\b/i',  // Contesto accademico
            '/\b(un|che|del|il|al) (cazzo)\b/i',  // Esclamazioni comuni
        ],
        'merda' => [
            '/\b(mucca|cavallo|cane|gatto|uccello|animale).*\bmerda\b/i', // Escrementi animali
            '/\b(fertilizzante|concime|escremento|feci|sterco|letame|rifiuto|compost).*\bmerda\b/i', // Contesto agricolo/medico
            '/\b(archeologia|fossile|coprolite).*\bmerda\b/i', // Contesto scientifico
            '/\b(merda) (secca|liquida|solida|dura|molle)\b/i',  // Descrizioni scientifiche
        ],
        'figa' => [
            '/\b(anatomia|ginecologia|medico|medica|vulva|vagina|esame).*\bfiga\b/i',  // Contesto medico
            '/\b(studio|ricerca|linguistica|etimologia|slang|dialetto).*\bfiga\b/i',  // Contesto linguistico
            '/\b(figa) (secca|di legno|molle|fresca)\b/i',  // Espressioni regionali
        ],
        'puttana' => [
            '/\b(storico|antico|biblico|letterario|medievale|rinascimentale).*\bputtana\b/i',  // Contesto storico
            '/\b(maddalena|jezebel|dalila|figura biblica).*\bputtana\b/i',  // Contesto biblico
            '/\b(studio|ricerca|paper|analisi|libro|articolo).*\bprostituzione\b.*\bputtana\b/i',  // Contesto accademico
            '/\b(puttana) (eva|miseria|troia|madonna)\b/i',  // Espressioni idiomatiche
        ],
    ],
];
