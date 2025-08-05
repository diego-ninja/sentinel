<?php

/**
 * Definiciones de contexto en español para la detección de lenguaje inapropiado
 * Estas definiciones establecen palabras y patrones contextuales que ayudan a analizar
 * la severidad e intención de contenido potencialmente ofensivo.
 */
return [
    'words' => [
        'offensive' => [
            // Palabras vulgares generales
            'puta', 'puto', 'maricón', 'marica', 'maricon', 'joder', 'jodido', 'jodete', 'jódete',
            'cabrón', 'cabron', 'cabrona', 'chinga', 'chingada', 'chingado', 'chingar', 'chingón',
            'pendejo', 'pendeja', 'gilipollas', 'gilipolla', 'capullo', 'capulla', 'coño',
            'mierda', 'carajo', 'verga', 'polla', 'pingo', 'pija', 'pene', 'cuca', 'chocha', 'concha',
            'rabo', 'pichula', 'picha', 'cojones', 'huevos', 'pinche', 'puta madre', 'hijo de puta',
            'hija de puta', 'hijueputa', 'hdp', 'malparido', 'malparida', 'culero', 'culera',

            // Variantes regionales
            'boludo', 'boluda', 'pelotudo', 'pelotuda', 'pajero', 'pajera', 'conchudo', 'conchuda',
            'carechimba', 'gonorrea', 'huevón', 'huevona', 'huebon', 'huebona', 'culeado', 'weón',
            'weon', 'weona', 'imbécil', 'idiota', 'mamón', 'mamona', 'lameculos', 'gilipollas',

            // Insultos raciales/étnicos
            'sudaca', 'indio', 'negro', 'negrata', 'gitano', 'moro', 'machupichu', 'nazi',
            'polaco', 'gallego', 'gabacho', 'guiri', 'gringo', 'pocho', 'yanqui', 'chino', 'indígena',

            // Términos sexuales
            'follar', 'coger', 'tirar', 'cogida', 'cogido', 'follada', 'follado', 'culear', 'garchar',
            'corrida', 'leche', 'mamada', 'chupada', 'pajear', 'pajote', 'masturbación', 'masturbar',
            'masturbarse', 'semen', 'anal', 'bukkake', 'gang bang', 'culo', 'ojete', 'fundillo', 'orto',
            'ano', 'puta', 'putero', 'putería', 'putón', 'putita', 'putona', 'ramera', 'prostituta',

            // Formas eufemísticas y abreviadas
            'j0der', 'j*der', 'p*ta', 'p*to', 'p*to', 'caraj*', 'm13rd4', 'ptm', 'ctm', 'csm', 'stm',
            'hdlgp', 'mrdp', 'chng', 'vrg', 'pll', 'pj', 'pn', 'cñ', 'jd',

            // Relacionados con violencia/crimen
            'matar', 'violar', 'violación', 'violador', 'asesinar', 'asesino', 'terrorista', 'criminal',

            // Términos discriminatorios
            'marica', 'maricón', 'mariconazo', 'travelo', 'travesti', 'trolo', 'tortillera', 'lesbiana',
            'machorra', 'camionera', 'sidoso', 'sidosa', 'retrasado', 'retrasada', 'mongólico', 'mongólica',
            'subnormal', 'mongolo', 'mongola', 'down', 'deficiente', 'minusválido', 'tarado', 'tarada',
        ],
        'intensifiers' => [
            'muy', 'mucho', 'muchísimo', 'extremadamente', 'tremendamente', 'brutalmente', 'jodidamente',
            'puto', 'puta', 'pinche', 'malditamente', 'sumamente', 'extraordinariamente', 'increíblemente',
            'condenadamente', 'terriblemente', 'absolutamente', 'completamente', 'totalmente', 'verdaderamente',
            'realmente', 'sinceramente', 'genuinamente', 'horriblemente', 'espantosamente', 'súper', 'mega',
            'ultra', 'híper', 'extra', 'demasiado', 'fulminantemente', 'radicalmente', 'intensamente',
            'salvajemente', 'severamente', 'profundamente', 'gravemente', 'exageradamente', 'excesivamente',
            'abundantemente', 'rematadamente', 'requete', 'recontra', 'de la hostia', 'de la ostia',
            'de la leche', 'de cojones', 'que te cagas', 'que te mueres',
        ],
        'modifiers' => [
            'negative' => [
                'odiar', 'odio', 'aborrezco', 'detesto', 'repudio', 'desprecio', 'asco', 'asqueroso', 'asquerosa',
                'malo', 'mala', 'pésimo', 'pésima', 'horrible', 'horroroso', 'horrorosa', 'terrible', 'atroz',
                'espantoso', 'espantosa', 'repugnante', 'feo', 'fea', 'cabrón', 'cabrona', 'basura', 'mierda',
                'idiota', 'imbécil', 'estúpido', 'estúpida', 'tonto', 'tonta', 'bobo', 'boba', 'retrasado',
                'retrasada', 'subnormal', 'inútil', 'inservible', 'despreciable', 'repulsivo', 'repulsiva',
                'abominable', 'desgraciado', 'desgraciada', 'desesperante', 'irritante', 'molesto', 'molesta',
                'insoportable', 'insufrible', 'patético', 'patética', 'ridículo', 'ridícula', 'vergonzoso',
                'vergonzosa', 'lamentable', 'penoso', 'penosa', 'indignante', 'detestable', 'aborrecible',
                'maldito', 'maldita', 'miserable', 'ruin', 'vil', 'depravado', 'depravada', 'pervertido',
                'pervertida', 'enfermo', 'enferma', 'asesino', 'asesina', 'criminal', 'delincuente', 'ladrón',
                'ladrona', 'corrupto', 'corrupta', 'sinvergüenza', 'caradura', 'descarado', 'descarada',
                'mentiroso', 'mentirosa', 'embustero', 'embustera', 'falso', 'falsa', 'traidor', 'traidora',
            ],
            'positive' => [
                'amar', 'amo', 'adoro', 'quiero', 'aprecio', 'respeto', 'admiro', 'bueno', 'buena', 'excelente',
                'maravilloso', 'maravillosa', 'fantástico', 'fantástica', 'espectacular', 'increíble', 'genial',
                'estupendo', 'estupenda', 'magnífico', 'magnífica', 'espléndido', 'espléndida', 'fabuloso',
                'fabulosa', 'extraordinario', 'extraordinaria', 'sensacional', 'fenomenal', 'brillante',
                'perfecto', 'perfecta', 'precioso', 'preciosa', 'hermoso', 'hermosa', 'bello', 'bella',
                'divino', 'divina', 'encantador', 'encantadora', 'fascinante', 'cautivador', 'cautivadora',
                'valioso', 'valiosa', 'útil', 'práctico', 'práctica', 'eficiente', 'efectivo', 'efectiva',
                'talentoso', 'talentosa', 'creativo', 'creativa', 'innovador', 'innovadora', 'inteligente',
                'sabio', 'sabia', 'brillante', 'erudito', 'erudita', 'culto', 'culta', 'honesto', 'honesta',
                'sincero', 'sincera', 'honrado', 'honrada', 'honorable', 'respetable', 'virtuoso', 'virtuosa',
                'bondadoso', 'bondadosa', 'amable', 'cordial', 'atento', 'atenta', 'considerado', 'considerada',
                'cariñoso', 'cariñosa', 'afectuoso', 'afectuosa', 'tierno', 'tierna', 'dulce',
            ],
        ],
        'quote' => [
            'dijo', 'dice', 'diciendo', 'afirmó', 'afirma', 'afirmando', 'comentó', 'comenta', 'comentando',
            'expresó', 'expresa', 'expresando', 'manifestó', 'manifiesta', 'manifestando', 'declaró', 'declara',
            'declarando', 'relató', 'relata', 'relatando', 'contó', 'cuenta', 'contando', 'explicó', 'explica',
            'explicando', 'señaló', 'señala', 'señalando', 'indicó', 'indica', 'indicando', 'comunicó', 'comunica',
            'comunicando', 'escribió', 'escribe', 'escribiendo', 'publicó', 'publica', 'publicando', 'compartió',
            'comparte', 'compartiendo', 'posteó', 'postea', 'posteando', 'tuiteó', 'tuitea', 'tuiteando',
            'mencionó', 'menciona', 'mencionando', 'aseguró', 'asegura', 'asegurando', 'sostuvo', 'sostiene',
            'sosteniendo', 'argumentó', 'argumenta', 'argumentando', 'planteó', 'plantea', 'planteando',
            'refirió', 'refiere', 'refiriendo', 'aludió', 'alude', 'aludiendo', 'aclaró', 'aclara', 'aclarando',
            'respondió', 'responde', 'respondiendo', 'contestó', 'contesta', 'contestando', 'narró', 'narra',
            'narrando', 'describió', 'describe', 'describiendo', 'informó', 'informa', 'informando',
        ],
        'excuse' => [
            'perdón', 'disculpa', 'disculpas', 'lo siento', 'me arrepiento', 'me disculpo', 'pido perdón',
            'ruego perdón', 'lamento', 'lamentable', 'lamentablemente', 'desafortunadamente', 'infortunadamente',
            'sin intención', 'sin querer', 'no era mi intención', 'no quise', 'no pretendía', 'no fue mi propósito',
            'erré', 'me equivoqué', 'cometí un error', 'fue un malentendido', 'confundí', 'malinterpreté',
            'enmiendo', 'rectifico', 'corrijo', 'retracto', 'retiro lo dicho', 'me desdigo', 'doy marcha atrás',
            'pediría disculpas', 'quisiera disculparme', 'debo disculparme', 'tengo que disculparme', 'acepto mi culpa',
            'asumo la responsabilidad', 'desacierto', 'fallo', 'equivocación', 'yerro', 'metedura de pata',
        ],
    ],
    'prefixes' => [
        'des', 're', 'dis', 'mal', 'pre', 'sobre', 'sub', 'super', 'anti', 'auto', 'bi', 'co', 'de', 'en', 'ex',
        'ante', 'in', 'inter', 'medio', 'no', 'extra', 'pos', 'semi', 'tri', 'in', 'sub', 'a', 'con',
    ],
    'suffixes' => [
        'ando', 'endo', 'iendo', 'ado', 'ido', 'dor', 'tor', 'sor', 'nte', 'ero', 'era', 's', 'es', 'ísimo', 'ísima', 'mente', 'ero', 'era', 'ista',
    ],
    'pronouns' => [
        'yo', 'me', 'mi', 'mí', 'conmigo', 'mío', 'mía', 'míos', 'mías',
        'tú', 'te', 'ti', 'contigo', 'tuyo', 'tuya', 'tuyos', 'tuyas', 'usted',
        'él', 'lo', 'le', 'la', 'se', 'sí', 'consigo', 'suyo', 'suya', 'suyos', 'suyas',
        'ella', 'ello', 'nosotros', 'nosotras', 'nos', 'nuestro', 'nuestra', 'nuestros', 'nuestras',
        'vosotros', 'vosotras', 'os', 'vuestro', 'vuestra', 'vuestros', 'vuestras', 'ustedes',
        'ellos', 'ellas', 'los', 'las', 'les', 'se', 'sí', 'consigo', 'suyo', 'suya', 'suyos', 'suyas',
        'quien', 'quienes', 'que', 'cual', 'cuales', 'cuyo', 'cuya', 'cuyos', 'cuyas',
        'este', 'esta', 'esto', 'estos', 'estas', 'ese', 'esa', 'eso', 'esos', 'esas',
        'aquel', 'aquella', 'aquello', 'aquellos', 'aquellas',
    ],
    'markers' => [
        'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'de', 'del', 'a', 'al', 'ante', 'bajo',
        'con', 'contra', 'de', 'desde', 'durante', 'en', 'entre', 'hacia', 'hasta', 'mediante',
        'para', 'por', 'según', 'sin', 'sobre', 'tras', 'y', 'e', 'ni', 'o', 'u', 'bien', 'sea',
        'pero', 'mas', 'sino', 'aunque', 'sin embargo', 'no obstante', 'al contrario', 'en cambio',
        'ahora bien', 'antes bien', 'más bien', 'por el contrario', 'con todo', 'aun así', 'pese a',
        'a pesar de', 'por más que', 'si bien', 'porque', 'pues', 'puesto que', 'ya que', 'dado que',
        'visto que', 'como', 'considerando que', 'debido a que', 'a causa de que', 'por causa de',
        'gracias a que', 'en vista de que', 'es que', 'por cuanto', 'si', 'como si', 'cuando', 'mientras',
        'mientras que', 'apenas', 'en cuanto', 'tan pronto como', 'después de que', 'luego que',
        'antes de que', 'hasta que', 'desde que', 'a medida que', 'según', 'conforme', 'para que',
        'a fin de que', 'con el fin de que', 'con el objeto de que', 'a efectos de que', 'de modo que',
        'de manera que', 'de forma que', 'de suerte que', 'como', 'así como', 'tal como', 'cual',
        'también', 'asimismo', 'igualmente', 'de igual modo', 'del mismo modo', 'de igual manera',
        'de la misma manera', 'de igual forma', 'de la misma forma', 'es decir', 'esto es', 'a saber',
        'o sea', 'en otras palabras', 'dicho de otro modo', 'con otros términos', 'por ejemplo',
        'por caso', 'verbigracia', 'así', 'en consecuencia', 'por consiguiente', 'por tanto',
        'por lo tanto', 'así pues', 'por ende', 'de ahí que', 'en suma', 'en conclusión', 'en definitiva',
        'en fin', 'al fin y al cabo', 'después de todo', 'en resumidas cuentas', 'total', 'en una palabra',
        'en pocas palabras', 'resumiendo', 'recapitulando', 'se', 'lo', 'la', 'le', 'les', 'los', 'las',
    ],
    'contexts' => [
        'educational' => [
            'markers' => [
                'investigación', 'estudio', 'análisis', 'educación', 'educativo', 'académico', 'escolar',
                'científico', 'biológico', 'historia', 'histórico', 'literatura', 'político', 'psicología',
                'sociología', 'antropología', 'lingüística', 'artículo', 'tesis', 'tesina', 'disertación',
                'conferencia', 'explicar', 'explicación', 'definición', 'definir', 'analizar', 'examinar',
                'discutir', 'curso', 'universidad', 'facultad', 'colegio', 'escuela', 'instituto', 'profesor',
                'docente', 'catedrático', 'doctoral', 'teoría', 'concepto', 'aula', 'ciencia', 'experimento',
                'laboratorio', 'anatomía', 'fisiología', 'biología', 'libro de texto', 'manual', 'currículum',
                'revista', 'publicación', 'artículo', 'investigación', 'académico', 'academia', 'seminario',
                'congreso', 'simposio', 'taller', 'hipótesis', 'metodología', 'datos', 'evidencia', 'hallazgos',
                'resultados', 'conclusión', 'resumen', 'introducción', 'literatura', 'revisión', 'antecedentes',
                'método', 'discusión', 'bibliografía', 'referencia', 'cita', 'citar', 'parafrasear', 'resumen',
                'argumento', 'monografía', 'tratado', 'crítica', 'evaluación', 'examen', 'investigación',
                'indagación', 'exploración', 'encuesta', 'entrevista', 'cuestionario', 'observación', 'caso',
                'estudio', 'trabajo de campo', 'empírico', 'teórico', 'conceptual', 'analítico', 'cualitativo',
                'cuantitativo', 'estadístico', 'matemático', 'lógico', 'razonamiento', 'inferencia', 'deducción',
                'inducción', 'silogismo', 'premisa', 'afirmación', 'garantía', 'respaldo', 'refutación',
                'contraargumento', 'debate', 'discurso', 'dialéctica', 'retórica', 'persuasión', 'elocuencia',
                'articulación', 'vocabulario', 'terminología', 'léxico', 'glosario', 'definición', 'etimología',
                'semántica', 'sintaxis', 'gramática', 'ortografía', 'fonología', 'morfología', 'filología',
                'epistemología', 'ontología', 'metafísica', 'ética', 'estética', 'filosofía', 'arqueología',
                'geografía', 'geología', 'astronomía', 'física', 'química', 'botánica', 'ecología', 'anatomía',
                'fisiología', 'neurociencia', 'cognitivo', 'conductual', 'forense', 'civilización', 'cultura',
                'sociedad', 'política', 'gobierno', 'economía', 'justicia', 'moral', 'religión', 'espiritualidad',
                'teología', 'arte', 'drama', 'poesía', 'ficción', 'no ficción', 'biografía', 'autobiografía',
                'memoria', 'periodismo', 'medios', 'comunicación', 'composición', 'lenguaje', 'dialecto', 'jerga',
                'coloquialismo', 'modismo', 'proverbio', 'metáfora', 'símil', 'analogía', 'alegoría', 'simbolismo',
                'motivo', 'tema', 'narrativa', 'trama', 'caracterización', 'diálogo', 'monólogo', 'soliloquio',
                'exposición', 'clímax', 'desenlace', 'conflicto', 'protagonista', 'antagonista', 'escenario',
                'atmósfera', 'tono', 'estado de ánimo', 'propósito', 'audiencia', 'contexto', 'género', 'subgénero',
                'convención', 'tradición', 'innovación', 'influencia', 'intertextualidad', 'alusión', 'referencia',
                'homenaje', 'parodia', 'sátira', 'ironía', 'sarcasmo', 'ingenio', 'humor', 'comedia', 'tragedia',
                'tragicomedia', 'romance', 'épica', 'lírica', 'didáctico', 'medieval', 'renacimiento', 'barroco',
                'neoclásico', 'romántico', 'realista', 'naturalista', 'modernista', 'posmodernista', 'contemporáneo',
                'clínico', 'ciencia', 'experimento', 'análisis',
            ],
            'whitelist' => [
                'anal', 'sexo', 'sexual', 'sexualidad', 'coito', 'reproducción', 'pene', 'vagina', 'seno', 'pecho',
                'recto', 'testículo', 'ovario', 'útero', 'menstruación', 'eyaculación', 'erección', 'clímax', 'orgasmo',
                'esperma', 'óvulo', 'cigoto', 'embrión', 'feto', 'concepción', 'fertilización', 'gestación', 'parto',
                'pubertad', 'adolescencia', 'adultez', 'homosexual', 'heterosexual', 'bisexual', 'transgénero',
                'género', 'identidad', 'orientación', 'preferencia', 'atracción', 'lesbiana', 'gay', 'apareamiento',
                'cópula', 'libido', 'hormonas', 'testosterona', 'estrógeno', 'progesterona', 'circuncisión',
                'anticoncepción', 'esterilización', 'infertilidad', 'impotencia', 'disfunción', 'ETS', 'ITS', 'VIH',
                'SIDA', 'condón', 'diafragma', 'píldora', 'DIU', 'abstinencia', 'celibato', 'virginidad', 'monogamia',
                'pornografía', 'erótico', 'prostitución', 'adulterio', 'fornicación', 'sodomía', 'incesto', 'pedofilia',
                'violación', 'abuso', 'acoso', 'víctima', 'trauma', 'consentimiento', 'ética', 'moral',
            ],
        ],
        'technical' => [
            'markers' => [
                'investigación', 'análisis', 'científico', 'biológico', 'lingüística', 'artículo', 'explicar',
                'explicación', 'definición', 'definir', 'analizar', 'examinar', 'teoría', 'concepto', 'ciencia',
                'experimento', 'laboratorio', 'biología', 'publicación', 'artículo', 'investigación', 'conferencia',
                'simposio', 'taller', 'hipótesis', 'metodología', 'datos', 'evidencia', 'hallazgos', 'resultados',
                'conclusión', 'resumen', 'introducción', 'revisión', 'antecedentes', 'método', 'evaluación',
                'examen', 'investigación', 'indagación', 'exploración', 'encuesta', 'cuestionario', 'observación',
                'experimento', 'trabajo de campo', 'empírico', 'teórico', 'conceptual', 'analítico', 'cualitativo',
                'cuantitativo', 'estadístico', 'matemático', 'lógico', 'razonamiento', 'inferencia', 'deducción',
                'inducción', 'articulación', 'vocabulario', 'terminología', 'léxico', 'glosario', 'definición',
                'etimología', 'semántica', 'sintaxis', 'gramática', 'ortografía', 'fonología', 'morfología',
                'epistemología', 'ontología', 'física', 'química', 'zoología', 'botánica', 'ecología', 'geología',
                'astronomía', 'cognitivo', 'conductual', 'forense', 'matemático', 'innovación', 'lenguaje',
                'medios', 'comunicación', 'jerga', 'referencia',
            ],
            'whitelist' => [
                'tornillo', 'golpear', 'ejecutar', 'matar', 'suicidio', 'maestro', 'esclavo', 'ejecución', 'abortar', 'maniquí', 'crack',
                'bala',                // Tipografía, munición
                'disparar',            // Fotografía, deportes
                'inyección',           // Médico, programación (inyección SQL)
                'penetración',         // Pruebas de seguridad
                'fuerza',              // Física, seguridad (fuerza bruta)
                'explotar',            // Seguridad, vulnerabilidad
                'ataque',              // Seguridad, red
                'muerto',              // Informática (enlace muerto, código muerto)
                'muerte',              // Informática (muerte de un proceso)
                'hardcore',            // Informática (hardcore gaming)
                'duro',                // Informática (hardware, disco duro)
                'blando',              // Informática (software)
                'desnudo',             // Informática (dominio desnudo)
                'abuso',               // Informática (informes de abuso)
                'violación',           // Informática (violación de política)
                'hit',                 // Análisis web, béisbol
                'flush',               // Informática (flush cache), fontanería
                'sucio',               // Informática (bit sucio, lectura sucia)
                'gancho',              // Programación, deportes
                'raza',                // Informática (condición de carrera)
                'volcado',             // Informática (volcado de memoria)
                'agujero',             // Seguridad (agujero), golf
                'dedo',                // Comando Unix
                'tubería',             // Programación, fontanería
                'socket',              // Programación, eléctrico
                'demonio',             // Proceso Unix
                'huérfano',            // Informática (proceso huérfano)
                'zombi',               // Informática (proceso zombi)
                'tira',                // Programación (tira espacios en blanco)
                'desnudo',             // Informática (dominio desnudo)
                'expuesto',            // API, punto final
                'enlace',              // Programación
                'montar',              // Sistemas de archivos
                'desmontar',           // Sistemas de archivos
                'anónimo',             // Informática (función anónima)
                'miembro',             // Programación (miembro de clase)
                'cabeza',              // Informática (cabeza de una lista)
                'cola',                // Informática (cola de una lista)
                'olfatear',            // Redes (olfateo de paquetes)
                'nativo',              // Programación (código nativo)
                'punto muerto',        // Informática
                'hilo',                // Informática
                'huérfano',            // Informática (proceso huérfano)
                'colgado',             // Informática (proceso colgado)
                'latencia',            // Informática
                'estrangular',         // Informática
                'ejecutar',            // Informática
                'vincular',            // Informática
                'desvincular',         // Informática
                'moler',               // Juegos (moler para experiencia)
                'parche',              // Software
                'token',               // Seguridad
                'cookie',              // Web
                'gusano',              // Seguridad
                'virus',               // Seguridad
                'troyano',             // Seguridad
                'puerta trasera',      // Seguridad
                'inundación',          // Red
                'rebote',              // Correo electrónico
                'spam',                // Correo electrónico
            ],
        ],
        'medical' => [
            'markers' => [
                'investigación', 'estudio', 'análisis', 'científico', 'médico', 'biológico', 'psicología',
                'antropología', 'definición', 'definir', 'analizar', 'examinar', 'teoría', 'concepto',
                'ciencia', 'experimento', 'laboratorio', 'clínico', 'anatomía', 'fisiología', 'biología',
                'revista', 'publicación', 'artículo', 'investigación', 'conferencia', 'simposio', 'taller',
                'hipótesis', 'metodología', 'datos', 'evidencia', 'hallazgos', 'resultados', 'conclusión',
                'resumen', 'introducción', 'revisión', 'antecedentes', 'método', 'evaluación', 'examen',
                'investigación', 'indagación', 'exploración', 'encuesta', 'entrevista', 'cuestionario',
                'observación', 'experimento', 'caso', 'estudio', 'trabajo de campo', 'empírico', 'teórico',
                'conceptual', 'analítico', 'cualitativo', 'cuantitativo', 'estadístico', 'fisiología',
                'medicina', 'psiquiatría', 'psicología', 'neurociencia', 'cognitivo', 'conductual',
                'evolutivo', 'clínico', 'social', 'personalidad', 'anormal', 'fisiológico', 'comparativo',
                'evolutivo', 'forense', 'ética', 'moralidad', 'espiritualidad', 'jerga', 'léxico',
                'glosario', 'definición', 'etimología', 'ontología', 'metafísica', 'filosofía', 'física',
                'química', 'zoología', 'botánica', 'ecología', 'anatomía', 'síntoma', 'patología', 'patógeno',
                'enfermedad', 'trastorno', 'síndrome', 'diagnóstico', 'pronóstico', 'tratamiento', 'terapia',
                'farmacología', 'medicamento', 'fármaco', 'cirugía', 'quirúrgico', 'ortopedia', 'pediatría',
                'geriatría', 'oncología', 'cardiología', 'neurología', 'urología', 'ginecología', 'obstétrico',
                'dermato', 'endocrino', 'inmunología', 'hematología', 'infeccioso',
            ],
            'whitelist' => [
                'anal', 'sexo', 'sexual', 'sexualidad', 'coito', 'reproducción', 'pene', 'vagina', 'seno', 'pecho',
                'recto', 'testículo', 'ovario', 'útero', 'menstruación', 'eyaculación', 'erección', 'clímax',
                'orgasmo', 'esperma', 'óvulo', 'cigoto', 'embrión', 'feto', 'concepción', 'fertilización',
                'gestación', 'parto', 'pubertad', 'coito', 'apareamiento', 'procreación', 'libido', 'hormonas',
                'testosterona', 'estrógeno', 'progesterona', 'circuncisión', 'anticoncepción', 'esterilización',
                'infertilidad', 'impotencia', 'disfunción', 'ETS', 'ITS', 'VIH', 'SIDA', 'condón', 'diafragma',
                'píldora', 'DIU', 'abstinencia', 'celibato', 'virginidad', 'trauma', 'eyaculación precoz',
                'disfunción eréctil', 'libido', 'frigidez', 'vulva', 'clítoris', 'próstata', 'uretra', 'ano',
                'nalgas', 'trasero', 'colon', 'intestino', 'excremento', 'defecación', 'micción', 'flatulencia',
                'heces', 'orina',
            ],
        ],
        'legal' => [
            'markers' => [
                'investigación', 'estudio', 'análisis', 'historia', 'histórico', 'literatura', 'político',
                'psicología', 'sociología', 'artículo', 'explicar', 'explicación', 'definición', 'definir',
                'analizar', 'examinar', 'discutir', 'teoría', 'concepto', 'experimento', 'clínico', 'revista',
                'publicación', 'artículo', 'investigación', 'conferencia', 'simposio', 'taller', 'metodología',
                'datos', 'evidencia', 'hallazgos', 'resultados', 'conclusión', 'resumen', 'introducción',
                'revisión', 'antecedentes', 'método', 'discusión', 'bibliografía', 'referencia', 'cita',
                'citar', 'parafrasear', 'resumen', 'argumento', 'tratado', 'crítica', 'evaluación',
                'examen', 'investigación', 'indagación', 'exploración', 'encuesta', 'entrevista',
                'cuestionario', 'observación', 'caso', 'trabajo', 'empírico', 'teórico', 'conceptual',
                'analítico', 'estadístico', 'lógico', 'razonamiento', 'inferencia', 'deducción', 'inducción',
                'silogismo', 'premisa', 'afirmación', 'garantía', 'respaldo', 'refutación', 'contraargumento',
                'debate', 'discurso', 'dialéctica', 'retórica', 'persuasión', 'elocuencia', 'articulación',
                'vocabulario', 'terminología', 'léxico', 'glosario', 'definición', 'etimología', 'semántica',
                'sintaxis', 'gramática', 'ortografía', 'fonología', 'morfología', 'filología', 'epistemología',
                'ontología', 'ética', 'filosofía', 'psiquiatría', 'forense', 'civilización', 'cultura',
                'sociedad', 'política', 'gobierno', 'economía', 'ley', 'justicia', 'derechos', 'religión',
                'teología', 'periodismo', 'medios', 'comunicación', 'contexto', 'dialecto', 'jerga', 'jurídico',
                'legislación', 'código', 'estatuto', 'constitución', 'decreto', 'jurisprudencia', 'precedente',
                'tribunal', 'juzgado', 'corte', 'sentencia', 'fallo', 'resolución', 'causa', 'proceso', 'litigio',
                'demanda', 'denuncia', 'querella', 'acusación', 'defensa', 'alegato', 'testigo', 'testimonio',
                'prueba', 'perito', 'peritaje', 'fiscal', 'abogado', 'juez', 'magistrado',
            ],
            'whitelist' => [
                'coito', 'concepción', 'adultez', 'homosexual', 'heterosexual', 'bisexual', 'transgénero', 'género',
                'identidad', 'orientación', 'circuncisión', 'castidad', 'poligamia', 'pornografía', 'prostitución',
                'prostíbulo', 'concubina', 'amante', 'adulterio', 'fornicación', 'sodomía', 'incesto', 'pedofilia',
                'violación', 'abuso', 'acoso', 'víctima', 'consentimiento', 'ética', 'moral', 'violación', 'abuso',
                'agresión', 'acoso', 'delito', 'crimen', 'homicidio', 'asesinato', 'lesiones', 'estupro', 'secuestro',
                'violencia', 'tenencia', 'posesión', 'venta', 'tráfico', 'distribución', 'consumo', 'droga',
                'estupefaciente', 'narcotráfico', 'contrabando', 'corrupción', 'soborno', 'extorsión', 'cohecho',
                'malversación', 'fraude', 'estafa', 'hurto', 'robo', 'apropiación', 'usurpación', 'falsificación',
            ],
        ],
    ],
    'patterns' => [
        'word_specific' => [
            'culo' => [
                '/\b(cálculo|artículo|espectáculo|vehículo|minúsculo|mayúsculo|ridículo|currículum|currículo|divertículo)\b/i',  // Palabras que contienen "culo"
                '/\b(particular|auricular|perpendicular|secular|molecular|circular|muscular|vascular|ocular|celular|tubular|angular)\b/i',  // Palabras terminadas en "cular"
                '/\b(película|partícula|molécula|retícula|matrícula|cutícula|clavícula|testículo|vesícula|ridículo|furúnculo)\b/i',  // Palabras que contienen "cula" o similares
                '/\b(retroceder|recular|calcular|circular|especular|titular|jacular|articular|muscular|particular|perpendicular|secular|molecular|vascular|ocular|celular|tubular|angular)\b/i',  // Verbos y adjetivos derivados de palabras con "cul"
            ],
            'polla' => [
                '/\b(ampolla|bullir|pollo|polluelo|repollo|pollito|arpollo)\b/i',  // Palabras derivadas o similares a pollo
                '/\b(apollo|programa apollo|misión apollo|nave apollo)\b/i',  // Referencias al programa espacial Apollo
                '/\b(la polla records|concierto de la polla|los de la polla|escuchar la polla)\b/i',  // Referencias al grupo musical "La Polla Records"
                '/\b(lotería|primitiva|bonoloto|once|sorteo|apuesta)\b.*\b(polla)\b/i',  // Referencias a apuestas colectivas
                '/\b(quiniela|juego|apostar|apuesta)\b.*\b(polla)\b/i',  // Contexto de juegos de azar
            ],
            'puto' => [
                '/\b(computo|disputo|imputo|reputo|computadora|disputar|reputación|imputar|diputado|diputación|amputar|amputación)\b/i',  // Palabras que contienen "puto" como parte de su raíz
                '/\b(computación|computacional|computado|computar|imputabilidad|imputado|reputado)\b/i',  // Palabras derivadas con "put" no ofensivas
            ],
            'puta' => [
                '/\b(computar|imputar|disputar|reputar|amputar|diputar)\b/i',  // Verbos con "puta" como parte de su conjugación
                '/\b(disputa|computa|imputa|reputa|amputa)\b/i',  // Conjugaciones verbales
                '/\b(reputación|reputado|reputada|imputación|imputado|imputada|computación|computadora|computarizado|computacional|disputado|disputada)\b/i',  // Palabras derivadas no ofensivas
                '/\b(input|output|put)\b/i',  // Términos de programación en inglés
            ],
            'coño' => [
                '/\b(otoño|retoño|retoñar|moño|añorar|añoranza|año|riñón|cañón|caño|leño|niño|ciñó|tiñó|gruñó|acuñó|españolizar)\b/i',  // Palabras con "ñ" que pueden confundirse
                '/\b(con yo|reconocer|conocer|desconocer)\b/i',  // Combinaciones y palabras que puedan confundirse fonéticamente
                '/\b(reconocimiento|conocimiento|conocido|conocida|desconocido|desconocida)\b/i',  // Derivados no ofensivos
            ],
            'cojones' => [
                '/\b(co-jones|cajones|cojinetes|conjugaciones|conjunciones|cojijo|tejones)\b/i',  // Palabras similares o relacionadas
                '/\b(cojín|cojinete|cojitranco|cojo|cojear)\b/i',  // Palabras con la raíz "coj-" no ofensivas
            ],
            'joder' => [
                '/\b(poder|comer|correr|saber|mover|beber|soler|jodido|ajoder)\b/i',  // Verbos y palabras que pueden confundirse
                '/\b(enjodar|enjodado|enjodada)\b/i',  // Posibles derivados no ofensivos o regionalismos
            ],
            'maricón' => [
                '/\b(historico|literario|historia|literatura|estudio|académico|ensayo|referencia|cita|investigación|sociología|antropología|psicología)\b.*\b(maricón|maricon)\b/i',  // Contexto académico
                '/\b(gay|homosexual|LGBT|LGTB|LGBTQ|lesbiana|bisexual|transgénero|queer|colectivo|comunidad|derechos|diversidad|orientación|identidad)\b.*\b(maricón|maricon)\b/i',  // Contexto de identidad sexual
            ],
            'mierda' => [
                '/\b(abono|excremento|heces|estiércol|fertilizante|guano|compost)\b.*\b(mierda)\b/i',  // Contexto agrícola
                '/\b(medicina|veterinaria|biología|digestión|intestinal|digestivo)\b.*\b(mierda)\b/i',  // Contexto médico
                '/\b(coprolito|fósil|paleontología|arqueología)\b.*\b(mierda)\b/i',  // Contexto científico
            ],
            'cabrón' => [
                '/\b(macho cabrío|cabra|caprino|ganado|rumiante|herbívoro|mamífero)\b.*\b(cabrón)\b/i',  // Referencias a animales
                '/\b(zoología|biología|veterinaria|ganadería|rural|campo|granja)\b.*\b(cabrón)\b/i',  // Contexto biológico
            ],
        ],
    ],
    'rules' => [
        Ninja\Sentinel\Language\Rules\AffixRule::class,
        Ninja\Sentinel\Language\Rules\Es\AdverbRule::class,
        Ninja\Sentinel\Language\Rules\Es\AugmentativeRule::class,
        Ninja\Sentinel\Language\Rules\Es\DiminutiveRule::class,
        Ninja\Sentinel\Language\Rules\Es\GenderVariationRule::class,
        Ninja\Sentinel\Language\Rules\Es\PluralizeRule::class,
        Ninja\Sentinel\Language\Rules\Es\VerbConjugationRule::class,
    ],
];
