<?php

/**
 * Portuguese context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'muito', 'realmente', 'absolutamente', 'totalmente', 'completamente',
        'literal', 'literalmente', 'seriamente', 'extremamente', 'super',
        'demais', 'porra', 'caralho', 'puta', 'tão', 'bastante', 'bem',
        'ridiculamente', 'incrivelmente', 'terrivelmente', 'horrivelmente',
        'severamente', 'tremendamente', 'malditamente', 'profundamente',
        'especialmente', 'particularmente', 'genuinamente', 'intensamente',
        'pesadamente', 'imensamente', 'precisamente', 'puramente', 'simplesmente',
        'fortemente', 'inacreditavelmente', 'vastamente', 'plenamente',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'ódio', 'odiar', 'odiando', 'matar', 'matando', 'morrer', 'morrendo',
        'destruir', 'destruindo', 'estúpido', 'estúpida', 'idiota', 'burro', 'burra',
        'imbecil', 'atacar', 'atacando', 'ferir', 'ferindo', 'feio', 'feia',
        'nojento', 'nojenta', 'horrível', 'terrível', 'pior', 'ruim', 'péssimo', 'péssima',
        'repugnante', 'irritante', 'zangado', 'zangada', 'bravo', 'brava', 'inferno',
        'perdedor', 'perdedora', 'desprezível', 'miserável', 'inútil', 'nojeira',
        'sujo', 'suja', 'imundo', 'imunda', 'doente', 'maluco', 'maluca', 'louco', 'louca',
        'retardado', 'retardada', 'violento', 'violenta', 'brutal', 'sádico', 'sádica',
        'perverso', 'perversa', 'cruel', 'maldoso', 'maldosa', 'vingativo', 'vingativa',
        'malicioso', 'maliciosa', 'venenoso', 'venenosa', 'tóxico', 'tóxica', 'nocivo', 'nociva',
        'destrutivo', 'destrutiva', 'devastador', 'devastadora', 'danoso', 'danosa',
        'abusivo', 'abusiva', 'ofensivo', 'ofensiva', 'grosseiro', 'grosseira',
        'rude', 'hostil', 'ameaçador', 'ameaçadora', 'intimidante', 'agressivo', 'agressiva',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'amor', 'amar', 'amando', 'gostar', 'gostando', 'bom', 'boa', 'ótimo', 'ótima',
        'incrível', 'maravilhoso', 'maravilhosa', 'excelente', 'fantástico', 'fantástica',
        'extraordinário', 'extraordinária', 'brilhante', 'legal', 'melhor',
        'bonito', 'bonita', 'desfrutar', 'desfrutando', 'feliz', 'contente',
        'encantado', 'encantada', 'impressionante', 'perfeito', 'perfeita',
        'espetacular', 'satisfeito', 'satisfeita', 'agradável', 'estupendo', 'estupenda',
        'magnífico', 'magnífica', 'fenomenal', 'divino', 'divina', 'admirável',
        'adorável', 'afável', 'afeiçoado', 'afeiçoada', 'afetuoso', 'afetuosa',
        'agradável', 'alegre', 'amável', 'apaixonado', 'apaixonada', 'aprazível',
        'atraente', 'autêntico', 'autêntica', 'benéfico', 'benéfica', 'benevolente',
        'bondoso', 'bondosa', 'brioso', 'briosa', 'caloroso', 'calorosa', 'carinhoso',
        'carinhosa', 'cativante', 'celestial', 'charmoso', 'charmosa', 'colossal',
        'comovente', 'compassivo', 'compassiva', 'considerado', 'considerada',
        'construtivo', 'construtiva', 'cordial', 'cortês', 'criativo', 'criativa',
        'deslumbrante', 'digno', 'digna', 'dinâmico', 'dinâmica', 'distinto', 'distinta',
        'divertido', 'divertida', 'doce', 'eficaz', 'eficiente', 'elevado', 'elevada',
        'eloquente', 'eminente', 'empolgante', 'encantador', 'encantadora',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'pesquisa', 'estudo', 'análise', 'educação', 'educativo', 'educativa', 'acadêmico', 'acadêmica',
        'científico', 'científica', 'médico', 'médica', 'biológico', 'biológica', 'história', 'histórico', 'histórica',
        'literatura', 'psicologia', 'sociologia', 'antropologia', 'linguística', 'trabalho', 'tese', 'dissertação',
        'conferência', 'explicar', 'explicação', 'definição', 'definir', 'analisar', 'examinar', 'discutir',
        'curso', 'universidade', 'faculdade', 'professor', 'professora', 'doutoral', 'doutorado', 'teoria', 'conceito',
        'ensaio', 'artigo', 'publicação', 'pesquisar', 'experimentar', 'experimento', 'laboratório', 'ciência',
        'seminário', 'colóquio', 'simpósio', 'congresso', 'classe', 'escola', 'instituto', 'ensino',
        'aprendizagem', 'estudo', 'estudante', 'aluno', 'aluna', 'mestre', 'mestra', 'docente', 'pedagógico',
        'pedagógica', 'didático', 'didática', 'currículo', 'curricular', 'disciplina', 'matéria',
        'área', 'campo', 'especialidade', 'especialização', 'conhecimento', 'saber', 'erudição', 'sabedoria',
        'inteligência', 'intelecto', 'razão', 'lógica', 'pensamento', 'ideia', 'conceito', 'noção', 'concepção',
        'percepção', 'entendimento', 'compreensão', 'interpretação', 'explicação', 'argumentação', 'argumento',
        'fundamento', 'base', 'princípio', 'critério', 'parâmetro', 'paradigma', 'modelo', 'teoria', 'hipótese',
        'postulado', 'axioma', 'método', 'metodologia', 'procedimento', 'processo', 'técnica', 'sistema', 'estrutura',
        'biblioteca', 'arquivo', 'documento', 'texto', 'livro', 'volume', 'tomo', 'tratado', 'manual', 'guia',
        'enciclopédia', 'dicionário', 'glossário', 'vocabulário', 'léxico', 'gramática', 'ortografia', 'sintaxe',
        'semântica', 'pragmática', 'fonética', 'fonologia', 'morfologia', 'etimologia', 'filologia', 'linguística',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'você', 'tu', 'te', 'ti', 'vocês', 'eles', 'elas', 'ele', 'ela', 'sua', 'seu', 'suas', 'seus',
        'dele', 'dela', 'deles', 'delas', 'nós', 'nos', 'nosso', 'nossa', 'nossos', 'nossas',
        'me', 'mim', 'meu', 'minha', 'meus', 'minhas', 'o', 'a', 'os', 'as', 'lhe', 'lhes',
        'si', 'consigo', 'comigo', 'contigo', 'conosco', 'convosco', 'este', 'esta', 'isto',
        'esse', 'essa', 'isso', 'aquele', 'aquela', 'aquilo', 'estes', 'estas', 'esses',
        'essas', 'aqueles', 'aquelas', 'quem', 'qual', 'quais', 'cujo', 'cuja', 'cujos', 'cujas',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'disse', 'diz', 'dizendo', 'citou', 'cita', 'citando', 'segundo', 'afirmou', 'afirma',
        'afirmando', 'declarou', 'declara', 'declarando', 'escreveu', 'escreve', 'escrevendo',
        'mencionou', 'menciona', 'mencionando', 'tuitou', 'tuita', 'tuitando', 'relatou', 'relata',
        'relatando', 'comentou', 'comenta', 'comentando', 'notou', 'nota', 'notando', 'expressou',
        'expressa', 'expressando', 'testemunhou', 'testemunha', 'testemunhando', 'admitiu', 'admite',
        'admitindo', 'confessou', 'confessa', 'confessando', 'declarou', 'declara', 'declarando',
        'anunciou', 'anuncia', 'anunciando', 'explicou', 'explica', 'explicando', 'adicionou',
        'adiciona', 'adicionando', 'respondeu', 'responde', 'respondendo', 'narrou', 'narra',
        'narrando', 'descreveu', 'descreve', 'descrevendo', 'comunicou', 'comunica', 'comunicando',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'desculpa', 'desculpe', 'perdão', 'perdoe', 'perdoar', 'lamento', 'lamentar', 'sinto',
        'sentir', 'arrependido', 'arrependida', 'arrepender', 'infelizmente', 'infeliz',
        'pesar', 'remorso', 'culpa', 'culpado', 'culpada', 'vergonha', 'envergonhado',
        'envergonhada', 'embaraçado', 'embaraçada', 'embaraçoso', 'embaraçosa', 'constrangido',
        'constrangida', 'constrangedor', 'constrangedora', 'incômodo', 'incômoda',
        'inapropriado', 'inapropriada', 'inadequado', 'inadequada', 'indecente',
        'impróprio', 'imprópria', 'imperdoável', 'injustificável', 'lastimável',
        'deplorável', 'inaceitável', 'inconveniente', 'incompreensível', 'indescritível',
        'indizível', 'irreal', 'inexplicável', 'impensável', 'inimaginável', 'incrível',
    ],

    // Common words used for language detection
    'language_markers' => [
        'o', 'a', 'os', 'as', 'um', 'uma', 'uns', 'umas', 'e', 'ou', 'de', 'do', 'da', 'dos', 'das',
        'em', 'no', 'na', 'nos', 'nas', 'por', 'para', 'com', 'sem', 'sobre', 'sob', 'entre',
        'até', 'desde', 'contra', 'perante', 'trás', 'após', 'durante', 'mediante', 'segundo',
        'conforme', 'quando', 'enquanto', 'como', 'que', 'quem', 'onde', 'cujo', 'cuja',
        'qual', 'quais', 'porque', 'pois', 'já', 'ainda', 'sempre', 'nunca', 'jamais',
        'talvez', 'sim', 'não', 'também', 'mas', 'porém', 'todavia', 'contudo', 'entretanto',
        'eu', 'tu', 'ele', 'ela', 'nós', 'vós', 'eles', 'elas', 'meu', 'minha', 'teu', 'tua',
        'seu', 'sua', 'nosso', 'nossa', 'vosso', 'vossa', 'este', 'esta', 'esse', 'essa',
        'aquele', 'aquela', 'isto', 'isso', 'aquilo', 'ser', 'estar', 'ter', 'haver', 'fazer',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // Como em "retenção anal" (psicologia)
        'sexo',             // Sexo biológico, estudos de gênero
        'sexual',           // Contextos científicos
        'sexualidade',      // Discussões acadêmicas
        'coito',            // Biologia, medicina
        'reprodução',       // Biologia, ciência
        'pênis',            // Anatomia, biologia
        'vagina',           // Anatomia, biologia
        'seio',             // Anatomia, biologia
        'mama',             // Anatomia, biologia
        'reto',             // Anatomia, biologia
        'testículo',        // Anatomia, biologia
        'ovário',           // Anatomia, biologia
        'útero',            // Anatomia, biologia
        'menstruação',      // Anatomia, biologia
        'ejaculação',       // Anatomia, biologia
        'ereção',           // Anatomia, biologia
        'orgasmo',          // Anatomia, biologia
        'esperma',          // Anatomia, biologia
        'óvulo',            // Anatomia, biologia
        'zigoto',           // Anatomia, biologia
        'embrião',          // Anatomia, biologia
        'feto',             // Anatomia, biologia
        'concepção',        // Anatomia, biologia
        'fecundação',       // Anatomia, biologia
        'gestação',         // Anatomia, biologia
        'gravidez',         // Anatomia, biologia
        'parto',            // Anatomia, biologia
        'puberdade',        // Anatomia, biologia
        'adolescência',     // Anatomia, biologia
        'adultez',          // Anatomia, biologia
        'homossexual',      // Discussão acadêmica, não pejorativo
        'heterossexual',    // Discussão acadêmica, não pejorativo
        'bissexual',        // Discussão acadêmica, não pejorativo
        'transexual',       // Discussão acadêmica, não pejorativo
        'transgênero',      // Discussão acadêmica, não pejorativo
        'gênero',           // Discussão acadêmica, não pejorativo
        'identidade',       // Discussão acadêmica, não pejorativo
        'orientação',       // Discussão acadêmica, não pejorativo
        'preferência',      // Discussão acadêmica, não pejorativo
        'atração',          // Discussão acadêmica, não pejorativo
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'parafuso',         // Hardware, construção
        'bang',             // Programação (operador !)
        'golpe',            // Gráficos, medicina, esportes
        'executar',         // Programação, legal
        'matar',            // Programação, gerenciamento de processos
        'suicídio',         // Em discussões sobre prevenção, saúde mental
        'mestre',           // Mestre/escravo em contextos técnicos
        'escravo',          // Mestre/escravo em contextos técnicos
        'execução',         // Programação, legal
        'abortar',          // Termo de programação
        'manequim',         // Caso de teste, marcador de posição
        'crack',            // Quebra de software, geologia
        'bala',             // Tipografia, munição
        'disparar',         // Fotografia, esportes
        'injeção',          // Médico, programação (injeção SQL)
        'penetração',       // Testes de segurança
        'força',            // Física, segurança (força bruta)
        'explorar',         // Segurança, vulnerabilidade
        'ataque',           // Segurança, rede
        'morto',            // Informática (link morto, código morto)
        'morte',            // Informática (morte de um processo)
        'hardcore',         // Informática (jogos hardcore)
        'duro',             // Informática (hardware, disco rígido)
        'mole',             // Informática (software)
        'nu',               // Informática (domínio nu)
        'abuso',            // Informática (relatórios de abuso)
        'violação',         // Informática (violação de políticas)
        'hit',              // Analítica da web, beisebol
        'flush',            // Informática (limpar cache), encanamento
        'sujo',             // Informática (bit sujo, leitura suja)
        'gancho',           // Programação, esportes
        'corrida',          // Informática (condição de corrida)
        'despejo',          // Informática (despejo de memória)
        'buraco',           // Segurança (buraco), golfe
        'dedo',             // Comando Unix
        'tubo',             // Programação, encanamento
        'soquete',          // Programação, elétrico
        'demônio',          // Processo Unix
        'órfão',            // Informática (processo órfão)
        'zumbi',            // Informática (processo zumbi)
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'cu' => [
            '/\b(dor|exame|exploração|médico|medicina) (de|do|no) cu\b/i',  // Contexto médico
            '/\b(cu) (da garrafa|do frasco|de saco|do mundo|do judas)\b/i', // Expresiones idiomáticas portuguesas
            '/\b(cálculo|recuo|obstáculo|ridículo|currículo|veículo|matrícula|molécula|músculo|particular|cubículo|cutícula|cutâneo|culinária|cultivar|cultura)\b/i',  // Palabras conteniendo "cu"
            '/\b(dar o|enfiar no|vai tomar no|vai pro) cu\b/i',  // Expresiones vulgares comunes
            '/\b(com o|no|pelo) cu\b/i',  // Con preposiciones
            '/\b(acupuntura|acupressão|curador|curadoria|curatela|cuidado|acuidade|acurácia|acústica)\b/i',  // Términos técnicos/médicos
        ],
        'pinto' => [
            '/\b(pássaro|ave|pintassilgo|pintarroxo|pintainho).*\bpinto\b/i',  // Referencias a aves
            '/\b(pintar|pintado|pintura|pintora|pintor|pincel).*\bpinto\b/i',  // Relacionado con pintura
            '/\b(pinto) (amarelo|vermelho|azul|verde|colorido)\b/i',  // Color
            '/\b(José|João|Silva|Souza|Ferreira) (Pinto)\b/i',  // Apellido común en portugués
            '/\b(Roberto|Carlos|Gabriel|Manuel|Lucas) (Pinto)\b/i',  // Nombres compuestos
            '/\b(criar|comprar|vender) (pintos)\b/i',  // Contexto avícola
            '/\b(galo e|galinha e|ninhada de) pinto(s)?\b/i', // Contexto de granja
        ],
        'porra' => [
            '/\b(estudo|pesquisa|linguística|etimologia|palavrão|palavrões).*\bporra\b/i',  // Contexto lingüístico
            '/\b(sociolinguística|tabus da linguagem|vocabulário proibido).*\bporra\b/i',  // Contexto académico
            '/\b(que|quê|o quê|vai|vá|fosse|essa|aquela|a|muita) (porra)\b/i', // Expresiones comunes
            '/\b(porra) (nenhuma|alguma|toda|qualquer)\b/i',  // Con adjetivos indefinidos
            '/\b(fazer|fez|fazendo) (a|uma) porra\b/i',  // Con verbos
            '/\b(competição|jogo|disputa|brincadeira|esporte) (da|de) porra\b/i',  // Juego del "esperma"
            '/\bque (porra) (é essa|foi essa)\b/i',  // Expresión de sorpresa
            '/\b(na|da|pela) porra\b/i',  // Con preposiciones
        ],
        'puta' => [
            '/\b(histórico|antigo|bíblico|literário|medieval|renascentista).*\bputa\b/i',  // Contexto histórico
            '/\b(madalena|jezebel|dalila|figura bíblica).*\bputa\b/i',  // Contexto bíblico
            '/\b(estudo|pesquisa|paper|análise|livro|artigo).*\bprostitutição\b.*\bputa\b/i',  // Contexto académico
            '/\b(puta) (que|que o|merda|foda|vida|pariu|miséria|inferno|droga)\b/i',  // Expresiones con más de una palabra
            '/\b(da|de|muita|tanta|que) puta\b/i',  // Con determinantes/intensificadores
            '/\b(filho da|que|sua) puta\b/i',  // Insultos comunes
            '/\b(estar|ficar|andar) (puto|puta)\b/i',  // "Estar enfadado" (Portugal)
            '/\b(puta) (vida|merda|miséria|desgraça|sorte|falta)\b/i',  // Expresión de frustración
        ],
        'caralho' => [
            '/\b(náutico|marítimo|naval|navio|mastro|embarcação).*\bcaralho\b/i',  // Sentido original marítimo
            '/\b(estudo|pesquisa|linguística|etimologia|palavrão).*\bcaralho\b/i',  // Contexto lingüístico
            '/\b(vai|vá|que|quê|o|do|que o|para o) (caralho)\b/i',  // Expresiones cotidianas
            '/\b(mandar|ir|vai|vou|foi) (para o|pro|ao|no|a) caralho\b/i',  // "Mandar a paseo"
            '/\b(meu|teu|seu|nosso|esse|este|aquele|um|o|do) caralho\b/i',  // Con posesivos
            '/\b(que|do|no|ao|pelo|pra|para) caralho\b/i',  // Uso intensificador
            '/\b(caralho) (a quatro|a bordo|do navio|do barco)\b/i',  // Términos náuticos
        ],
        'foda' => [
            '/\b(é|foi|está|estão|era|será|sendo) (foda)\b/i',  // "Ser increíble/difícil"
            '/\b(muito|bem|super|hiper|mais|menos|tão) foda\b/i',  // Con adverbios - significado positivo
            '/\b(situação|coisa|problema|questão|assunto|caso) (foda)\b/i',  // "Situación difícil"
            '/\b(pessoa|cara|mulher|homem|menino|menina|professor|aluno) (foda)\b/i',  // "Persona increíble"
            '/\b(foda-se|se foda|te foda|foda você)\b/i',  // Expresiones ofensivas
            '/\b(estudo|pesquisa|análise|tratado|livro) (sobre|de|da) foda\b/i',  // Contexto académico
        ],
        'buceta' => [
            '/\b(anatomia|ginecologia|médico|médica|vulva|vagina|exame).*\bbuceta\b/i',  // Contexto médico
            '/\b(estudo|pesquisa|tratado|análise).*\bbuceta\b/i',  // Contexto académico
            '/\b(abrir|pegar|meter|comer|lamber) (a|sua|minha|na) buceta\b/i',  // Expresiones vulgares
        ],
        'merda' => [
            '/\b(vaca|cavalo|cachorro|gato|pássaro|animal).*\bmerda\b/i', // Excrementos animales
            '/\b(fertilizante|adubo|excremento|fezes|esterco|estrume|resíduo|composto).*\bmerda\b/i', // Contexto agrícola/médico
            '/\b(arqueologia|fóssil|coprólito).*\bmerda\b/i', // Contexto científico
            '/\b(dar|fazer|cagar|pisar|estar na) merda\b/i',  // Expresiones idiomáticas
            '/\b(que|muita|tanta|uma|a|essa|aquela) merda\b/i',  // Con determinantes
            '/\b(não|em|com|sem|para|de) merda\b/i',  // Con preposiciones
            '/\b(merda) (nenhuma|qualquer|alguma|toda)\b/i',  // Con indefinidos
            '/\b(puta|do caralho|de|da) merda\b/i',  // Expresiones compuestas
        ],
        'viado' => [
            '/\b(veado|viado) (campeiro|mateiro|catingueiro|vermelho|bororó|galheiro)\b/i',  // Tipos de ciervo (Brasil)
            '/\b(caçar|caça|criação|observação|ecologia) (de|do|dos) (veado|viado)(s)?\b/i',  // Actividades relacionadas con ciervos
            '/\b(direitos|comunidade|movimento|parada|orgulho) (LGBT|LGBTQ|gay).*\bviado\b/i',  // Contexto de derechos
            '/\b(preconceito|discriminação|homofobia|termo|insulto|ofensa).*\bviado\b/i',  // Discusión sobre discriminación
        ],
        'corno' => [
            '/\b(animal|boi|vaca|touro|búfalo|cervo|rena|alce|veado) (com|de|do) corno(s)?\b/i',  // Referencia a cuernos animales
            '/\b(grande|pequeno|longo|curto|duro|afiado|decorativo) corno\b/i',  // Descripción de cuernos
            '/\b(chifre|corno) (de|do|da|dos|das) (animal|boi|vaca|cervo|rinoceronte)\b/i',  // Material de cuernos
            '/\b(instrumento|trompete|trompa|buzina) (de|do) corno\b/i',  // Instrumento musical
            '/\b(ser|é|está|virou|ficou|tornou) corno\b/i',  // "Ser engañado"
            '/\b(marido|homem|cara) corno\b/i',  // Con sustantivos masculinos
        ],
        'rola' => [
            '/\b(pássaro|ave|pomba|juriti|rolinha|asa-branca).*\brola\b/i',  // Ave
            '/\b(rola) (cascavel|turca|comum|brava|selvagem)\b/i',  // Tipos de ave
            '/\b(escutar|ouvir|ver|observar|fotografar) (a|uma|alguma) rola\b/i',  // Acciones con aves
            '/\b(cantar|canto|voo) (da|de|uma) rola\b/i',  // Comportamiento de aves
            '/\b(rolar|rolando|rolou|role|rola) (dados|festa|baile|conversa|papo|história)\b/i',  // Verbo "rolar" conjugado
        ],
        'cacete' => [
            '/\b(bater|bate|bateu|batendo) (com|usando|um|o) cacete\b/i',  // Bastón/porra (original)
            '/\b(pau|porrete|bastão|vara|bordão) (ou|e) cacete\b/i',  // Sinónimos legítimos
            '/\b(do|de|um|no|com|sem) cacete\b/i',  // Con preposiciones
            '/\b(puta|muito|que|do) cacete\b/i',  // Expresiones intensificadoras
            '/\b(é|está|foi|era) (um|o) cacete\b/i',  // "Es difícil/complicado"
            '/\b(cacetete|cassetete)\b/i',  // Porra policial (derivado)
        ],
    ],
];
