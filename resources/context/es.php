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
        'terriblemente', 'malditamente', 'pinche', 'puto', 'puta', 'malditos', 'malditas',
        'putos', 'putas', 'pinches', 'de la hostia', 'de la chingada', 'joder', 'coño',
        'chingado', 'chingada', 'cabrón', 'cabrona', 'cabrones', 'cabronas', 'del carajo',
        'de cojones', 'de pelotas', 'soberano', 'soberana', 'puto', 'puta', 'putamente',
        'sabrosamente', 'tremendamente', 'bien', 'súper', 'increíblemente', 'mortalmente',
        'espectacularmente', 'brutalmente', 'gravemente', 'severamente', 'condenadamente',
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
        'mierda', 'basura', 'porquería', 'apestoso', 'apestosa', 'nauseabundo', 'nauseabunda',
        'pútrido', 'pútrida', 'podrido', 'podrida', 'maloliente', 'jodido', 'jodida',
        'chingado', 'chingada', 'engendro', 'monstruo', 'bestia', 'demonio', 'diablo',
        'satánico', 'satánica', 'infernal', 'inmundo', 'inmunda', 'sucio', 'sucia',
        'graso', 'grasa', 'grasiento', 'grasienta', 'cerdo', 'cerda', 'puerco', 'puerca',
        'marrano', 'marrana', 'guarro', 'guarra', 'cochino', 'cochina', 'zorra', 'zorro',
        'rata', 'ratero', 'ratera', 'ladrón', 'ladrona', 'criminal', 'delincuente',
        'malhechor', 'malhechora', 'maleante', 'bandido', 'bandida', 'corrupto', 'corrupta',
        'traidor', 'traidora', 'traicionero', 'traicionera', 'mentiroso', 'mentirosa',
        'embustero', 'embustera', 'falso', 'falsa', 'hipócrita', 'farsante', 'impostor',
        'impostora', 'malvado', 'malvada', 'cruel', 'despiadado', 'despiadada', 'sádico',
        'sádica', 'maligno', 'maligna', 'perverso', 'perversa', 'retorcido', 'retorcida',
        'víbora', 'serpiente', 'ponzoñoso', 'ponzoñosa', 'venenoso', 'venenosa', 'tóxico',
        'tóxica', 'nocivo', 'nociva', 'perjudicial', 'dañino', 'dañina', 'insufrible',
        'insoportable', 'detestable', 'aborrecible', 'aborrecido', 'aborrecida', 'odiado',
        'odiada', 'execrable', 'despreciable', 'ruin', 'mezquino', 'mezquina', 'tacaño',
        'tacaña', 'avaro', 'avara', 'egoísta', 'egocéntrico', 'egocéntrica', 'presuntuoso',
        'presuntuosa', 'vanidoso', 'vanidosa', 'engreído', 'engreída', 'altanero', 'altanera',
        'arrogante', 'soberbio', 'soberbia', 'prepotente', 'autoritario', 'autoritaria',
        'tirano', 'tirana', 'dictador', 'dictadora', 'fascista', 'nazi', 'racista',
        'xenófobo', 'xenófoba', 'homófobo', 'homófoba', 'transfóbico', 'transfóbica',
        'fanático', 'fanática', 'extremista', 'radical', 'terrorista', 'delincuente',
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
        'hermoso', 'hermosa', 'bello', 'bella', 'precioso', 'preciosa', 'lindo', 'linda',
        'atractivo', 'atractiva', 'guapo', 'guapa', 'mono', 'mona', 'adorable', 'dulce',
        'cariñoso', 'cariñosa', 'tierno', 'tierna', 'amoroso', 'amorosa', 'romántico',
        'romántica', 'apasionado', 'apasionada', 'sensual', 'sensible', 'emocionante',
        'emocionado', 'emocionada', 'entusiasmado', 'entusiasmada', 'excitado', 'excitada',
        'fascinado', 'fascinada', 'maravillado', 'maravillada', 'asombrado', 'asombrada',
        'sorprendido', 'sorprendida', 'pasmado', 'pasmada', 'orgulloso', 'orgullosa',
        'honrado', 'honrada', 'respetado', 'respetada', 'estimado', 'estimada', 'apreciado',
        'apreciada', 'valorado', 'valorada', 'admirado', 'admirada', 'venerado', 'venerada',
        'exaltado', 'exaltada', 'elogiado', 'elogiada', 'alabado', 'alabada', 'ovacionado',
        'ovacionada', 'aclamado', 'aclamada', 'aplaudido', 'aplaudida', 'celebrado', 'celebrada',
        'festejado', 'festejada', 'agasajado', 'agasajada', 'homenajeado', 'homenajeada',
        'galardonado', 'galardonada', 'premiado', 'premiada', 'recompensado', 'recompensada',
        'bendecido', 'bendecida', 'afortunado', 'afortunada', 'dichoso', 'dichosa', 'venturoso',
        'venturosa', 'próspero', 'próspera', 'exitoso', 'exitosa', 'triunfador', 'triunfadora',
        'ganador', 'ganadora', 'victorioso', 'victoriosa', 'campeón', 'campeona', 'líder',
        'pionero', 'pionera', 'innovador', 'innovadora', 'creativo', 'creativa', 'original',
        'auténtico', 'auténtica', 'genuino', 'genuina', 'legítimo', 'legítima', 'verdadero',
        'verdadera', 'sincero', 'sincera', 'honesto', 'honesta', 'íntegro', 'íntegra',
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
        'aprendizaje', 'estudio', 'estudiante', 'alumno', 'alumna', 'maestro', 'maestra', 'docente', 'pedagógico',
        'pedagógica', 'didáctico', 'didáctica', 'currículo', 'curricular', 'asignatura', 'materia', 'disciplina',
        'área', 'campo', 'especialidad', 'especialización', 'conocimiento', 'saber', 'erudición', 'sabiduría',
        'inteligencia', 'intelecto', 'razón', 'lógica', 'pensamiento', 'idea', 'concepto', 'noción', 'concepción',
        'percepción', 'entendimiento', 'comprensión', 'interpretación', 'explicación', 'argumentación', 'argumento',
        'fundamento', 'base', 'principio', 'criterio', 'parámetro', 'paradigma', 'modelo', 'teoría', 'hipótesis',
        'postulado', 'axioma', 'método', 'metodología', 'procedimiento', 'proceso', 'técnica', 'sistema', 'estructura',
        'organización', 'taxonomía', 'clasificación', 'categoría', 'grupo', 'conjunto', 'serie', 'secuencia', 'orden',
        'jerarquía', 'nivel', 'grado', 'etapa', 'fase', 'periodo', 'época', 'era', 'tiempo', 'historia', 'prehistoria',
        'cronología', 'fecha', 'era', 'siglo', 'década', 'año', 'mes', 'día', 'momento', 'instante', 'segundo',
        'biblioteca', 'archivo', 'documento', 'texto', 'libro', 'volumen', 'tomo', 'tratado', 'manual', 'guía',
        'enciclopedia', 'diccionario', 'glosario', 'vocabulario', 'léxico', 'gramática', 'ortografía', 'sintaxis',
        'semántica', 'pragmática', 'fonética', 'fonología', 'morfología', 'etimología', 'filología', 'lingüística',
        'idioma', 'lengua', 'lenguaje', 'dialecto', 'habla', 'acento', 'pronunciación', 'articulación', 'entonación',
        'prosodia', 'acentuación', 'puntuación', 'ortografía', 'escritura', 'redacción', 'composición', 'narración',
        'descripción', 'exposición', 'argumentación', 'diálogo', 'monólogo', 'oratoria', 'retórica', 'estilística',
        'poética', 'métrica', 'verso', 'prosa', 'poema', 'poesía', 'novela', 'cuento', 'relato', 'leyenda', 'mito',
        'fábula', 'ensayo', 'crónica', 'reportaje', 'entrevista', 'noticia', 'artículo', 'editorial', 'columna',
        'reseña', 'crítica', 'comentario', 'análisis', 'interpretación', 'hermenéutica', 'exégesis', 'glosa',
        'anotación', 'observación', 'apunte', 'nota', 'apéndice', 'anexo', 'suplemento', 'complemento', 'adenda',
        'fe de erratas', 'corrección', 'rectificación', 'aclaración', 'precisión', 'matización', 'puntualización',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'tu', 'tú', 'te', 'ti', 'usted', 'ustedes', 'vosotros', 'vosotras', 'ellos', 'ellas',
        'él', 'ella', 'su', 'sus', 'vuestro', 'vuestra', 'vuestros', 'vuestras', 'os',
        'mío', 'mía', 'míos', 'mías', 'tuyo', 'tuya', 'tuyos', 'tuyas', 'suyo', 'suya',
        'suyos', 'suyas', 'nuestro', 'nuestra', 'nuestros', 'nuestras', 'le', 'les', 'lo',
        'la', 'los', 'las', 'me', 'nos', 'se', 'sí', 'consigo', 'conmigo', 'contigo',
        'con él', 'con ella', 'con nosotros', 'con nosotras', 'con vosotros', 'con vosotras',
        'con ellos', 'con ellas', 'a ti', 'a usted', 'a ustedes', 'a vosotros', 'a vosotras',
        'a ellos', 'a ellas', 'a él', 'a ella', 'de ti', 'de usted', 'de ustedes', 'de vosotros',
        'de vosotras', 'de ellos', 'de ellas', 'de él', 'de ella', 'por ti', 'por usted',
        'por ustedes', 'por vosotros', 'por vosotras', 'por ellos', 'por ellas', 'por él',
        'por ella', 'para ti', 'para usted', 'para ustedes', 'para vosotros', 'para vosotras',
        'para ellos', 'para ellas', 'para él', 'para ella',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'dijo', 'dice', 'citado', 'según', 'afirmó', 'declaró', 'escribió', 'mencionó',
        'tuiteó', 'manifestó', 'expresó', 'comenta', 'comentó', 'informó', 'añadió',
        'señaló', 'sostuvo', 'aseguró', 'insistió', 'proclamó', 'gritó', 'explica',
        'narró', 'relató', 'contó', 'describió', 'comunicó', 'transmitió', 'reveló',
        'subrayó', 'recalcó', 'enfatizó', 'destacó', 'apuntó', 'sugirió', 'insinuó',
        'indicó', 'advirtió', 'notificó', 'avisó', 'alegó', 'argumentó', 'razonó',
        'consideró', 'opinó', 'juzgó', 'valoró', 'estimó', 'evaluó', 'concluyó',
        'dedujo', 'infirió', 'supuso', 'postuló', 'teorizó', 'hipotetizó', 'conjeturó',
        'especuló', 'alegó', 'reivindicó', 'proclamó', 'declaró', 'anunció', 'pronunció',
        'vocalizó', 'articuló', 'formuló', 'verbalizó', 'profirió', 'propaló', 'citó',
        'reseñó', 'resumió', 'sintetizó', 'extractó', 'parafraseó', 'refirió', 'relató',
        'rememoró', 'recordó', 'evocó', 'echó en cara', 'reprochó', 'censuró', 'criticó',
        'acusó', 'imputó', 'inculpó', 'culpó', 'responsabilizó', 'achacó', 'atribuyó',
        'imputó', 'recriminó', 'reprendió', 'regañó', 'amonestó', 'reconvino', 'riñó',
        'sermoneó', 'reprobó', 'desaprobó', 'condenó', 'vituperó', 'difamó', 'injurió',
        'calumnió', 'ultrajó', 'insultó', 'ofendió', 'agravió', 'zahirió', 'vejó',
        'maltrató', 'agredió', 'atacó', 'embistió', 'asaltó', 'acometió', 'arremetió',
        'cargó', 'disparo', 'tronó', 'vociferó', 'exclamó', 'clamó', 'proclamó', 'declaró',
        'confesó', 'admitió', 'reconoció', 'concedió', 'aceptó', 'asintió', 'consintió',
        'aprobó', 'permitió', 'autorizó', 'sancionó', 'legitimó', 'validó', 'refrendó',
        'ratificó', 'confirmó', 'corroboró', 'verificó', 'comprobó', 'constató',
        'certificó', 'testificó', 'atestiguó', 'dio fe', 'juró', 'prometió', 'aseguró',
        'garantizó', 'avaló', 'respaldó', 'apoyó', 'secundó', 'reforzó', 'reafirmó',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'disculpe', 'perdón', 'perdonar', 'lo siento', 'disculpar', 'excusa', 'excusar',
        'lamento', 'perdonad', 'perdonadme', 'discúlpame', 'disculpad', 'perdona',
        'perdoname', 'excusadme', 'excúsame', 'excúsenme', 'perdóname', 'perdónenme',
        'disculpen', 'permítanme', 'permíteme', 'si me permiten', 'con permiso',
        'lamentablemente', 'siento mucho', 'lo lamento', 'mis disculpas', 'me arrepiento',
        'arrepentido', 'arrepentida', 'arrepentimiento', 'remordimiento', 'culpa',
        'culpable', 'culpabilidad', 'responsabilidad', 'responsable', 'vergüenza',
        'avergonzado', 'avergonzada', 'pena', 'apenado', 'apenada', 'abochornado',
        'abochornada', 'ruborizado', 'ruborizada', 'mortificado', 'mortificada',
        'incómodo', 'incómoda', 'molesto', 'molesta', 'disgustado', 'disgustada',
        'afligido', 'afligida', 'afectado', 'afectada', 'confundido', 'confundida',
        'equivocado', 'equivocada', 'error', 'errado', 'errada', 'falló', 'fallido',
        'fallida', 'falla', 'fallo', 'defecto', 'desperfecto', 'imperfección',
        'deficiencia', 'carencia', 'falta', 'ausencia', 'descuido', 'negligencia',
        'omisión', 'olvido', 'desliz', 'traspié', 'tropiezo', 'caída', 'accidente',
        'incidente', 'percance', 'contratiempo', 'dificultad', 'problema', 'complicación',
        'inconveniente', 'obstáculo', 'impedimento', 'barrera', 'escollo', 'adversidad',
    ],

    // Common words used for language detection
    'language_markers' => [
        'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'y', 'o', 'de', 'del', 'en',
        'con', 'por', 'para', 'que', 'esto', 'esta', 'este', 'estos', 'estas', 'mi', 'tu', 'su',
        'nuestro', 'vuestro', 'su', 'ser', 'estar', 'haber', 'tener', 'hacer', 'poder', 'decir',
        'ir', 'ver', 'dar', 'saber', 'querer', 'llegar', 'pasar', 'deber', 'poner', 'parecer',
        'quedar', 'creer', 'hablar', 'llevar', 'dejar', 'seguir', 'encontrar', 'llamar', 'venir',
        'pensar', 'salir', 'volver', 'tomar', 'conocer', 'vivir', 'sentir', 'mirar', 'contar',
        'empezar', 'esperar', 'buscar', 'existir', 'entrar', 'trabajar', 'escribir', 'perder',
        'recibir', 'ocurrir', 'entender', 'pedir', 'presentar', 'mantener', 'conseguir', 'realizar',
        'considerar', 'añadir', 'pude', 'estado', 'estaba', 'estabas', 'estábamos', 'estabais',
        'estaban', 'sido', 'fue', 'fuiste', 'fuimos', 'fuisteis', 'fueron', 'soy', 'eres', 'es',
        'somos', 'sois', 'son', 'era', 'eras', 'éramos', 'erais', 'eran', 'seré', 'serás', 'será',
        'seremos', 'seréis', 'serán', 'sería', 'serías', 'seríamos', 'seríais', 'serían', 'seas',
        'sea', 'seamos', 'seáis', 'sean', 'muy', 'mucho', 'mucha', 'muchos', 'muchas', 'poco',
        'poca', 'pocos', 'pocas', 'bastante', 'bastantes', 'demasiado', 'demasiada', 'demasiados',
        'demasiadas', 'todo', 'toda', 'todos', 'todas', 'alguno', 'alguna', 'algunos', 'algunas',
        'ninguno', 'ninguna', 'ningunos', 'ningunas', 'otro', 'otra', 'otros', 'otras', 'mismo',
        'misma', 'mismos', 'mismas', 'tan', 'tanto', 'tanta', 'tantos', 'tantas', 'alguien',
        'nadie', 'algo', 'nada', 'como', 'cuando', 'donde', 'porque', 'pues', 'ya', 'más',
        'menos', 'igual', 'también', 'tampoco', 'siempre', 'nunca', 'jamás', 'ahora', 'después',
        'antes', 'luego', 'aquí', 'allí', 'acá', 'allá', 'arriba', 'abajo', 'cerca', 'lejos',
        'adelante', 'atrás', 'fuera', 'dentro', 'debajo', 'encima', 'mejor', 'peor', 'bien',
        'mal', 'sí', 'no', 'quizá', 'quizás', 'acaso', 'tal', 'cual', 'según', 'sino',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // Psicoanalítico, análisis
        'sexo',             // Biología, estudios de género
        'sexual',           // Contextos científicos
        'sexualidad',       // Discusiones académicas
        'coito',            // Biología, medicina
        'reproducción',     // Biología, ciencia
        'pene',             // Anatomía, biología
        'vagina',           // Anatomía, biología
        'pecho',            // Anatomía, biología
        'teta',             // Anatomía, contexto de lactancia
        'seno',             // Anatomía, biología
        'recto',            // Anatomía, biología
        'testículo',        // Anatomía, biología
        'ovario',           // Anatomía, biología
        'útero',            // Anatomía, biología
        'menstruación',     // Anatomía, biología
        'eyaculación',      // Anatomía, biología
        'erección',         // Anatomía, biología
        'orgasmo',          // Anatomía, biología
        'esperma',          // Anatomía, biología
        'óvulo',            // Anatomía, biología
        'cigoto',           // Anatomía, biología
        'embrión',          // Anatomía, biología
        'feto',             // Anatomía, biología
        'concepción',       // Anatomía, biología
        'fecundación',      // Anatomía, biología
        'gestación',        // Anatomía, biología
        'embarazo',         // Anatomía, biología
        'parto',            // Anatomía, biología
        'pubertad',         // Anatomía, biología
        'adolescencia',     // Anatomía, biología
        'adultez',          // Anatomía, biología
        'homosexual',       // Discusión académica, no peyorativo
        'heterosexual',     // Discusión académica, no peyorativo
        'bisexual',         // Discusión académica, no peyorativo
        'transexual',       // Discusión académica, no peyorativo
        'transgénero',      // Discusión académica, no peyorativo
        'género',           // Discusión académica, no peyorativo
        'identidad',        // Discusión académica, no peyorativo
        'orientación',      // Discusión académica, no peyorativo
        'preferencia',      // Discusión académica, no peyorativo
        'atracción',        // Discusión académica, no peyorativo
        'bollera',          // En discusiones académicas sobre términos reclamados
        'marica',           // Discusiones académicas, estudios de género
        'gay',              // Discusiones académicas, estudios de género
        'lesbiana',         // Discusiones académicas, estudios de género
        'apareamiento',     // Biología, zoología
        'cópula',           // Biología, zoología
        'coito',            // Biología, medicina
        'cría',             // Biología, zoología, agricultura
        'procreación',      // Biología, antropología
        'promiscuidad',     // Psicología, sociología
        'libido',           // Psicología
        'hormonas',         // Biología, medicina
        'testosterona',     // Biología, medicina
        'estrógeno',        // Biología, medicina
        'progesterona',     // Biología, medicina
        'circuncisión',     // Medicina, antropología, estudios religiosos
        'anticoncepción',   // Medicina, salud pública
        'esterilización',   // Medicina, salud pública
        'infertilidad',     // Medicina
        'impotencia',       // Medicina
        'disfunción',       // Medicina
        'ets',              // Medicina, salud pública
        'its',              // Medicina, salud pública
        'vih',              // Medicina, salud pública
        'sida',             // Medicina, salud pública
        'condón',           // Medicina, salud pública
        'preservativo',     // Medicina, salud pública
        'diafragma',        // Medicina, salud pública
        'píldora',          // Medicina, salud pública
        'diu',              // Medicina, salud pública
        'abstinencia',      // Medicina, salud pública, estudios religiosos
        'celibato',         // Medicina, salud pública, estudios religiosos
        'virginidad',       // Medicina, salud pública, estudios religiosos
        'pureza',           // Estudios religiosos
        'castidad',         // Estudios religiosos
        'promiscuidad',     // Psicología, sociología
        'monogamia',        // Psicología, sociología, antropología
        'poligamia',        // Psicología, sociología, antropología
        'poliamor',         // Psicología, sociología
        'pornografía',      // Psicología, sociología, estudios de medios
        'erótica',          // Literatura, estudios de medios
        'prostitución',     // Sociología, criminología
        'burdel',           // Historia, sociología
        'harén',            // Historia, sociología
        'concubina',        // Historia, sociología
        'amante',           // Historia, sociología
        'adulterio',        // Derecho, ética, estudios religiosos
        'fornicación',      // Estudios religiosos
        'sodomía',          // Derecho, historia, estudios religiosos
        'incesto',          // Psicología, sociología, derecho
        'pedofilia',        // Psicología, criminología
        'violación',        // Derecho, criminología
        'abuso',            // Derecho, criminología
        'agresión',         // Derecho, criminología
        'acoso',            // Derecho, sociología
        'víctima',          // Derecho, psicología
        'trauma',           // Psicología
        'consentimiento',   // Derecho, ética
        'ética',            // Filosofía
        'moralidad',        // Filosofía, estudios religiosos
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'tornillo',         // Hardware, construcción
        'bang',             // Programación (operador !)
        'golpe',            // Gráficos, medicina, deportes
        'ejecutar',         // Programación, legal
        'matar',            // Programación, gestión de procesos
        'suicidio',         // En discusiones sobre prevención, salud mental
        'maestro',          // Maestro/esclavo en contextos técnicos
        'esclavo',          // Maestro/esclavo en contextos técnicos
        'ejecución',        // Programación, legal
        'abortar',          // Término de programación
        'maniquí',          // Caso de prueba, marcador de posición
        'crack',            // Crackeo de software, geología
        'bala',             // Tipografía, munición
        'disparar',         // Fotografía, deportes
        'inyección',        // Médico, programación (inyección SQL)
        'penetración',      // Pruebas de seguridad
        'fuerza',           // Física, seguridad (fuerza bruta)
        'explotar',         // Seguridad, vulnerabilidad
        'ataque',           // Seguridad, red
        'muerto',           // Informática (enlace muerto, código muerto)
        'muerte',           // Informática (muerte de un proceso)
        'hardcore',         // Informática (juegos hardcore)
        'duro',             // Informática (hardware, disco duro)
        'blando',           // Informática (software)
        'desnudo',          // Informática (dominio desnudo)
        'abuso',            // Informática (informes de abuso)
        'violación',        // Informática (violación de políticas)
        'golpe',            // Analítica web, béisbol
        'vaciar',           // Informática (vaciar caché), fontanería
        'sucio',            // Informática (bit sucio, lectura sucia)
        'gancho',           // Programación, deportes
        'carrera',          // Informática (condición de carrera)
        'vertedero',        // Informática (volcado de memoria)
        'agujero',          // Seguridad (agujero), golf
        'dedo',             // Comando Unix
        'tubo',             // Programación, fontanería
        'enchufe',          // Programación, eléctrico
        'demonio',          // Proceso Unix
        'huérfano',         // Informática (proceso huérfano)
        'zombi',            // Informática (proceso zombi)
        'desnudar',         // Programación (eliminar espacios en blanco)
        'desnudo',          // Informática (dominio desnudo)
        'expuesto',         // API, punto final
        'enlace',           // Programación
        'montar',           // Sistemas de archivos
        'desmontar',        // Sistemas de archivos
        'anónimo',          // Informática (función anónima)
        'miembro',          // Programación (miembro de clase)
        'cabeza',           // Informática (cabeza de una lista)
        'cola',             // Informática (cola de una lista)
        'olfatear',         // Redes (olfateo de paquetes)
        'nativo',           // Programación (código nativo)
        'bloqueo',          // Informática
        'hilo',             // Informática
        'huérfano',         // Informática (proceso huérfano)
        'colgado',          // Informática (proceso colgado)
        'latencia',         // Informática
        'estrangular',      // Informática
        'ejecutar',         // Informática
        'enlazar',          // Informática
        'desenlazar',       // Informática
        'moler',            // Juegos (moler para la experiencia)
        'parche',           // Software
        'token',            // Seguridad
        'cookie',           // Web
        'gusano',           // Seguridad
        'virus',            // Seguridad
        'troyano',          // Seguridad
        'puerta trasera',   // Seguridad
        'inundación',       // Red
        'rebote',           // Correo electrónico
        'spam',             // Correo electrónico
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'culo' => [
            '/\b(dolor|examen|exploración|médico|medicina) (de|del|en el|al) culo\b/i',  // Contexto médico
            '/\b(burro|asno|mula).*\bculo\b/i',           // Referencia a animales
            '/\b(cálculo|vínculo|músculo|hidrocarburo|curáculo|currículo|vehículo|testículo|espectáculo|vernáculo|cenáculo|habitáculo|tentáculo)\b/i',  // Palabras que terminan en "culo"
            '/\b(ridículo|minúsculo|mayúsculo|opúsculo|corpúsculo|crepúsculo)\b/i',  // Palabras que contienen "culo"
            '/\b(culo) (de botella|vaso|malva|de mundo)\b/i',  // Expresiones idiomáticas
        ],
        'polla' => [
            '/\b(gallina|ave|pájaro|pato|gallo).*\bpolla\b/i',  // Referencia a aves
            '/\b(apuestas|lotería|sorteo|quiniela|primitiva).*\bpolla\b/i',  // Referencia a apuestas o sorteos
            '/\b(polla) (chilena|peruana|boliviana|ecuatoriana|española|goleadora|futbolera)\b/i',  // Referencia a comidas, deportes o costumbres
            '/\b(jugar|echar|hacer) (una polla|la polla)\b/i',  // Contexto de juegos o apuestas
        ],
        'puta' => [
            '/\b(de la puta madre|de puta madre)\b/i',  // Expresión de admiración o satisfacción
            '/\b(histórico|antiguo|bíblico|literario|medieval|renacentista).*\bputa\b/i',  // Contexto histórico
            '/\b(magdalena|jezabel|dalila|figura bíblica).*\bputa\b/i',  // Contexto bíblico
            '/\b(estudio|investigación|papel|análisis|libro|artículo).*\bprostitución\b.*\bputa\b/i',  // Contexto académico
            '/\b(computación|informática|ordenador).*\binput\b/i',  // Contexto informático (confusión con "input")
            '/\b(ni|como|que|la|una|esta) puta (idea|vida|vez|cosa|hora)\b/i',  // Expresiones coloquiales
            '/\bputa (calle|ciudad|guerra|miseria|pobreza|suerte|realidad)\b/i',  // Uso como intensificador
        ],
        'teta' => [
            '/\b(leche|amamantar|lactancia|bebé|materna|lactante|pechos|senos).*\bteta\b/i',  // Contexto de lactancia
            '/\b(anatomía|biología|desarrollo|cambios|pubertad|adolescencia).*\bteta\b/i',  // Contexto biológico/médico
            '/\b(cáncer|tumor|quiste|mamografía|mastectomía|biopsia|cirugía).*\bteta\b/i',  // Contexto médico
            '/\b(teta) (de vaca|de cabra|de oveja|materna|artificial)\b/i',  // Animales y lactancia
            '/\b(dar la|dar|tomando|tomar|beber de la) teta\b/i',  // Expresiones sobre lactancia
        ],
        'cojones' => [
            '/\b(testículos|gónadas|escrotos|testiculares|reproducción).*\bcojones\b/i',  // Contexto médico
            '/\b(tener|echarle).*\bcojones\b/i',  // Expresión de valentía
            '/\b(tocar|romper|hinchar|pelar).*\bcojones\b/i',  // Expresión de molestia
            '/\b(de|tres|par de|dos).*\bcojones\b/i',  // Expresión de intensidad
            '/\b(estudio|lingüística|etimología).*\bcojones\b/i',  // Contexto académico
        ],
        'joder' => [
            '/\b(estudio|investigación|lingüístico|etimología|expletivo|palabrota).*\bjoder\b/i',  // Contexto lingüístico
            '/\b(sociolingüística|tabúes del lenguaje|vocabulario prohibido).*\bjoder\b/i',  // Contexto académico
            '/\b(sin querer|pretender|intentar|tratar de) joder\b/i',  // Expresiones de intención
            '/\b(no|ni|que|qué|sin|para|cómo) (me|te|nos|os|lo|la|los|las|se) (jodas|joda|jodan)\b/i',  // Expresiones comunes
            '/\b(no jodas|no me jodas|no te jodas)\b/i',  // Expresiones de sorpresa o incredulidad
            '/\bjoer\b/i',  // Eufemismo común
        ],
        'mierda' => [
            '/\b(excremento|fecal|heces|estiércol|abono|fertilizante).*\bmierda\b/i',  // Contexto agrícola/médico
            '/\b(toro|vaca|caballo|perro|gato|pájaro|animal).*\bmierda\b/i',  // Excrementos animales
            '/\b(arqueología|fósil|coprolito|análisis).*\bmierda\b/i',  // Contexto científico
            '/\b(pura|vaya|menuda|valga la) mierda\b/i',  // Expresiones de desagrado o desprecio
            '/\b(comer|tragar|estar en la) mierda\b/i',  // Expresiones coloquiales
            '/\bmiércoles\b/i',  // Eufemismo común
        ],
        'coño' => [
            '/\b(anatomía|ginecología|médico|médica|vulva|vagina|examen).*\bcoño\b/i',  // Contexto médico
            '/\b(del coño de la madre|del coño de su madre)\b/i',  // Expresión venezolana/caribeña
            '/\b(¡coño!)\b/i',  // Interjección española/venezolana según contexto
            '/\b(qué|este|ese|el|un|del) coño\b/i',  // Expresiones interrogativas o exclamativas
            '/\b(ir al|venir del|salir del) coño\b/i',  // Expresiones de origen o procedencia
        ],
        'marica' => [
            '/\b(histórico|antiguo|LGBTQ|movimiento|derechos|comunidad|orgullo).*\bmarica\b/i',  // Contexto histórico/de derechos
            '/\b(reclamar|apropiarse|resignificar|reivindicar).*\btérmino.*\bmarica\b/i',  // Contexto de resignificación
            '/\b(marica) (el|la|los|las|del|de la)\b/i',  // Nombre propio o apodo en algunos países
            '/\b(marica) (¿cómo estás?|¿qué tal?|¿qué pasa?|¿qué más?)\b/i',  // Uso amistoso en Colombia y otros países
            '/\b(amigo|pana|parcero|hermano) marica\b/i',  // Uso coloquial no ofensivo en algunos países
        ],
        'pendejo' => [
            '/\b(pubertad|cabello púbico|vello).*\bpendejo\b/i',  // Significado original biológico
            '/\b(inmaduro|joven|adolescente|niño).*\bpendejo\b/i',  // Uso en algunos países
            '/\b(pendejo) (de|del|con|por|para|en)\b/i',  // Uso coloquial según región
            '/\b(hacerse el|no seas|ser un) pendejo\b/i',  // Expresiones comunes
            '/\b(este|ese|aquel|un|mi|tu|su) pendejo\b/i',  // Uso con determinantes
        ],
        'verga' => [
            '/\b(barco|embarcación|vela|marina|náutico|navegación|mástil).*\bverga\b/i',  // Contexto náutico
            '/\b(anatomía|pene|miembro|masculino|reproducción).*\bverga\b/i',  // Contexto médico
            '/\b(de la verga|a toda verga|valer verga|ni verga)\b/i',  // Expresiones regionales
            '/\b(qué|hasta la|tu|su|mi|la) verga\b/i',  // Usos coloquiales
            '/\bbergante\b/i',  // Término náutico relacionado
        ],
        'cabrón' => [
            '/\b(cabra|macho cabrío|cabrito|caprino).*\bcabrón\b/i',  // Referencia al animal
            '/\b(eres|ser|estar) (muy|un) cabrón\b/i',  // Puede ser amistoso en ciertos contextos
            '/\b(estudio|lingüística|antropología).*\bcabrón\b/i',  // Contexto académico
            '/\b(mi|qué|ese|este|el) cabrón\b/i',  // Expresiones con determinantes que pueden ser amistosas
        ],
        'concha' => [
            '/\b(mar|playa|arena|océano|caracola).*\bconcha\b/i',  // Referencia a moluscos
            '/\b(concha) (de mar|marina|nácar|perla|abanico|almeja)\b/i',  // Tipos de conchas marinas
            '/\b(colección|recoger|buscar) conchas\b/i',  // Actividad de recolección
            '/\b(La Concha) (playa|bahía)\b/i',  // Nombre propio de lugares
            '/\b(concha) (acústica|sonora)\b/i',  // Término arquitectónico
        ],
        'hostia' => [
            '/\b(misa|iglesia|eucaristía|sacramento|católico|católica|cristiano|cristiana|religión|religiosa).*\bhostia\b/i',  // Contexto religioso
            '/\b(dar|recibir|meter|pegar) (una|la) hostia\b/i',  // Expresión de golpe
            '/\b(de la hostia|hostia puta|ni hostia)\b/i',  // Expresiones intensificadoras
            '/\b(¡hostia!)\b/i',  // Interjección
            '/\bostia\b/i',  // Variante suavizada
        ],
        'gilipollas' => [
            '/\b(estudio|lingüística|etimología|sociolingüística).*\bgilipollas\b/i',  // Contexto académico
            '/\b(ser|estar|parecer|hacerse el) gilipollas\b/i',  // Expresiones comunes
            '/\b(menudo|vaya|un|el|qué|este|ese) gilipollas\b/i',  // Con determinantes
        ],
        'capullo' => [
            '/\b(flor|planta|botánica|jardín|rosa).*\bcapullo\b/i',  // Contexto botánico
            '/\b(capullo) (de rosa|de flor|floral|cerrado|abierto)\b/i',  // Términos botánicos
            '/\b(abrir|cerrar|brotar|florecer) (el|un|los) capullo\b/i',  // Procesos botánicos
            '/\b(seda|gusano) (de|del) capullo\b/i',  // Referencia a sericicultura
        ],
    ],
];
