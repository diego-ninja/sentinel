<?php

/**
 * French context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'très', 'vraiment', 'putain', 'absolument', 'totalement', 'complètement',
        'foutrement', 'littéralement', 'sérieusement', 'extrêmement', 'tellement',
        'carrément', 'vachement', 'super', 'grave', 'bien', 'si', 'franchement',
        'méchamment', 'sacrément', 'drôlement', 'diablement', 'incroyablement',
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
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'tu', 'toi', 'vous', 'votre', 'vos', 'ils', 'elles', 'eux', 'leur', 'leurs',
        'il', 'elle', 'son', 'sa', 'ses', 'moi', 'te', 'ton', 'ta', 'tes',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'dit', 'disait', 'cité', 'selon', 'affirmé', 'déclaré', 'écrit', 'mentionné',
        'tweeté', 'exprimé', 'rapporté', 'commenté', 'noté', 'ajouté', 'précisé',
        'indiqué', 'souligné', 'remarqué', 'suggéré', 'proclamé', 'crié', 'explique',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'excuse', 'pardon', 'pardonnez', 'désolé', 'désolée', 'excuser', 's\'excuser',
        'regrette', 'navrée', 'navré', 'pardonner', 'excuses', 'pardonnez-moi',
    ],

    // Common words used for language detection
    'language_markers' => [
        'le', 'la', 'les', 'un', 'une', 'des', 'et', 'ou', 'de', 'du', 'en', 'avec',
        'par', 'pour', 'que', 'qui', 'ce', 'cette', 'ces', 'mon', 'ton', 'son',
    ],
];