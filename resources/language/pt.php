<?php

/**
 * Definições de contexto em português para detecção de linguagem imprópria
 * Estas definições estabelecem palavras e padrões contextuais que ajudam a analisar
 * a severidade e intenção de conteúdo potencialmente ofensivo.
 */
return [
    'words' => [
        'offensive' => [
            // Palavras vulgares gerais
            'puta', 'puto', 'viado', 'veado', 'bicha', 'foder', 'fodido', 'fodida', 'foda-se',
            'caralho', 'cacete', 'cuzão', 'cu', 'cú', 'buceta', 'boceta', 'xoxota', 'xereca',
            'piroca', 'pica', 'rola', 'pau', 'bosta', 'merda', 'filha da puta', 'filho da puta',
            'fdp', 'vtnc', 'pqp', 'vsf', 'vai tomar no cu', 'porra', 'punheta', 'punheteiro',
            'arrombado', 'arrombada', 'corno', 'cornudo', 'corna', 'safado', 'safada', 'vadia',

            // Variantes regionais (Brasil e Portugal)
            'babaca', 'otário', 'otária', 'trouxa', 'imbecil', 'idiota', 'puto', 'puta', 'sacana',
            'sacaneado', 'sacanagem', 'paneleiro', 'panasca', 'maricas', 'badalhoco', 'badalhoca',
            'cabrão', 'cabrona', 'badalhoco', 'cagão', 'cagona', 'chato', 'chata', 'estúpido', 'estúpida',

            // Insultos raciais/étnicos
            'crioulo', 'macaco', 'preto', 'preta', 'macumbeiro', 'macumbeira', 'cigano', 'cigana',
            'mulato', 'mulata', 'negro', 'negra', 'pretinho', 'pretinha', 'japa', 'amarelo', 'índio', 'índia',

            // Termos sexuais
            'transar', 'trepar', 'fodincha', 'fodinha', 'foda', 'penetrar', 'penetração', 'meter',
            'gozar', 'gozo', 'ejaculação', 'ejacular', 'orgasmo', 'chupada', 'chupar', 'mamada',
            'mamar', 'boquete', 'broche', 'anal', 'bukkake', 'gang bang', 'bunda', 'rabo', 'ânus',
            'puta', 'puteiro', 'putaria', 'putona', 'putinha', 'rapariga', 'meretriz', 'prostituta',

            // Formas eufemísticas e abreviadas
            'f0der', 'f*der', 'p*ta', 'p*to', 'car*lho', 'c*', 'm3rd4', 'fdp', 'vtnc', 'pqp', 'vsf',
            'krl', 'kct', 'pqp', 'pts', 'bct', 'crlh', 'krlh', 'vtnc',

            // Relacionados à violência/crime
            'matar', 'estuprar', 'estupro', 'estuprador', 'assassinar', 'assassino', 'terrorista', 'criminoso',

            // Termos discriminatórios
            'bicha', 'bichona', 'viado', 'veado', 'viadinho', 'boiola', 'traveco', 'sapatão', 'sapatona',
            'lésbica', 'lésbico', 'aidético', 'aidética', 'retardado', 'retardada', 'mongol', 'mongoloide',
            'demente', 'débil mental', 'deficiente', 'aleijado', 'aleijada', 'maneta', 'cegueta', 'mudinho',

            // Variações ortográficas
            'k7', 'kct', 'crl', 'krl', 'bkt', 'bct', 'krlh', 'crlh', 'mrda', 'pik', 'viad', 'bixa',
        ],
        'intensifiers' => [
            'muito', 'demais', 'bastante', 'extremamente', 'tremendamente', 'brutalmente', 'fodidamente',
            'puta', 'caralho', 'porra', 'merda', 'bosta', 'foda', 'super', 'hiper', 'ultra', 'mega',
            'completamente', 'totalmente', 'absolutamente', 'verdadeiramente', 'realmente', 'sinceramente',
            'genuinamente', 'horrivelmente', 'terrivelmente', 'incrivelmente', 'assustadoramente',
            'excessivamente', 'imensamente', 'profundamente', 'gravemente', 'pesadamente', 'intensamente',
            'abundantemente', 'extraordinariamente', 'especialmente', 'particularmente', 'fortemente',
            'do caralho', 'da porra', 'pra caralho', 'para caralho', 'pra porra', 'para porra',
            'bagarai', 'bagaralho', 'pra cacete', 'para cacete', 'pra caramba', 'para caramba',
        ],
        'modifiers' => [
            'negative' => [
                'odiar', 'odeio', 'detesto', 'abomino', 'desprezar', 'desprezo', 'nojo', 'nojento', 'nojenta',
                'ruim', 'péssimo', 'péssima', 'horrível', 'horroroso', 'horrorosa', 'terrível', 'atroz',
                'espantoso', 'espantosa', 'repugnante', 'feio', 'feia', 'merda', 'bosta', 'lixo', 'porcaria',
                'idiota', 'imbecil', 'estúpido', 'estúpida', 'tolo', 'tola', 'bobo', 'boba', 'retardado',
                'retardada', 'burro', 'burra', 'inútil', 'imprestável', 'desprezível', 'repulsivo', 'repulsiva',
                'abominável', 'desgraçado', 'desgraçada', 'desesperador', 'irritante', 'chato', 'chata',
                'insuportável', 'patético', 'patética', 'ridículo', 'ridícula', 'vergonhoso', 'vergonhosa',
                'lamentável', 'triste', 'indignante', 'detestável', 'odioso', 'odiosa', 'maldito', 'maldita',
                'miserável', 'vil', 'depravado', 'depravada', 'pervertido', 'pervertida', 'doente', 'assassino',
                'assassina', 'criminoso', 'criminosa', 'ladrão', 'ladra', 'corrupto', 'corrupta', 'sem-vergonha',
                'cara-de-pau', 'descarado', 'descarada', 'mentiroso', 'mentirosa', 'falso', 'falsa', 'traidor', 'traidora',
            ],
            'positive' => [
                'amar', 'amo', 'adoro', 'quero', 'aprecio', 'respeito', 'admiro', 'bom', 'boa', 'excelente',
                'maravilhoso', 'maravilhosa', 'fantástico', 'fantástica', 'espetacular', 'incrível', 'legal',
                'massa', 'bacana', 'maneiro', 'maneira', 'excelente', 'ótimo', 'ótima', 'magnífico', 'magnífica',
                'esplêndido', 'esplêndida', 'fabuloso', 'fabulosa', 'extraordinário', 'extraordinária',
                'sensacional', 'fenomenal', 'brilhante', 'perfeito', 'perfeita', 'lindo', 'linda', 'formoso',
                'formosa', 'belo', 'bela', 'divino', 'divina', 'encantador', 'encantadora', 'fascinante',
                'cativante', 'valioso', 'valiosa', 'útil', 'prático', 'prática', 'eficiente', 'eficaz',
                'talentoso', 'talentosa', 'criativo', 'criativa', 'inovador', 'inovadora', 'inteligente',
                'sábio', 'sábia', 'brilhante', 'erudito', 'erudita', 'culto', 'culta', 'honesto', 'honesta',
                'sincero', 'sincera', 'honrado', 'honrada', 'respeitável', 'virtuoso', 'virtuosa', 'bondoso',
                'bondosa', 'gentil', 'amável', 'cordial', 'atencioso', 'atenciosa', 'carinhoso', 'carinhosa',
                'afetuoso', 'afetuosa', 'terno', 'terna', 'doce', 'daora', 'show', 'top', 'topíssimo',
            ],
        ],
        'quote' => [
            'disse', 'diz', 'dizendo', 'afirmou', 'afirma', 'afirmando', 'comentou', 'comenta', 'comentando',
            'expressou', 'expressa', 'expressando', 'manifestou', 'manifesta', 'manifestando', 'declarou',
            'declara', 'declarando', 'relatou', 'relata', 'relatando', 'contou', 'conta', 'contando',
            'explicou', 'explica', 'explicando', 'apontou', 'aponta', 'apontando', 'indicou', 'indica',
            'indicando', 'comunicou', 'comunica', 'comunicando', 'escreveu', 'escreve', 'escrevendo',
            'publicou', 'publica', 'publicando', 'compartilhou', 'compartilha', 'compartilhando',
            'postou', 'posta', 'postando', 'tuitou', 'tuíta', 'tuitando', 'mencionou', 'menciona',
            'mencionando', 'garantiu', 'garante', 'garantindo', 'sustentou', 'sustenta', 'sustentando',
            'argumentou', 'argumenta', 'argumentando', 'colocou', 'coloca', 'colocando', 'referiu',
            'refere', 'referindo', 'aludiu', 'alude', 'aludindo', 'esclareceu', 'esclarece', 'esclarecendo',
            'respondeu', 'responde', 'respondendo', 'narrou', 'narra', 'narrando', 'descreveu', 'descreve',
            'descrevendo', 'informou', 'informa', 'informando', 'falou', 'fala', 'falando',
        ],
        'excuse' => [
            'perdão', 'desculpa', 'desculpas', 'sinto muito', 'me arrependo', 'me desculpo', 'peço perdão',
            'lamento', 'lamentável', 'lamentavelmente', 'infelizmente', 'sem intenção', 'sem querer',
            'não era minha intenção', 'não quis', 'não pretendia', 'não foi meu propósito', 'errei',
            'me equivoquei', 'cometi um erro', 'foi um mal-entendido', 'confundi', 'interpretei mal',
            'emendo', 'retifico', 'corrijo', 'retrato', 'retiro o que disse', 'me desdigo', 'volto atrás',
            'pediria desculpas', 'gostaria de me desculpar', 'devo me desculpar', 'tenho que me desculpar',
            'aceito minha culpa', 'assumo a responsabilidade', 'erro', 'falha', 'equívoco', 'gafe', 'mancada',
        ],
    ],
    'pronouns' => [
        'eu', 'me', 'mim', 'comigo', 'meu', 'minha', 'meus', 'minhas',
        'tu', 'te', 'ti', 'contigo', 'teu', 'tua', 'teus', 'tuas', 'você', 'vocês', 'vós',
        'ele', 'o', 'lhe', 'lo', 'la', 'se', 'si', 'consigo', 'seu', 'sua', 'seus', 'suas',
        'ela', 'a', 'lhe', 'la', 'nós', 'nos', 'conosco', 'nosso', 'nossa', 'nossos', 'nossas',
        'vós', 'vos', 'convosco', 'vosso', 'vossa', 'vossos', 'vossas',
        'eles', 'elas', 'os', 'as', 'lhes', 'los', 'las', 'se', 'si', 'consigo', 'seu', 'sua', 'seus', 'suas',
        'quem', 'que', 'qual', 'quais', 'cujo', 'cuja', 'cujos', 'cujas',
        'este', 'esta', 'isto', 'estes', 'estas', 'esse', 'essa', 'isso', 'esses', 'essas',
        'aquele', 'aquela', 'aquilo', 'aqueles', 'aquelas',
    ],
    'prefixes' => [
        'des', 're', 'dis', 'mal', 'pré', 'sobre', 'sub', 'sub', 'super', 'anti', 'auto', 'bi', 'co', 'de', 'en', 'ex',
        'ante', 'in', 'inter', 'meio', 'não', 'extra', 'pós', 'semi', 'tri', 'in', 'sub', 'a', 'com',
    ],
    'suffixes' => [
        'ando', 'endo', 'indo', 'ado', 'ido', 'dor', 'tor', 'sor', 'nte', 'eiro', 'eira', 'ista', 's', 'es', 'es', "'s",
        'es', 'íssimo', 'íssima', 'mente', 'eiro', 'eira', 'ista', 'íssimo', 'íssima',
    ],
    'markers' => [
        'o', 'a', 'os', 'as', 'um', 'uma', 'uns', 'umas', 'de', 'do', 'da', 'dos', 'das', 'em', 'no', 'na', 'nos',
        'nas', 'por', 'pelo', 'pela', 'pelos', 'pelas', 'com', 'sem', 'ao', 'à', 'aos', 'às', 'para', 'pro', 'pra',
        'pros', 'pras', 'entre', 'sobre', 'sob', 'após', 'ante', 'até', 'desde', 'perante', 'durante', 'trás',
        'contra', 'conforme', 'mediante', 'segundo', 'e', 'mas', 'porém', 'todavia', 'contudo', 'entretanto',
        'no entanto', 'ou', 'ora', 'seja', 'quer', 'nem', 'tanto', 'como', 'assim', 'logo', 'pois', 'portanto',
        'por isso', 'porque', 'visto que', 'já que', 'uma vez que', 'dado que', 'se', 'caso', 'desde que',
        'contanto que', 'a menos que', 'a não ser que', 'salvo se', 'exceto se', 'que', 'quem', 'o qual',
        'a qual', 'os quais', 'as quais', 'cujo', 'cuja', 'cujos', 'cujas', 'quanto', 'quando', 'onde', 'como',
        'enquanto', 'conforme', 'sempre que', 'cada vez que', 'antes que', 'depois que', 'até que', 'para que',
        'a fim de que', 'de modo que', 'à medida que', 'tão', 'tanto', 'tal', 'tamanho', 'apesar de', 'mesmo que',
        'ainda que', 'embora', 'conquanto', 'ser', 'estar', 'ter', 'haver', 'fazer', 'ir', 'vir', 'poder', 'dever',
        'querer', 'também', 'muito', 'pouco', 'mais', 'menos', 'melhor', 'pior', 'maior', 'menor', 'tão', 'tanto',
        'tal', 'tamanho', 'tudo', 'nada', 'algo', 'alguém', 'ninguém', 'cada', 'todo', 'toda', 'todos', 'todas',
        'algum', 'alguma', 'alguns', 'algumas', 'nenhum', 'nenhuma', 'nenhuns', 'nenhumas', 'bastante', 'diversos',
        'diversas', 'vários', 'várias', 'outro', 'outra', 'outros', 'outras', 'mesmo', 'mesma', 'mesmos', 'mesmas',
    ],
    'contexts' => [
        'educational' => [
            'markers' => [
                'pesquisa', 'estudo', 'análise', 'educação', 'educativo', 'educacional', 'acadêmico', 'escolar',
                'científico', 'biológico', 'história', 'histórico', 'literatura', 'político', 'psicologia',
                'sociologia', 'antropologia', 'linguística', 'artigo', 'tese', 'dissertação', 'conferência',
                'explicar', 'explicação', 'definição', 'definir', 'analisar', 'examinar', 'discutir', 'curso',
                'universidade', 'faculdade', 'colégio', 'escola', 'instituto', 'professor', 'docente', 'catedrático',
                'doutoral', 'teoria', 'conceito', 'sala de aula', 'ciência', 'experimento', 'laboratório', 'anatomia',
                'fisiologia', 'biologia', 'livro didático', 'manual', 'currículo', 'revista', 'publicação', 'artigo',
                'investigação', 'acadêmico', 'academia', 'seminário', 'congresso', 'simpósio', 'oficina', 'hipótese',
                'metodologia', 'dados', 'evidência', 'achados', 'resultados', 'conclusão', 'resumo', 'introdução',
                'literatura', 'revisão', 'antecedentes', 'método', 'discussão', 'bibliografia', 'referência', 'citação',
                'citar', 'parafrasear', 'resumo', 'argumento', 'monografia', 'tratado', 'crítica', 'avaliação', 'exame',
                'investigação', 'indagação', 'exploração', 'pesquisa', 'entrevista', 'questionário', 'observação', 'caso',
                'estudo', 'trabalho de campo', 'empírico', 'teórico', 'conceitual', 'analítico', 'qualitativo',
                'quantitativo', 'estatístico', 'matemático', 'lógico', 'raciocínio', 'inferência', 'dedução',
                'indução', 'silogismo', 'premissa', 'afirmação', 'garantia', 'apoio', 'refutação',
                'contra-argumento', 'debate', 'discurso', 'dialética', 'retórica', 'persuasão', 'eloquência',
                'articulação', 'vocabulário', 'terminologia', 'léxico', 'glossário', 'definição', 'etimologia',
                'semântica', 'sintaxe', 'gramática', 'ortografia', 'fonologia', 'morfologia', 'filologia',
                'epistemologia', 'ontologia', 'metafísica', 'ética', 'estética', 'filosofia', 'arqueologia',
                'geografia', 'geologia', 'astronomia', 'física', 'química', 'botânica', 'ecologia', 'anatomia',
                'fisiologia', 'neurociência', 'cognitivo', 'comportamental', 'forense', 'civilização', 'cultura',
                'sociedade', 'política', 'governo', 'economia', 'justiça', 'moral', 'religião', 'espiritualidade',
                'teologia', 'arte', 'drama', 'poesia', 'ficção', 'não ficção', 'biografia', 'autobiografia',
                'memória', 'jornalismo', 'mídia', 'comunicação', 'composição', 'linguagem', 'dialeto', 'gíria',
                'coloquialismo', 'idiomatismo', 'provérbio', 'metáfora', 'símile', 'analogia', 'alegoria', 'simbolismo',
                'motivo', 'tema', 'narrativa', 'enredo', 'caracterização', 'diálogo', 'monólogo', 'solilóquio',
                'exposição', 'clímax', 'desfecho', 'conflito', 'protagonista', 'antagonista', 'cenário',
                'atmosfera', 'tom', 'humor', 'propósito', 'audiência', 'contexto', 'gênero', 'subgênero',
                'convenção', 'tradição', 'inovação', 'influência', 'intertextualidade', 'alusão', 'referência',
                'homenagem', 'paródia', 'sátira', 'ironia', 'sarcasmo', 'engenhosidade', 'humor', 'comédia', 'tragédia',
                'tragicomédia', 'romance', 'épico', 'lírica', 'didático', 'medieval', 'renascentista', 'barroco',
                'neoclássico', 'romântico', 'realista', 'naturalista', 'modernista', 'pós-modernista', 'contemporâneo',
                'clínico', 'ciência', 'experimento', 'análise',
            ],
            'whitelist' => [
                'anal', 'sexo', 'sexual', 'sexualidade', 'coito', 'reprodução', 'pênis', 'vagina', 'seio', 'peito',
                'reto', 'testículo', 'ovário', 'útero', 'menstruação', 'ejaculação', 'ereção', 'clímax', 'orgasmo',
                'esperma', 'óvulo', 'zigoto', 'embrião', 'feto', 'concepção', 'fertilização', 'gestação', 'parto',
                'puberdade', 'adolescência', 'adultez', 'homossexual', 'heterossexual', 'bissexual', 'transgênero',
                'gênero', 'identidade', 'orientação', 'preferência', 'atração', 'lésbica', 'acasalamento',
                'cópula', 'libido', 'hormônios', 'testosterona', 'estrogênio', 'progesterona', 'circuncisão',
                'anticoncepcional', 'esterilização', 'infertilidade', 'impotência', 'disfunção', 'DST', 'IST', 'HIV',
                'AIDS', 'camisinha', 'preservativo', 'diafragma', 'pílula', 'DIU', 'abstinência', 'celibato', 'virgindade',
                'monogamia', 'pornografia', 'erótico', 'prostituição', 'adultério', 'fornicação', 'sodomia', 'incesto',
                'pedofilia', 'estupro', 'abuso', 'assédio', 'vítima', 'trauma', 'consentimento', 'ética', 'moral',
            ],
        ],
        'technical' => [
            'markers' => [
                'pesquisa', 'análise', 'científico', 'biológico', 'linguística', 'artigo', 'explicar',
                'explicação', 'definição', 'definir', 'analisar', 'examinar', 'teoria', 'conceito', 'ciência',
                'experimento', 'laboratório', 'biologia', 'publicação', 'artigo', 'investigação', 'conferência',
                'simpósio', 'workshop', 'oficina', 'hipótese', 'metodologia', 'dados', 'evidência', 'achados',
                'resultados', 'conclusão', 'resumo', 'introdução', 'revisão', 'antecedentes', 'método', 'avaliação',
                'exame', 'investigação', 'indagação', 'exploração', 'pesquisa', 'questionário', 'observação',
                'experimento', 'trabalho de campo', 'empírico', 'teórico', 'conceitual', 'analítico', 'qualitativo',
                'quantitativo', 'estatístico', 'matemático', 'lógico', 'raciocínio', 'inferência', 'dedução',
                'indução', 'articulação', 'vocabulário', 'terminologia', 'léxico', 'glossário', 'definição',
                'etimologia', 'semântica', 'sintaxe', 'gramática', 'ortografia', 'fonologia', 'morfologia',
                'epistemologia', 'ontologia', 'física', 'química', 'zoologia', 'botânica', 'ecologia', 'geologia',
                'astronomia', 'cognitivo', 'comportamental', 'forense', 'matemático', 'inovação', 'linguagem',
                'mídia', 'comunicação', 'jargão', 'referência', 'informática', 'computação', 'software', 'hardware',
                'programação', 'código', 'algoritmo', 'interface', 'banco de dados', 'rede', 'servidor', 'cliente',
                'aplicação', 'sistema', 'desenvolvimento', 'engenharia', 'implementação', 'processamento',
                'automação', 'internet', 'web', 'site', 'página', 'navegador', 'protocolo', 'digital', 'analógico',
                'dispositivo', 'máquina', 'equipamento', 'ferramenta', 'tecnologia', 'técnica', 'app', 'aplicativo',
            ],
            'whitelist' => [
                'parafuso', 'bater', 'executar', 'matar', 'suicídio', 'mestre', 'escravo', 'execução', 'abortar', 'boneco', 'quebrar',
                'bala',                // Tipografia, munição
                'atirar',              // Fotografia, esportes
                'injeção',             // Médico, programação (injeção SQL)
                'penetração',          // Testes de segurança
                'força',               // Física, segurança (força bruta)
                'explorar',            // Segurança, vulnerabilidade
                'ataque',              // Segurança, rede
                'morto',               // Informática (link morto, código morto)
                'morte',               // Informática (morte de um processo)
                'hardcore',            // Informática (hardcore gaming)
                'duro',                // Informática (hardware, disco rígido)
                'mole',                // Informática (software)
                'nu',                  // Informática (domínio nu)
                'abuso',               // Informática (relatórios de abuso)
                'violação',            // Informática (violação de política)
                'hit',                 // Análise web, beisebol
                'flush',               // Informática (flush cache), encanamento
                'sujo',                // Informática (bit sujo, leitura suja)
                'gancho',              // Programação, esportes
                'raça',                // Informática (condição de corrida)
                'despejo',             // Informática (despejo de memória)
                'buraco',              // Segurança (buraco), golfe
                'dedo',                // Comando Unix
                'cano',                // Programação, encanamento
                'soquete',             // Programação, elétrico
                'daemon',              // Processo Unix
                'órfão',               // Informática (processo órfão)
                'zumbi',               // Informática (processo zumbi)
                'tira',                // Programação (remover espaços em branco)
                'nu',                  // Informática (domínio nu)
                'exposto',             // API, endpoint
                'ligação',             // Programação
                'montar',              // Sistemas de arquivo
                'desmontar',           // Sistemas de arquivo
                'anônimo',             // Informática (função anônima)
                'membro',              // Programação (membro de classe)
                'cabeça',              // Informática (cabeça de uma lista)
                'cauda',               // Informática (cauda de uma lista)
                'farejar',             // Redes (farejamento de pacotes)
                'nativo',              // Programação (código nativo)
                'deadlock',            // Informática
                'thread',              // Informática
                'órfão',               // Informática (processo órfão)
                'pendurado',           // Informática (processo pendurado)
                'latência',            // Informática
                'estrangular',         // Informática
                'executar',            // Informática
                'vincular',            // Informática
                'desvincular',         // Informática
                'moer',                // Jogos (moer para experiência)
                'patch',               // Software
                'token',               // Segurança
                'cookie',              // Web
                'verme',               // Segurança
                'vírus',               // Segurança
                'trojan',              // Segurança
                'backdoor',            // Segurança
                'inundação',           // Rede
                'quicar',              // Email
                'spam',                // Email
            ],
        ],
        'medical' => [
            'markers' => [
                'pesquisa', 'estudo', 'análise', 'científico', 'médico', 'biológico', 'psicologia',
                'antropologia', 'definição', 'definir', 'analisar', 'examinar', 'teoria', 'conceito',
                'ciência', 'experimento', 'laboratório', 'clínico', 'anatomia', 'fisiologia', 'biologia',
                'revista', 'publicação', 'artigo', 'investigação', 'conferência', 'simpósio', 'workshop',
                'hipótese', 'metodologia', 'dados', 'evidência', 'achados', 'resultados', 'conclusão',
                'resumo', 'introdução', 'revisão', 'antecedentes', 'método', 'avaliação', 'exame',
                'investigação', 'indagação', 'exploração', 'pesquisa', 'entrevista', 'questionário',
                'observação', 'experimento', 'caso', 'estudo', 'trabalho de campo', 'empírico', 'teórico',
                'conceitual', 'analítico', 'qualitativo', 'quantitativo', 'estatístico', 'fisiologia',
                'medicina', 'psiquiatria', 'psicologia', 'neurociência', 'cognitivo', 'comportamental',
                'desenvolvimentista', 'clínico', 'social', 'personalidade', 'anormal', 'fisiológico', 'comparativo',
                'evolutivo', 'forense', 'ética', 'moralidade', 'espiritualidade', 'jargão', 'léxico',
                'glossário', 'definição', 'etimologia', 'ontologia', 'metafísica', 'filosofia', 'física',
                'química', 'zoologia', 'botânica', 'ecologia', 'anatomia', 'sintoma', 'patologia', 'patógeno',
                'doença', 'transtorno', 'síndrome', 'diagnóstico', 'prognóstico', 'tratamento', 'terapia',
                'farmacologia', 'medicamento', 'fármaco', 'cirurgia', 'cirúrgico', 'ortopedia', 'pediatria',
                'geriatria', 'oncologia', 'cardiologia', 'neurologia', 'urologia', 'ginecologia', 'obstétrico',
                'dermatologia', 'endocrinologia', 'imunologia', 'hematologia', 'infeccioso',
            ],
            'whitelist' => [
                'anal', 'sexo', 'sexual', 'sexualidade', 'coito', 'reprodução', 'pênis', 'vagina', 'seio', 'peito',
                'reto', 'testículo', 'ovário', 'útero', 'menstruação', 'ejaculação', 'ereção', 'clímax',
                'orgasmo', 'esperma', 'óvulo', 'zigoto', 'embrião', 'feto', 'concepção', 'fertilização',
                'gestação', 'parto', 'puberdade', 'coito', 'acasalamento', 'procriação', 'libido', 'hormônios',
                'testosterona', 'estrogênio', 'progesterona', 'circuncisão', 'anticoncepcional', 'esterilização',
                'infertilidade', 'impotência', 'disfunção', 'DST', 'IST', 'HIV', 'AIDS', 'camisinha', 'preservativo',
                'diafragma', 'pílula', 'DIU', 'abstinência', 'celibato', 'virgindade', 'trauma', 'ejaculação precoce',
                'disfunção erétil', 'libido', 'frigidez', 'vulva', 'clitóris', 'próstata', 'uretra', 'ânus',
                'nádegas', 'traseiro', 'cólon', 'intestino', 'excremento', 'defecação', 'micção', 'flatulência',
                'fezes', 'urina',
            ],
        ],
        'legal' => [
            'markers' => [
                'pesquisa', 'estudo', 'análise', 'história', 'histórico', 'literatura', 'político',
                'psicologia', 'sociologia', 'artigo', 'explicar', 'explicação', 'definição', 'definir',
                'analisar', 'examinar', 'discutir', 'teoria', 'conceito', 'experimento', 'clínico', 'revista',
                'publicação', 'artigo', 'investigação', 'conferência', 'simpósio', 'workshop', 'metodologia',
                'dados', 'evidência', 'achados', 'resultados', 'conclusão', 'resumo', 'introdução',
                'revisão', 'antecedentes', 'método', 'discussão', 'bibliografia', 'referência', 'citação',
                'citar', 'parafrasear', 'resumo', 'argumento', 'tratado', 'crítica', 'avaliação',
                'exame', 'investigação', 'indagação', 'exploração', 'pesquisa', 'entrevista',
                'questionário', 'observação', 'caso', 'trabalho', 'empírico', 'teórico', 'conceitual',
                'analítico', 'estatístico', 'lógico', 'raciocínio', 'inferência', 'dedução', 'indução',
                'silogismo', 'premissa', 'afirmação', 'garantia', 'apoio', 'refutação', 'contra-argumento',
                'debate', 'discurso', 'dialética', 'retórica', 'persuasão', 'eloquência', 'articulação',
                'vocabulário', 'terminologia', 'léxico', 'glossário', 'definição', 'etimologia', 'semântica',
                'sintaxe', 'gramática', 'ortografia', 'fonologia', 'morfologia', 'filologia', 'epistemologia',
                'ontologia', 'ética', 'filosofia', 'psiquiatria', 'forense', 'civilização', 'cultura',
                'sociedade', 'política', 'governo', 'economia', 'lei', 'justiça', 'direitos', 'religião',
                'teologia', 'jornalismo', 'mídia', 'comunicação', 'contexto', 'dialeto', 'jargão', 'jurídico',
                'legislação', 'código', 'estatuto', 'constituição', 'decreto', 'jurisprudência', 'precedente',
                'tribunal', 'juizado', 'corte', 'sentença', 'decisão', 'resolução', 'causa', 'processo', 'litígio',
                'demanda', 'denúncia', 'queixa', 'acusação', 'defesa', 'alegação', 'testemunha', 'testemunho',
                'prova', 'perito', 'perícia', 'promotor', 'advogado', 'juiz', 'magistrado',
            ],
            'whitelist' => [
                'coito', 'concepção', 'adulto', 'homossexual', 'heterossexual', 'bissexual', 'transgênero', 'gênero',
                'identidade', 'orientação', 'circuncisão', 'castidade', 'poligamia', 'pornografia', 'prostituição',
                'bordel', 'concubina', 'amante', 'adultério', 'fornicação', 'sodomia', 'incesto', 'pedofilia',
                'estupro', 'abuso', 'assédio', 'vítima', 'consentimento', 'ética', 'moral', 'violação', 'abuso',
                'agressão', 'assédio', 'delito', 'crime', 'homicídio', 'assassinato', 'lesões', 'estupro', 'sequestro',
                'violência', 'posse', 'venda', 'tráfico', 'distribuição', 'consumo', 'droga',
                'entorpecente', 'narcotráfico', 'contrabando', 'corrupção', 'suborno', 'extorsão', 'concussão',
                'peculato', 'fraude', 'estelionato', 'furto', 'roubo', 'apropriação', 'usurpação', 'falsificação',
            ],
        ],
    ],
    'patterns' => [
        'word_specific' => [
            'cu' => [
                '/\b(cálculo|articulado|particular|muscular|circular|molecular|vascular|ocular|celular|angular|peculiar|secular)\b/i',  // Palavras terminadas em "cular"
                '/\b(curriculum|currículo|curador|curadoria|curiosidade|curioso|curitiba|cuidado|cuidadoso)\b/i',  // Palavras iniciadas com "cu"
                '/\b(acupuntura|documentação|escutar|desculpa|desculpar|procurar|procura|ocupar|ocupa|recuar|calcular)\b/i',  // Verbos e palavras com "cu"
            ],
            'rola' => [
                '/\b(controlar|controle|patrola|patrulha|patrulhar|enrolar|desenrolar|rolar|rolamento|roleta|carolinas)\b/i',  // Palavras com "rola"
                '/\b(carretel|roleta|rolamento|rolo|rolha|rolimã|roleta russa|rola de papel)\b/i',  // Significados não ofensivos
                '/\b(rolar de rir|rolar no chão|rolar o dado|rolar tela|rolar para baixo)\b/i',  // Expressões inocentes
            ],
            'puta' => [
                '/\b(computação|computador|computacional|computadorizado|imputar|deputado|disputar|reputação)\b/i',  // Palavras com "puta" não ofensivas
                '/\b(disputa|computa|imputa|amputa)\b/i',  // Conjugações verbais
                '/\b(input|output|put)\b/i',  // Termos ingleses
            ],
            'caralho' => [
                '/\b(carvalho|carvalheira|caralhota|ilha do caralho|cabo do caralho)\b/i',  // Lugares e palavras similares
                '/\b(caravela|caramujo|característica|caravana|caracol|caráter|carapaça)\b/i',  // Palavras iniciadas com "cara"
                '/\b(histórico|literário|história|literatura|estudo|acadêmico|ensaio|referência|citação)\b.*\b(caralho)\b/i',  // Contexto acadêmico
            ],
            'viado' => [
                '/\b(histórico|literário|história|literatura|estudo|acadêmico|ensaio|referência|citação|investigação|sociologia|antropologia|psicologia)\b.*\b(viado|veado)\b/i',  // Contexto acadêmico
                '/\b(gay|homossexual|LGBT|LGBTQ|lésbica|bissexual|transgênero|queer|coletivo|comunidade|direitos|diversidade|orientação|identidade)\b.*\b(viado|veado)\b/i',  // Contexto de identidade sexual
                '/\b(animal|mamífero|cervídeo|floresta|savana|selva|mata|caça|caçador|zoologia|biologia|veado mateiro|veado campeiro)\b.*\b(viado|veado)\b/i',  // Referência ao animal
            ],
            'buceta' => [
                '/\b(medicina|anatomia|ginecologia|saúde|corpo humano|órgão|reprodução|sistema reprodutor)\b.*\b(buceta|boceta|xoxota|xereca)\b/i',  // Contexto médico
                '/\b(aula|educação sexual|biologia|anatomia|professor|educação|escola|universidade|faculdade)\b.*\b(buceta|boceta|xoxota|xereca)\b/i',  // Contexto educacional
            ],
            'merda' => [
                '/\b(adubo|excremento|fezes|esterco|fertilizante|guano|composto)\b.*\b(merda|bosta)\b/i',  // Contexto agrícola
                '/\b(medicina|veterinária|biologia|digestão|intestinal|digestivo)\b.*\b(merda|bosta)\b/i',  // Contexto médico
                '/\b(coprolito|fóssil|paleontologia|arqueologia)\b.*\b(merda|bosta)\b/i',  // Contexto científico
            ],
            'corno' => [
                '/\b(chifre|veado|cervo|alce|rena|búfalo|touro|vaca|cabra|bode|rinoceronte|animal)\b.*\b(corno|cornudo)\b/i',  // Referências a animais
                '/\b(zoologia|biologia|veterinária|pecuária|rural|campo|fazenda)\b.*\b(corno|cornudo)\b/i',  // Contexto biológico
            ],
        ],
    ],
    'rules' => [
        Ninja\Sentinel\Language\Rules\AffixRule::class,
    ],
];
