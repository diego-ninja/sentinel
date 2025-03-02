<?php

/**
 * French context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    'offensive_words' => [
        'abruti', 'abrutie', 'baise', 'baisé', 'baiser', 'batard', 'bite', 'bougnoul',
        'branleur', 'burne', 'chier', 'cocu', 'con', 'connard', 'connasse', 'conne', 'couille',
        'couillon', 'couillonne', 'crevard', 'cul', 'encule', 'enculé', 'enculee', 'enculée',
        'enculer', 'enfoire', 'enfoiré', 'fion', 'foutre', 'merde', 'negre', 'nègre', 'negresse',
        'négresse', 'nique', 'niquer', 'partouze', 'pd', 'pede', 'pédé', 'petasse', 'pétasse',
        'pine', 'pouffe', 'pouffiasse', 'putain', 'pute', 'salaud', 'salop', 'salopard', 'salope',
        'sodomie', 'sucer', 'tapette', 'tare', 'taré', 'vagin', 'zob',
    ],
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'très', 'vraiment', 'putain', 'absolument', 'totalement', 'complètement',
        'foutrement', 'littéralement', 'sérieusement', 'extrêmement', 'tellement',
        'carrément', 'vachement', 'super', 'grave', 'bien', 'si', 'franchement',
        'méchamment', 'sacrément', 'drôlement', 'diablement', 'incroyablement',
        'horriblement', 'fichtrement', 'bougrement', 'sacrement', 'rudement',
        'bigrement', 'terriblement', 'affreusement', 'atrocement', 'effroyablement',
        'épouvantablement', 'extraordinairement', 'infiniment', 'intensément',
        'monstrueusement', 'particulièrement', 'prodigieusement', 'profondément',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'déteste', 'détester', 'haïr', 'tuer', 'tuant', 'mourir', 'mourant',
        'détruire', 'détruisant', 'stupide', 'idiot', 'idiote', 'crétin', 'crétine',
        'attaquer', 'attaquant', 'blesser', 'blessant', 'laid', 'laide',
        'affreux', 'affreuse', 'terrible', 'horrible', 'pire', 'mauvais', 'mauvaise',
        'dégoûtant', 'dégoûtante', 'répugnant', 'répugnante', 'ennuyeux', 'ennuyeuse',
        'énervé', 'énervée', 'fâché', 'fâchée', 'enfer', 'perdant', 'perdante',
        'désagréable', 'haine', 'haïssable', 'détestable', 'mépris', 'méprisable',
        'colère', 'furieux', 'furieuse', 'rage', 'atroce', 'cruel', 'cruelle',
        'abject', 'abjecte', 'abominable', 'atroce', 'barbare', 'brutal', 'brutale',
        'cauchemardesque', 'dangereux', 'dangereuse', 'démoniaque', 'diabolique',
        'effrayant', 'effrayante', 'épouvantable', 'exécrable', 'féroce', 'funeste',
        'hideux', 'hideuse', 'ignoble', 'immonde', 'infâme', 'infect', 'infecte',
        'infernal', 'infernale', 'insupportable', 'maléfique', 'malsain', 'malsaine',
        'mauvais', 'mauvaise', 'méchant', 'méchante', 'menaçant', 'menaçante',
        'méprisable', 'minable', 'misérable', 'moche', 'monstrueux', 'monstrueuse',
        'mortel', 'mortelle', 'nuisible', 'odieux', 'odieuse', 'pénible',
        'pernicieux', 'pernicieuse', 'pervers', 'perverse', 'répugnant', 'répugnante',
        'repoussant', 'repoussante', 'révoltant', 'révoltante', 'sinistre',
        'sordide', 'terrible', 'vénéneux', 'vénéneuse', 'vicieux', 'vicieuse',
        'violent', 'violente', 'virulent', 'virulente', 'terrifiant', 'terrifiante',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'amour', 'aimer', 'aimant', 'adorer', 'adorant', 'bon', 'bonne', 'génial',
        'incroyable', 'merveilleux', 'merveilleuse', 'excellent', 'excellente',
        'fantastique', 'extraordinaire', 'brillant', 'brillante', 'cool', 'sympa',
        'meilleur', 'meilleure', 'beau', 'belle', 'profiter', 'profitant', 'heureux',
        'heureuse', 'content', 'contente', 'ravi', 'ravie', 'impressionnant',
        'impressionnante', 'parfait', 'parfaite', 'spectaculaire', 'formidable',
        'superbe', 'agréable', 'plaisant', 'plaisante', 'délicieux', 'délicieuse',
        'magnifique', 'splendide', 'sensationnel', 'sensationnelle', 'chouette',
        'admirable', 'adorable', 'agréable', 'attachant', 'attachante', 'attentionné',
        'attentionnée', 'attirant', 'attirante', 'béni', 'bénie', 'bienveillant',
        'bienveillante', 'captivant', 'captivante', 'céleste', 'charmant', 'charmante',
        'chaleureux', 'chaleureuse', 'délicat', 'délicate', 'délicieux', 'délicieuse',
        'divin', 'divine', 'éblouissant', 'éblouissante', 'élégant', 'élégante',
        'enchanteur', 'enchanteresse', 'encourageant', 'encourageante', 'envoûtant',
        'envoûtante', 'époustouflant', 'époustouflante', 'épatant', 'épatante',
        'exaltant', 'exaltante', 'exceptionnel', 'exceptionnelle', 'exquis', 'exquise',
        'fabuleux', 'fabuleuse', 'fascinant', 'fascinante', 'favorable', 'flamboyant',
        'flamboyante', 'florissant', 'florissante', 'glorieux', 'glorieuse',
        'gracieux', 'gracieuse', 'grandiose', 'harmonieux', 'harmonieuse', 'idéal',
        'idéale', 'idyllique', 'impeccable', 'inoubliable', 'joyeux', 'joyeuse',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'recherche', 'étude', 'analyse', 'éducation', 'éducatif', 'éducative', 'académique', 'universitaire',
        'scientifique', 'médical', 'médicale', 'biologique', 'histoire', 'historique', 'littérature',
        'psychologie', 'sociologie', 'anthropologie', 'linguistique', 'papier', 'thèse', 'mémoire',
        'conférence', 'expliquer', 'explication', 'définition', 'définir', 'analyser', 'examiner', 'discuter',
        'cours', 'université', 'collège', 'professeur', 'doctoral', 'doctorat', 'théorie', 'concept',
        'essai', 'article', 'publication', 'chercher', 'expérimenter', 'expérience', 'laboratoire', 'science',
        'séminaire', 'colloque', 'symposium', 'congrès', 'classe', 'école', 'institut', 'enseignement',
        'dissertation', 'rechercher', 'explorer', 'étudier', 'découvrir', 'travail', 'projet', 'formation',
        'académie', 'apprentissage', 'bibliothèque', 'connaissance', 'didactique', 'discipline',
        'enseignant', 'enseignante', 'établissement', 'étudiant', 'étudiante', 'faculté', 'formation',
        'instruction', 'intellectuel', 'intellectuelle', 'leçon', 'lecture', 'lycée', 'manuel',
        'matière', 'méthode', 'méthodologie', 'pédagogie', 'pédagogique', 'programme', 'savoir',
        'scolaire', 'technique', 'terminologie', 'texte', 'traité', 'tuteur', 'tutrice',
        'anatomie', 'biochimie', 'biologie', 'botanique', 'chimie', 'cytologie', 'embryologie',
        'endocrinologie', 'épidémiologie', 'génétique', 'géologie', 'histologie', 'immunologie',
        'microbiologie', 'neurologie', 'pathologie', 'pharmacologie', 'physiologie', 'toxicologie',
        'zoologie', 'archéologie', 'économie', 'ethnologie', 'géographie', 'philosophie', 'politique',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'tu', 'toi', 'vous', 'votre', 'vos', 'ils', 'elles', 'eux', 'leur', 'leurs',
        'il', 'elle', 'son', 'sa', 'ses', 'moi', 'te', 'ton', 'ta', 'tes',
        'nous', 'notre', 'nos', 'ce', 'cette', 'ces', 'ceux', 'celles', 'celui',
        'celui-ci', 'celle-ci', 'ceux-ci', 'celles-ci', 'celui-là', 'celle-là',
        'ceux-là', 'celles-là', 'lequel', 'laquelle', 'lesquels', 'lesquelles',
        'duquel', 'de laquelle', 'desquels', 'desquelles', 'auquel', 'à laquelle',
        'auxquels', 'auxquelles', 'lui', 'me', 'moi-même', 'toi-même', 'lui-même',
        'elle-même', 'nous-mêmes', 'vous-même', 'vous-mêmes', 'eux-mêmes', 'elles-mêmes',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'dit', 'disait', 'cité', 'selon', 'affirmé', 'déclaré', 'écrit', 'mentionné',
        'tweeté', 'exprimé', 'rapporté', 'commenté', 'noté', 'ajouté', 'précisé',
        'indiqué', 'souligné', 'remarqué', 'suggéré', 'proclamé', 'crié', 'explique',
        'raconté', 'prononcé', 'annoncé', 'divulgué', 'révélé', 'attesté', 'témoigné',
        'confessé', 'avoué', 'confirmé', 'relaté', 'reformulé', 'répété', 'exposé',
        'proféré', 'allégué', 'articulé', 'communiqué', 'constaté', 'évoqué', 'partagé',
        'posté', 'publié', 'revendiqué', 'signalé', 'transmis', 'admis', 'certifié',
        'confié', 'diffusé', 'répondu', 'riposté', 'narré', 'récité', 'vocalisé',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'excuse', 'pardon', 'pardonnez', 'désolé', 'désolée', 'excuser', 's\'excuser',
        'regrette', 'navrée', 'navré', 'pardonner', 'excuses', 'pardonnez-moi',
        'je m\'excuse', 'je regrette', 'c\'est regrettable', 'mes excuses', 'navrée',
        'je suis désolé', 'je suis navrée', 'veuillez accepter mes excuses',
        'je vous prie de m\'excuser', 'je demande pardon', 'pardonne-moi',
        'veuillez me pardonner', 'je vous présente mes excuses', 'toutes mes excuses',
        'c\'était inapproprié', 'c\'était déplacé', 'je n\'aurais pas dû',
        'je n\'aurai pas dû dire cela', 'ce n\'était pas mon intention',
        'je ne voulais pas être offensant', 'je ne voulais pas blesser',
    ],

    // Common words used for language detection
    'language_markers' => [
        'le', 'la', 'les', 'un', 'une', 'des', 'et', 'ou', 'de', 'du', 'en', 'avec',
        'par', 'pour', 'que', 'qui', 'ce', 'cette', 'ces', 'mon', 'ton', 'son',
        'notre', 'votre', 'leur', 'mais', 'donc', 'car', 'ni', 'où', 'comment',
        'quand', 'pourquoi', 'est', 'sont', 'était', 'étaient', 'sera', 'seront',
        'être', 'avoir', 'faire', 'dire', 'pouvoir', 'voir', 'vouloir', 'venir',
        'devoir', 'prendre', 'trouver', 'donner', 'aller', 'mettre', 'savoir',
        'falloir', 'attendre', 'demander', 'sembler', 'aimer', 'croire', 'passer',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // Analyse, analytique
        'sexe',             // Biologie, études de genre
        'sexuel',           // Contextes scientifiques
        'sexualité',        // Discussions académiques
        'coït',             // Biologie, médecine
        'reproduction',     // Biologie, science
        'pénis',            // Anatomie, biologie
        'vagin',            // Anatomie, biologie
        'poitrine',         // Anatomie, biologie
        'sein',             // Anatomie, biologie
        'rectum',           // Anatomie, biologie
        'testicule',        // Anatomie, biologie
        'ovaire',           // Anatomie, biologie
        'utérus',           // Anatomie, biologie
        'menstruation',     // Anatomie, biologie
        'éjaculation',      // Anatomie, biologie
        'érection',         // Anatomie, biologie
        'orgasme',          // Anatomie, biologie
        'sperme',           // Anatomie, biologie
        'ovule',            // Anatomie, biologie
        'zygote',           // Anatomie, biologie
        'embryon',          // Anatomie, biologie
        'fœtus',            // Anatomie, biologie
        'conception',       // Anatomie, biologie
        'fécondation',      // Anatomie, biologie
        'gestation',        // Anatomie, biologie
        'grossesse',        // Anatomie, biologie
        'accouchement',     // Anatomie, biologie
        'puberté',          // Anatomie, biologie
        'adolescence',      // Anatomie, biologie
        'âge adulte',       // Anatomie, biologie
        'homosexuel',       // Discussion académique, non péjoratif
        'hétérosexuel',     // Discussion académique, non péjoratif
        'bisexuel',         // Discussion académique, non péjoratif
        'transsexuel',      // Discussion académique, non péjoratif
        'transgenre',       // Discussion académique, non péjoratif
        'genre',            // Discussion académique, non péjoratif
        'identité',         // Discussion académique, non péjoratif
        'orientation',      // Discussion académique, non péjoratif
        'préférence',       // Discussion académique, non péjoratif
        'attraction',       // Discussion académique, non péjoratif
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'vis',              // Matériel, construction
        'bang',             // Programmation (opérateur !)
        'coup',             // Graphiques, médecine, sports
        'exécuter',         // Programmation, légal
        'tuer',             // Programmation, gestion des processus
        'suicide',          // Dans les discussions sur la prévention, santé mentale
        'maître',           // Maître/esclave dans contextes techniques
        'esclave',          // Maître/esclave dans contextes techniques
        'exécution',        // Programmation, légal
        'avorter',          // Terme de programmation
        'mannequin',        // Cas de test, placeholder
        'crack',            // Cracking de logiciel, géologie
        'balle',            // Typographie, munition
        'tirer',            // Photographie, sports
        'injection',        // Médical, programmation (injection SQL)
        'pénétration',      // Tests de sécurité
        'force',            // Physique, sécurité (force brute)
        'exploiter',        // Sécurité, vulnérabilité
        'attaque',          // Sécurité, réseau
        'mort',             // Informatique (lien mort, code mort)
        'décès',            // Informatique (mort d'un processus)
        'hardcore',         // Informatique (jeux hardcore)
        'dur',              // Informatique (matériel, disque dur)
        'mou',              // Informatique (logiciel)
        'nu',               // Informatique (domaine nu)
        'abus',             // Informatique (rapports d'abus)
        'violation',        // Informatique (violation de politiques)
        'coup',             // Analytique web, baseball
        'vider',            // Informatique (vider cache), plomberie
        'sale',             // Informatique (bit sale, lecture sale)
        'crochet',          // Programmation, sports
        'course',           // Informatique (condition de course)
        'décharge',         // Informatique (décharge de mémoire)
        'trou',             // Sécurité (trou), golf
        'doigt',            // Commande Unix
        'pipe',             // Programmation, plomberie
        'socket',           // Programmation, électrique
        'démon',            // Processus Unix
        'orphelin',         // Informatique (processus orphelin)
        'zombie',           // Informatique (processus zombie)
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'cul' => [
            '/\b(douleur|examen|exploration|médecin|médecine) (du|au|dans le) cul\b/i',  // Contexto médico
            '/\b(cul) (de bouteille|de sac|de jatte|de basse-fosse|de lampe)\b/i', // Expresiones idiomáticas francesas
            '/\b(en) (cul) (de poule|d\'âne)\b/i',  // Expresiones culinarias o idiomáticas
            '/\b(calcul|reculer|recul|obstacle|ridicule|curriculum|véhicule|fascicule|funambule|opuscule|corpuscule|crépuscule|minuscule|molécule|particule|matricule)\b/i',  // Palabras con la secuencia "cul"
            '/\b(en avoir plein le|bas du|fond du) cul\b/i',  // Expresiones coloquiales
            '/\bcul(-| )de(-| )(sac|bouteille|jatte|chaudron|lampe|poule)\b/i',  // Expresiones compuestas
        ],
        'bite' => [
            '/\b(poignée de|bout de|petit bout de) bite\b/i',  // Términos náuticos franceses
            '/\b(amarrer|nouer|attacher|fixer) la bite\b/i',   // Terminología náutica
            '/\b(grosse|petite|longue) bite d\'amarrage\b/i',  // Equipamiento marino
            '/\b(morsure|mordre|dent|chien|animal) (qui|de|du) bite\b/i', // Relativo a mordeduras
            '/\borbite\b/i',  // Palabra astronómica/científica
            '/\b(débiter|débit|habitant|habitat|habiter|cohabiter)\b/i',  // Palabras con "bit"
        ],
        'foutre' => [
            '/\b(étude|recherche|linguistique|étymologie|juron|gros mot).*\bfoutre\b/i',  // Contexto lingüístico
            '/\b(sociolinguistique|tabous du langage|vocabulaire interdit).*\bfoutre\b/i',  // Contexto académico
            '/\b(je m\'en|qu\'est-ce que ça|qu\'est-ce que tu|qu\'est-ce que vous|on s\'en) (fout|foutez|fous|foutre|foutait|foutaient|foutent|foutrait|foutraient)\b/i', // Expresiones de indiferencia
            '/\b(foutre) (la paix|le camp|le bordel|la merde|la pagaille|la trouille)\b/i',  // Expresiones idiomáticas
            '/\b(se) (foutre) (de|du|des|de la)\b/i',  // "Burlarse de"
            '/\b(en) (foutre) (plein|partout|par terre)\b/i',  // Expresiones coloquiales
            '/\b(sans|avec) (en) foutre (un|une)\b/i',  // "Sin esforzarse"
        ],
        'putain' => [
            '/\b(historique|ancien|biblique|littéraire|médiéval|renaissance).*\bputain\b/i',  // Contexto histórico
            '/\b(madeleine|jézabel|dalila|figure biblique).*\bputain\b/i',  // Contexto bíblico
            '/\b(étude|recherche|papier|analyse|livre|article).*\bprostitution\b.*\bputain\b/i',  // Contexto académico
            '/\b(oh|ah|eh|hé|ben|mais|bon|alors|oh là là) putain\b/i',  // Muletilla del sur de Francia
            '/\bputain (de|d\'|du|des|de la)\b/i',  // Expresión intensificadora
            '/\b(c\'est|c\'était) (un|du) putain (de|d\')\b/i',  // Intensificador positivo o negativo
            '/\bputain (de merde|de bordel|de con|de temps|de vie)\b/i',  // Expresiones compuestas
        ],
        'con' => [
            '/\b(faire le|être|passer pour un) con\b/i', // Expresiones idiomáticas
            '/\b(le premier|les|des|aux) con(s)?\b/i',  // Expresiones con artículos
            '/\b(contre|concours|concept|concierge|concentrer|concentration|concéder|contemporain|content|contenir|contenu|continuer|contrôle|conversation|convaincre|conviction|conscience|conséquence|conseil|constater|construire|consultant|consommation|convertir)\b/i', // Palabras comenzando con "con"
            '/\b(faucon|balcon|falcon|flocon|bacon|économicon|lexicon|silicone|icône|falcon|flacon|cocon|macon|décon|recon)\b/i', // Palabras terminando en "con"
            '/\b(être|c\'est|quel|petit|gros|sale|sacré|pauvre|ce) con\b/i',  // Insulto cuando va con estos modificadores
        ],
        'merde' => [
            '/\b(étude|recherche|analyse|traité).*\bmerde\b/i',  // Contexto académico
            '/\b(vache|cheval|chien|chat|oiseau|animal).*\bmerde\b/i', // Excremento animal
            '/\b(engrais|fumier|excrément|fèces|selles|déjection|déchet|compost).*\bmerde\b/i', // Contexto agrícola/médico
            '/\b(archéologie|fossile|coprolithe).*\bmerde\b/i', // Contexto científico
            '/\b(dire|foutre|avoir|être dans la) merde\b/i',  // Expresiones idiomáticas
            '/\b(oh|ah|eh|hé|bon|de|la) merde\b/i',  // Interjecciones
            '/\b(c\'est de la|c\'est la|quelle|pas de) merde\b/i',  // Expresiones evaluativas
            '/\bmerd(e|ique|eux|oyer|ier)\b/i',  // Derivados
        ],
        'couilles' => [
            '/\b(testicules|gonades|scrotum|testiculaire|reproduction).*\bcouilles\b/i',  // Contexto médico
            '/\b(avoir|prendre) (les|des|ses) couilles\b/i',  // Expresiones de valentía
            '/\b(casser|briser|péter|rompre) les couilles\b/i',  // Expresiones de molestia
            '/\b(en avoir|se les) couilles\b/i',  // Expresiones idiomáticas
            '/\b(plein|mal aux|se geler les|se gratter les|à s\'en vider les) couilles\b/i',  // Expresiones coloquiales
            '/\b(études|linguistique|étymologie).*\bcouilles\b/i',  // Contexto académico
        ],
        'chatte' => [
            '/\b(chat|félin|animal|domestique|sauvage|siamois|persan).*\bchatte\b/i',  // Referencia a gatas
            '/\b(ma|ta|sa|votre|notre|leur) chatte\b/i',  // Referencia al animal de compañía
            '/\b(belle|jolie|mignonne|petite|grosse|vieille) chatte\b/i',  // Descripción de gatas
            '/\b(nourrir|caresser|adopter|élever) (une|la|ma|sa) chatte\b/i',  // Acciones con animales
            '/\b(anatomie|gynécologie|médecin|médecine|vulve|vagin|examen).*\bchatte\b/i',  // Contexto médico
        ],
        'pute' => [
            '/\b(historique|ancien|médiéval|renaissance|biblique|littéraire).*\bpute\b/i',  // Contexto histórico
            '/\b(madeleine|jézabel|dalila|figure biblique).*\bpute\b/i',  // Contexto bíblico
            '/\b(étude|recherche|article|livre|analyse).*\bprostitution\b.*\bpute\b/i',  // Contexto académico
            '/\b(fils de|comme une|quelle|sale|espèce de) pute\b/i',  // Expresiones ofensivas
            '/\b(pute) (de|du|de la)\b/i',  // Intensificador
        ],
        'salope' => [
            '/\b(étude|recherche|analyse|livre|article|essai).*\bsalope\b/i',  // Contexto académico
            '/\b(vieille|jeune|grande|petite|sale|pauvre) salope\b/i',  // Con adjetivos
            '/\b(traiter|appeler) (de|comme une) salope\b/i',  // Reportar insultos
            '/\b(féminisme|sexisme|misogynie).*\bsalope\b/i',  // Contexto de estudios de género
        ],
        'enculer' => [
            '/\b(étude|recherche|linguistique|étymologie|analyse).*\benculer\b/i',  // Contexto académico
            '/\b(va|allez|viens) (te|vous|t\'|s\'|m\'|nous) (faire) enculer\b/i',  // Expresiones ofensivas
            '/\b(enculer) (les mouches|des mouches)\b/i',  // "Complicar innecesariamente", expresión idiomática
        ],
        'nique' => [
            '/\b(étude|recherche|analyse|linguistique|étymologie).*\bnique\b/i',  // Contexto académico
            '/\b(électronique|technique|botanique|mécanique|clinique|unique|communiquer|dominique|véronique|martinique|chronique|ironique|harmonique|olympique|hispanique)\b/i',  // Palabras que contienen "nique"
            '/\b(nike|nique) (ta|sa|leur) mère\b/i',  // Insulto específico
            '/\b(se) (niquer|nique)\b/i',  // Formas reflexivas
        ],
        'branler' => [
            '/\b(ne rien|rien) branler\b/i',  // "No hacer nada", expresión idiomática
            '/\b(qu\'est-ce que (ça|tu|je|il|elle|on|vous|ils|elles) (en|me|te|se|nous|vous|les)) branle\b/i',  // "Qué importa"
            '/\b(ne pas en|n\'en) branler (une|un)\b/i',  // "No hacer absolutamente nada"
            '/\b(je|tu|il|elle|on|nous|vous|ils|elles) (s\'en|m\'en|t\'en) branle\b/i',  // "Me importa un bledo"
            '/\b(se) branler\b/i',  // Masturbarse
            '/\b(étude|recherche|sexologie|comportement).*\bbranler\b/i',  // Contexto académico
        ],
        'connard' => [
            '/\b(étude|recherche|linguistique|étymologie|analyse).*\bconnard\b/i',  // Contexto académico
            '/\b(être|traiter de|espèce de|sale|pauvre|gros|vieux) connard\b/i',  // Expresiones comunes
            '/\b(quel|ce|un|le|mon|ton|son) connard\b/i',  // Con determinantes
        ],
        'bordel' => [
            '/\b(historique|ancien|historien|médiéval|renaissance).*\bbordel\b/i',  // Contexto histórico
            '/\b(maison close|prostitution|établissement).*\bbordel\b/i',  // Casa de citas, significado original
            '/\b(quel|c\'est le|ce|un|le|du|au|en) bordel\b/i',  // "Desorden", uso común
            '/\b(bordel) (de|de merde|de dieu)\b/i',  // Expresiones de frustración
            '/\b(foutre|mettre|ranger) (le|un|du|son) bordel\b/i',  // "Causar desorden"
        ],
        'cul-cul' => [
            '/\bcul-cul (la praline)?\b/i',  // Expresión para algo cursi o infantil
            '/\b(film|livre|histoire|attitude|comportement|personnage) cul-cul\b/i',  // "Cursi" o "ñoño"
            '/\b(c\'est|être|faire) cul-cul\b/i',  // Expresiones con verbos
        ],
    ],
];
