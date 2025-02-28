<?php

/**
 * Spanish context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'muy', 'realmente', 'jodidamente', 'absolutamente', 'totalmente', 'completamente',
        'verdaderamente', 'literal', 'literalmente', 'seriamente', 'maldito', 'maldita',
        'super', 'extremadamente', 'extremo', 'extrema', 'tan', 'bastante', 'bien',
        'demasiado', 'puñeteramente', 'hostilmente', 'increíblemente', 'tremendamente',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'odio', 'odiar', 'odiando', 'matar', 'matando', 'morir', 'muriendo',
        'destruir', 'destruyendo', 'estúpido', 'estúpida', 'idiota', 'tonto', 'tonta',
        'imbécil', 'atacar', 'atacando', 'herir', 'hiriendo', 'feo', 'fea',
        'horrible', 'terrible', 'peor', 'malo', 'mala', 'asqueroso', 'asquerosa',
        'repugnante', 'molesto', 'molesta', 'enfadado', 'enfadada', 'cabrón', 'cabrona',
        'infierno', 'perdedor', 'perdedora', 'fastidiar', 'fastidiando', 'rabia', 'desprecio',
        'detesto', 'detestable', 'asesinar', 'miserable', 'desgraciado', 'desgraciada',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'amor', 'amar', 'amando', 'gustar', 'gustando', 'bueno', 'buena', 'genial',
        'increíble', 'maravilloso', 'maravillosa', 'excelente', 'fantástico', 'fantástica',
        'extraordinario', 'extraordinaria', 'brillante', 'chulo', 'chula', 'mejor',
        'bonito', 'bonita', 'disfrutar', 'disfrutando', 'feliz', 'contento', 'contenta',
        'encantado', 'encantada', 'impresionante', 'perfecto', 'perfecta', 'espectacular',
        'alegre', 'alegría', 'satisfecho', 'satisfecha', 'placer', 'agradable', 'estupendo',
        'estupenda', 'magnífico', 'magnífica', 'fenomenal', 'divino', 'divina',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'investigación', 'estudio', 'análisis', 'educación', 'educativo', 'educativa', 'académico', 'académica',
        'científico', 'científica', 'médico', 'médica', 'biológico', 'biológica', 'historia', 'histórico', 'histórica',
        'literatura', 'psicología', 'sociología', 'antropología', 'lingüística', 'trabajo', 'tesis', 'tesina',
        'conferencia', 'explicar', 'explicación', 'definición', 'definir', 'analizar', 'examinar', 'discutir',
        'curso', 'universidad', 'facultad', 'profesor', 'profesora', 'doctoral', 'doctorado', 'teoría', 'concepto',
        'ensayo', 'artículo', 'publicación', 'investigar', 'experimentar', 'experimento', 'laboratorio', 'ciencia',
        'seminario', 'coloquio', 'simposio', 'congreso', 'clase', 'escuela', 'instituto', 'colegio', 'enseñanza',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'tu', 'tú', 'te', 'ti', 'usted', 'ustedes', 'vosotros', 'vosotras', 'ellos', 'ellas',
        'él', 'ella', 'su', 'sus', 'vuestro', 'vuestra', 'vuestros', 'vuestras', 'os',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'dijo', 'dice', 'citado', 'según', 'afirmó', 'declaró', 'escribió', 'mencionó',
        'tuiteó', 'manifestó', 'expresó', 'comenta', 'comentó', 'informó', 'añadió',
        'señaló', 'sostuvo', 'aseguró', 'insistió', 'proclamó', 'gritó', 'explica',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'disculpe', 'perdón', 'perdonar', 'lo siento', 'disculpar', 'excusa', 'excusar',
        'lamento', 'perdonad', 'perdonadme', 'discúlpame', 'disculpad', 'perdona',
    ],

    // Common words used for language detection
    'language_markers' => [
        'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'y', 'o', 'de', 'del', 'en',
        'con', 'por', 'para', 'que', 'esto', 'esta', 'este', 'estos', 'estas', 'mi', 'tu', 'su',
    ],
];