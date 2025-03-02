<?php

/**
 * English context definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    // Words that intensify offensive content when combined with profanity
    'intensifiers' => [
        'very', 'really', 'fucking', 'absolutely', 'totally', 'completely',
        'utterly', 'literal', 'literally', 'seriously', 'damn', 'goddamn',
        'super', 'extreme', 'extremely', 'so', 'such', 'truly', 'bloody',
        'ridiculously', 'incredibly', 'terribly', 'awfully', 'horribly',
        'severely', 'majorly', 'decidedly', 'tremendously', 'crazy',
        'insanely', 'thoroughly', 'entirely', 'properly', 'especially',
        'particularly', 'genuinely', 'deeply', 'profoundly', 'intensely',
        'heavily', 'immensely', 'precisely', 'purely', 'quite', 'rather',
        'simply', 'strongly', 'unbelievably', 'uncommonly', 'vastly',
    ],

    // Words that indicate a more aggressive/negative context
    'negative_modifiers' => [
        'hate', 'hating', 'hated', 'kill', 'killing', 'killed', 'die', 'dying', 'died',
        'destroy', 'destroying', 'destroyed', 'stupid', 'idiot', 'moron', 'dumb', 'pathetic',
        'attack', 'attacking', 'attacked', 'hurt', 'hurting', 'hurts', 'ugly', 'disgusting',
        'awful', 'terrible', 'horrible', 'worst', 'bad', 'worst', 'disgusting', 'revolting',
        'angry', 'angry', 'pissed', 'mad', 'loser', 'hell', 'annoying', 'annoy', 'irritating',
        'despise', 'detest', 'abhor', 'despicable', 'useless', 'worthless', 'nasty', 'vile',
        'evil', 'wicked', 'cruel', 'brutal', 'savage', 'bitch', 'bastard', 'asshole', 'sick',
        'twisted', 'perverse', 'deranged', 'insane', 'crazy', 'lunatic', 'psycho', 'psychotic',
        'maniac', 'demented', 'rude', 'mean', 'aggressive', 'violent', 'threatening', 'hostile',
        'intimidating', 'bullying', 'harassing', 'abusive', 'offensive', 'insulting', 'garbage',
        'trash', 'reject', 'failure', 'incompetent', 'inept', 'inadequate', 'hopeless', 'miserable',
        'pitiful', 'contemptible', 'despicable', 'detestable', 'repulsive', 'repugnant', 'repellent',
        'loathsome', 'hateful', 'spiteful', 'vindictive', 'malicious', 'malevolent', 'toxic',
        'poisonous', 'noxious', 'harmful', 'damaging', 'destructive', 'ruinous', 'devastating',
    ],

    // Words that indicate a mitigating/positive context
    'positive_modifiers' => [
        'love', 'loving', 'loved', 'like', 'liking', 'liked', 'good', 'great', 'awesome',
        'amazing', 'wonderful', 'excellent', 'fantastic', 'terrific', 'outstanding', 'superb',
        'brilliant', 'cool', 'nice', 'best', 'beautiful', 'enjoy', 'enjoying', 'enjoyed',
        'happy', 'glad', 'pleased', 'delighted', 'impressive', 'perfect', 'impressive',
        'fabulous', 'marvelous', 'magnificent', 'splendid', 'extraordinary', 'exceptional',
        'remarkable', 'spectacular', 'stunning', 'breathtaking', 'gorgeous', 'lovely', 'cute',
        'charming', 'delightful', 'pleasant', 'agreeable', 'satisfying', 'gratifying', 'rewarding',
        'exciting', 'thrilling', 'exhilarating', 'amusing', 'entertaining', 'fun', 'funny',
        'hilarious', 'comical', 'interesting', 'engaging', 'captivating', 'fascinating', 'intriguing',
        'compelling', 'appealing', 'attractive', 'admirable', 'commendable', 'praiseworthy',
        'impressive', 'accomplished', 'skilled', 'talented', 'creative', 'ingenious', 'clever',
        'smart', 'intelligent', 'wise', 'insightful', 'perceptive', 'thoughtful', 'considerate',
        'kind', 'friendly', 'warm', 'caring', 'helpful', 'supportive', 'encouraging', 'positive',
        'optimistic', 'hopeful', 'uplifting', 'inspiring', 'motivating', 'refreshing', 'invigorating',
        'revitalizing', 'energizing', 'fulfilling', 'meaningful', 'worthwhile', 'valuable',
    ],

    // Words that indicate a scientific or educational context
    'educational_context' => [
        'research', 'study', 'analysis', 'education', 'educational', 'academic', 'scholarly',
        'scientific', 'medical', 'biological', 'history', 'historical', 'literature', 'political',
        'psychology', 'sociology', 'anthropology', 'linguistics', 'paper', 'thesis', 'dissertation',
        'lecture', 'explain', 'explanation', 'definition', 'define', 'analyze', 'examine', 'discuss',
        'course', 'university', 'college', 'professor', 'doctoral', 'theory', 'concept', 'classroom',
        'science', 'experiment', 'laboratory', 'clinical', 'anatomy', 'physiology', 'biology',
        'textbook', 'curriculum', 'journal', 'publication', 'article', 'investigation', 'research',
        'scholar', 'academia', 'academic', 'classroom', 'lecture', 'seminar', 'conference',
        'symposium', 'workshop', 'laboratory', 'experiment', 'hypothesis', 'theory', 'analysis',
        'methodology', 'methodology', 'data', 'evidence', 'findings', 'results', 'conclusion',
        'abstract', 'introduction', 'literature', 'review', 'background', 'method', 'discussion',
        'bibliography', 'reference', 'citation', 'quote', 'paraphrase', 'summary', 'argument',
        'thesis', 'dissertation', 'monograph', 'treatise', 'critique', 'criticism', 'assessment',
        'evaluation', 'examination', 'investigation', 'inquiry', 'exploration', 'survey', 'interview',
        'questionnaire', 'observation', 'experiment', 'case', 'study', 'field', 'work', 'empirical',
        'theoretical', 'conceptual', 'analytical', 'qualitative', 'quantitative', 'statistical',
        'mathematical', 'logical', 'reasoning', 'inference', 'deduction', 'induction', 'syllogism',
        'premise', 'conclusion', 'claim', 'warrant', 'evidence', 'backing', 'rebuttal', 'counterargument',
        'debate', 'discourse', 'dialectic', 'rhetoric', 'persuasion', 'eloquence', 'articulation',
        'vocabulary', 'terminology', 'lexicon', 'glossary', 'definition', 'etymology', 'semantics',
        'syntax', 'grammar', 'orthography', 'phonology', 'morphology', 'linguistics', 'philology',
        'epistemology', 'ontology', 'metaphysics', 'ethics', 'aesthetics', 'logic', 'philosophy',
        'psychology', 'sociology', 'anthropology', 'archaeology', 'history', 'geography', 'geology',
        'astronomy', 'physics', 'chemistry', 'biology', 'zoology', 'botany', 'ecology', 'anatomy',
        'physiology', 'medicine', 'psychiatry', 'psychology', 'neuroscience', 'cognitive', 'behavioral',
        'developmental', 'clinical', 'social', 'personality', 'abnormal', 'physiological', 'comparative',
        'evolutionary', 'industrial', 'organizational', 'educational', 'forensic', 'mathematical',
        'history', 'civilization', 'culture', 'society', 'politics', 'government', 'economics',
        'law', 'justice', 'rights', 'ethics', 'morality', 'religion', 'spirituality', 'theology',
        'art', 'literature', 'music', 'drama', 'poetry', 'fiction', 'nonfiction', 'biography',
        'autobiography', 'memoir', 'journalism', 'media', 'communication', 'rhetoric', 'composition',
        'language', 'linguistics', 'grammar', 'syntax', 'semantics', 'phonetics', 'phonology',
        'morphology', 'lexicography', 'etymology', 'dialect', 'idiolect', 'sociolect', 'register',
        'jargon', 'slang', 'colloquialism', 'idiom', 'proverb', 'metaphor', 'simile', 'analogy',
        'allegory', 'symbolism', 'motif', 'theme', 'narrative', 'plot', 'characterization', 'dialogue',
        'monologue', 'soliloquy', 'exposition', 'rising', 'action', 'climax', 'falling', 'resolution',
        'denouement', 'conflict', 'protagonist', 'antagonist', 'setting', 'atmosphere', 'tone', 'mood',
        'purpose', 'audience', 'context', 'genre', 'subgenre', 'convention', 'tradition', 'innovation',
        'influence', 'intertextuality', 'allusion', 'reference', 'homage', 'parody', 'satire', 'irony',
        'sarcasm', 'wit', 'humor', 'comedy', 'tragedy', 'tragicomedy', 'romance', 'epic', 'lyric',
        'dramatic', 'didactic', 'pastoral', 'elegiac', 'satiric', 'comic', 'tragic', 'mock', 'heroic',
        'medieval', 'renaissance', 'baroque', 'neoclassical', 'romantic', 'realistic', 'naturalistic',
        'modernist', 'postmodernist', 'contemporary',
    ],

    // Pronouns used to detect targeted offensive content
    'pronouns' => [
        'you', 'your', 'yours', 'yourself', 'yourselves',
        'they', 'them', 'their', 'theirs', 'themselves',
        'he', 'him', 'his', 'himself',
        'she', 'her', 'hers', 'herself',
        'we', 'us', 'our', 'ours', 'ourselves',
        'it', 'its', 'itself',
        'who', 'whom', 'whose',
        'that', 'which',
        'this', 'these', 'those',
    ],

    // Words that indicate quoted or reported speech
    'quote_words' => [
        'said', 'says', 'say', 'saying', 'quoted', 'quotes', 'quoting', 'according', 'claimed', 'claims',
        'claiming', 'stated', 'states', 'stating', 'wrote', 'writes', 'writing', 'mentioned', 'mentions',
        'mentioning', 'tweeted', 'tweets', 'tweeting', 'reported', 'reports', 'reporting', 'commented',
        'comments', 'commenting', 'noted', 'notes', 'noting', 'expressed', 'expresses', 'expressing',
        'testified', 'testifies', 'testifying', 'admitted', 'admits', 'admitting', 'confessed',
        'confesses', 'confessing', 'declared', 'declares', 'declaring', 'announced', 'announces',
        'announcing', 'explained', 'explains', 'explaining', 'added', 'adds', 'adding', 'replied',
        'replies', 'replying', 'answered', 'answers', 'answering', 'responded', 'responds', 'responding',
        'shouted', 'shouts', 'shouting', 'yelled', 'yells', 'yelling', 'screamed', 'screams', 'screaming',
        'whispered', 'whispers', 'whispering', 'called', 'calls', 'calling', 'texted', 'texts', 'texting',
        'emailed', 'emails', 'emailing', 'posted', 'posts', 'posting', 'published', 'publishes', 'publishing',
        'wrote', 'writes', 'writing', 'told', 'tells', 'telling', 'asked', 'asks', 'asking', 'questioned',
        'questions', 'questioning', 'inquired', 'inquires', 'inquiring', 'discussed', 'discusses', 'discussing',
        'argued', 'argues', 'arguing', 'debated', 'debates', 'debating', 'disputed', 'disputes', 'disputing',
        'alleged', 'alleges', 'alleging', 'asserted', 'asserts', 'asserting', 'claimed', 'claims', 'claiming',
        'maintained', 'maintains', 'maintaining', 'insisted', 'insists', 'insisting', 'suggested', 'suggests',
        'suggesting', 'implied', 'implies', 'implying', 'indicated', 'indicates', 'indicating', 'signaled',
        'signals', 'signaling', 'hinted', 'hints', 'hinting', 'alluded', 'alludes', 'alluding', 'referred',
        'refers', 'referring', 'cited', 'cites', 'citing', 'quoted', 'quotes', 'quoting', 'paraphrased',
        'paraphrases', 'paraphrasing', 'summarized', 'summarizes', 'summarizing', 'recounted', 'recounts',
        'recounting', 'related', 'relates', 'relating', 'described', 'describes', 'describing', 'narrated',
        'narrates', 'narrating', 'chronicled', 'chronicles', 'chronicling', 'documented', 'documents',
        'documenting', 'recorded', 'records', 'recording', 'remarked', 'remarks', 'remarking', 'observed',
        'observes', 'observing', 'noticed', 'notices', 'noticing', 'pointed', 'points', 'pointing',
        'highlighted', 'highlights', 'highlighting', 'emphasized', 'emphasizes', 'emphasizing', 'stressed',
        'stresses', 'stressing', 'underscored', 'underscores', 'underscoring', 'articulated', 'articulates',
        'articulating', 'voiced', 'voices', 'voicing', 'uttered', 'utters', 'uttering', 'pronounced',
        'pronounces', 'pronouncing', 'verbalized', 'verbalizes', 'verbalizing', 'phrased', 'phrases',
        'phrasing', 'worded', 'words', 'wording', 'formulated', 'formulates', 'formulating', 'communicated',
        'communicates', 'communicating', 'conveyed', 'conveys', 'conveying', 'relayed', 'relays', 'relaying',
        'transmitted', 'transmits', 'transmitting', 'disseminated', 'disseminates', 'disseminating',
        'broadcast', 'broadcasts', 'broadcasting', 'announced', 'announces', 'announcing',
    ],

    // Words that indicate excuses or apologies for language
    'excuse_words' => [
        'excuse', 'excuses', 'excusing', 'pardon', 'pardons', 'pardoning', 'forgive', 'forgives',
        'forgiving', 'sorry', 'apology', 'apologize', 'apologizes', 'apologizing', 'regret',
        'regrets', 'regretting', 'unfortunate', 'unfortunately', 'forgiveness', 'pardon',
        'apologetic', 'remorseful', 'contrite', 'penitent', 'repentant', 'regretful', 'shameful',
        'shame', 'ashamed', 'embarrassed', 'embarrassment', 'mistaken', 'mistake', 'error',
        'wrong', 'incorrect', 'inappropriate', 'misspoken', 'misspeak', 'misunderstood',
        'misunderstanding', 'confusion', 'confused', 'unclear', 'ambiguous', 'ambiguity',
        'unintended', 'unintentional', 'inadvertent', 'accidental', 'accident', 'slip',
        'slipped', 'misstep', 'fault', 'blame', 'responsibility', 'accountable', 'amends',
        'recompense', 'compensate', 'compensation', 'rectify', 'correct', 'correction',
        'redress', 'remedy', 'remediate', 'reconcile', 'reconciliation', 'mend', 'repair',
        'restore', 'restoration', 'heal', 'healing', 'forgiven', 'forgiveness', 'pardoned',
        'pardon', 'absolved', 'absolution', 'atonement', 'atone', 'penance', 'repentance',
        'repent', 'contrition', 'remorse', 'penitence', 'sorrow', 'beg', 'begging', 'implore',
        'imploring', 'plea', 'plead', 'pleading', 'appeal', 'appealing', 'supplicate',
        'supplication', 'entreat', 'entreaty', 'petition', 'solicitation', 'request',
        'requesting', 'ask', 'asking', 'excuse', 'excusing', 'justification', 'justify',
        'justifying', 'explanation', 'explain', 'explaining', 'defend', 'defending', 'defense',
        'vindicate', 'vindication', 'exonerate', 'exoneration', 'absolve', 'absolution',
    ],

    // Common words used for language detection
    'language_markers' => [
        'the', 'a', 'an', 'and', 'or', 'of', 'in', 'on', 'at', 'by', 'for', 'with', 'about',
        'to', 'from', 'as', 'into', 'during', 'including', 'until', 'against', 'among', 'throughout',
        'despite', 'towards', 'upon', 'concerning', 'that', 'which', 'who', 'whom', 'this',
        'these', 'those', 'they', 'it', 'he', 'she', 'them', 'their', 'his', 'her', 'its', 'is',
        'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did',
        'can', 'could', 'will', 'would', 'shall', 'should', 'may', 'might', 'must', 'but', 'however',
        'although', 'yet', 'still', 'nevertheless', 'nonetheless', 'whereas', 'while', 'because',
        'since', 'if', 'unless', 'when', 'whenever', 'where', 'wherever', 'after', 'before', 'now',
        'then', 'here', 'there', 'again', 'already', 'always', 'never', 'often', 'seldom', 'usually',
        'typically', 'finally', 'eventually', 'subsequently', 'previously', 'i', 'me', 'my', 'mine',
        'myself', 'we', 'us', 'our', 'ours', 'ourselves', 'you', 'your', 'yours', 'yourself',
        'one', 'two', 'three', 'first', 'second', 'third', 'next', 'last', 'many', 'much', 'more',
        'most', 'some', 'any', 'all', 'few', 'little', 'less', 'least', 'other', 'another', 'such',
        'same', 'different', 'like', 'just', 'too', 'very', 'really', 'quite', 'rather', 'enough',
    ],

    // Educational/academic safe terms
    'safe_educational_terms' => [
        'anal',             // As in "anal retentive" or "anal stage" (psychology)
        'sex',              // Biological sex, gender studies
        'sexual',           // Scientific contexts
        'sexuality',        // Academic discussions
        'intercourse',      // Social or sexual contexts in academic discussions
        'reproduction',     // Biology, science
        'penis',            // Anatomy, biology
        'vagina',           // Anatomy, biology
        'breast',           // Anatomy, biology
        'rectum',           // Anatomy, biology
        'testicle',         // Anatomy, biology
        'ovary',            // Anatomy, biology
        'uterus',           // Anatomy, biology
        'menstruation',     // Anatomy, biology
        'ejaculation',      // Anatomy, biology
        'erection',         // Anatomy, biology
        'climax',           // Anatomy, biology
        'orgasm',           // Anatomy, biology
        'sperm',            // Anatomy, biology
        'egg',              // Anatomy, biology
        'zygote',           // Anatomy, biology
        'embryo',           // Anatomy, biology
        'fetus',            // Anatomy, biology
        'conception',       // Anatomy, biology
        'fertilization',    // Anatomy, biology
        'gestation',        // Anatomy, biology
        'birth',            // Anatomy, biology
        'puberty',          // Anatomy, biology
        'adolescence',      // Anatomy, biology
        'adulthood',        // Anatomy, biology
        'homosexual',       // Academic discussion, not pejorative
        'heterosexual',     // Academic discussion, not pejorative
        'bisexual',         // Academic discussion, not pejorative
        'transgender',      // Academic discussion, not pejorative
        'gender',           // Academic discussion, not pejorative
        'identity',         // Academic discussion, not pejorative
        'orientation',      // Academic discussion, not pejorative
        'preference',       // Academic discussion, not pejorative
        'attraction',       // Academic discussion, not pejorative
        'dyke',             // In academic discussions about reclaiming terms
        'queer',            // Academic discussions, gender studies
        'gay',              // Academic discussions, gender studies
        'lesbian',          // Academic discussions, gender studies
        'mating',           // Biology, zoology
        'copulation',       // Biology, zoology
        'coitus',           // Biology, medicine
        'breeding',         // Biology, zoology, agriculture
        'procreation',      // Biology, anthropology
        'promiscuity',      // Psychology, sociology
        'libido',           // Psychology
        'hormones',         // Biology, medicine
        'testosterone',     // Biology, medicine
        'estrogen',         // Biology, medicine
        'progesterone',     // Biology, medicine
        'circumcision',     // Medicine, anthropology, religious studies
        'contraception',    // Medicine, public health
        'sterilization',    // Medicine, public health
        'infertility',      // Medicine
        'impotence',        // Medicine
        'dysfunction',      // Medicine
        'stds',             // Medicine, public health
        'sti',              // Medicine, public health
        'hiv',              // Medicine, public health
        'aids',             // Medicine, public health
        'condom',           // Medicine, public health
        'diaphragm',        // Medicine, public health
        'pill',             // Medicine, public health
        'iud',              // Medicine, public health
        'abstinence',       // Medicine, public health, religious studies
        'celibacy',         // Medicine, public health, religious studies
        'virginity',        // Medicine, public health, religious studies
        'purity',           // Religious studies
        'chastity',         // Religious studies
        'promiscuity',      // Psychology, sociology
        'monogamy',         // Psychology, sociology, anthropology
        'polygamy',         // Psychology, sociology, anthropology
        'polyamory',        // Psychology, sociology
        'pornography',      // Psychology, sociology, media studies
        'erotica',          // Literature, media studies
        'prostitution',     // Sociology, criminology
        'brothel',          // History, sociology
        'harem',            // History, sociology
        'concubine',        // History, sociology
        'mistress',         // History, sociology
        'adultery',         // Law, ethics, religious studies
        'fornication',      // Religious studies
        'sodomy',           // Law, history, religious studies
        'incest',           // Psychology, sociology, law
        'pedophilia',       // Psychology, criminology
        'rape',             // Law, criminology
        'molestation',      // Law, criminology
        'assault',          // Law, criminology
        'harassment',       // Law, sociology
        'victim',           // Law, psychology
        'trauma',           // Psychology
        'consent',          // Law, ethics
        'ethics',           // Philosophy
        'morality',         // Philosophy, religious studies
    ],

    // Technical domain-specific terms
    'safe_technical_terms' => [
        'screw',            // Hardware, construction
        'bang',             // Programming (!) operator
        'stroke',           // Graphics, medical, sports
        'execute',          // Programming, legal
        'kill',             // Programming, process management
        'suicide',          // In discussions about prevention, mental health
        'master',           // Master/slave in technical contexts
        'slave',            // Master/slave in technical contexts
        'execution',        // Programming, legal
        'abort',            // Programming term
        'dummy',            // Test case, placeholder
        'crack',            // Software cracking, geology
        'bullet',           // Typography, ammunition
        'shoot',            // Photography, sports
        'injection',        // Medical, programming (SQL injection)
        'penetration',      // Security testing
        'force',            // Physics, security (brute force)
        'exploit',          // Security, vulnerability
        'attack',           // Security, network
        'dead',             // Computing (dead link, dead code)
        'death',            // Computing (death of a process)
        'hardcore',         // Computing (hardcore gaming)
        'hard',             // Computing (hardware, hard drive)
        'soft',             // Computing (software)
        'naked',            // Computing (naked domain)
        'abuse',            // Computing (abuse reports)
        'violation',        // Computing (policy violation)
        'hit',              // Web analytics, baseball
        'flush',            // Computing (flush cache), plumbing
        'dirty',            // Computing (dirty bit, dirty read)
        'hook',             // Programming, sports
        'race',             // Computing (race condition)
        'dump',             // Computing (memory dump)
        'hole',             // Security (hole), golf
        'finger',           // Unix command
        'pipe',             // Programming, plumbing
        'socket',           // Programming, electrical
        'daemon',           // Unix process
        'orphan',           // Computing (orphan process)
        'zombie',           // Computing (zombie process)
        'strip',            // Programming (strip whitespace)
        'naked',            // Computing (naked domain)
        'exposed',          // API, endpoint
        'binding',          // Programming
        'mount',            // File systems
        'unmount',          // File systems
        'anonymous',        // Computing (anonymous function)
        'member',           // Programming (class member)
        'head',             // Computing (head of a list)
        'tail',             // Computing (tail of a list)
        'sniff',            // Networking (packet sniffing)
        'native',           // Programming (native code)
        'deadlock',         // Computing
        'threaded',         // Computing
        'orphaned',         // Computing (orphaned process)
        'hung',             // Computing (hung process)
        'latency',          // Computing
        'throttle',         // Computing
        'execute',          // Computing
        'bind',             // Computing
        'unbind',           // Computing
        'grind',            // Gaming (grinding for experience)
        'patch',            // Software
        'token',            // Security
        'cookie',           // Web
        'worm',             // Security
        'virus',            // Security
        'trojan',           // Security
        'backdoor',         // Security
        'flood',            // Network
        'bounce',           // Email
        'spam',             // Email
    ],

    // Word-specific safe context patterns (regex patterns)
    'word_specific_patterns' => [
        'ass' => [
            '/\b(donkey|burro|mule).*\bass\b/i',           // References to animals
            '/\b(jack|smart|dumb|bad|lazy|silly|stupid|wise|lame|poor|pompous|pain in the|kick|ride|haul|bust|save|cover|crazy|wild|bad|stubborn)(?:\s+|\-)(ass)\b/i',  // Phrases with ass
            '/\bass(et|ignment|ociation|embly|essment|istant|ume|ert|ess|ume|uage|ay|ault|ent|orted|imilate|ist|ociate|ure)/i',  // Words starting with "ass"
            '/\b(class|glass|brass|pass|mass|sass|bass|grass|lass|compass)/i',  // Words ending with "ass"
            '/\b(assassin|assault|assay|assent|assert|assess|asset|assign|assimilate|assist|associate|assure|assortment)\b/i',  // Words containing "ass" with specific meanings
        ],
        'cock' => [
            '/\b(pea|wea|ban|han|shu|hi|game|tur|wood|weather|stop|hay|shuttle)cock\b/i',  // Various bird species and compound words
            '/\bcock(pit|tail|roach|le|ed|fight|up|sure|crow|y|screw|atoo|atiel|ade|er)\b/i',  // Words starting with cock
            '/\b(hay|pea|pop|shut|stop)cock\b/i',          // Compound words ending with cock
            '/\b(cockatoo|cockatiel|cockerel|cockroach|cockpit|cocktail|cockney|cockamamie|cocksure)\b/i',  // Legitimate words containing cock
        ],
        'dick' => [
            '/\b(moby|harry|philip|private|detective|spotted|speckled|great spotted|lesser spotted) dick\b/i',  // Names and phrases
            '/\bdick(ens|ensian|inson|inson\'s)\b/i',      // Names and adjectives
            '/\b(dick)tionary\b/i',                        // Parts of other words
            '/\b(dick)tation\b/i',                         // Parts of other words
            '/\b(moby|ahab|melville|ishmael|queequeg).*\bdick\b/i',  // Moby Dick references
            '/\bdick (tracy|francis|van dyke|cavett|cheney|clark|durbin|wolf|york|button|powell|smothers|morris)\b/i',  // People named Dick
            '/\bdetective dick\b/i',                       // Detective character
            '/\bprivate dick\b/i',                         // Slang for detective
        ],
        'pussy' => [
            '/\b(cat|kitten|feline|pet|domestic|house|stray|alley|tomcat|siamese|persian|maine coon|tabby|calico).*\bpussy\b/i',         // References to cats
            '/\b(pussy)(cat|willow|foot|toe|footer)\b/i',  // Compound words
            '/\b(scaredy|scared|fraidy)[\s-]cat\b/i',      // Phrases about scared cats
        ],
        'bitch' => [
            '/\b(female|breeding|show|hunting) (dog|canine|hound|terrier|retriever|shepherd|collie).*\bbitch\b/i', // Dog breeding context
            '/\b(dog|canine|puppy|kennel|breed|breeding).*\bbitch\b/i', // Dog related context
            '/\b(bitch) (puppy|pup|wolf|fox)\b/i',         // Animal contexts
            '/\b(dog|puppy|wolf|fox) (bitch)\b/i',         // Animal contexts
            '/\b(breeding|whelping).*\bbitch\b/i',         // Breeding context
        ],
        'cunt' => [
            '/\b(chaucer|canterbury|medieval literature|middle english|old english).*\bcunt\b/i', // Historical literature context
            '/\b(etymology|linguistic history|historical terms).*\bcunt\b/i', // Linguistic context
        ],
        'shit' => [
            '/\b(bull|horse|cow|dog|cat|bat|bird|owl|chicken).*\bshit\b/i', // Animal excrement
            '/\b(fertilizer|manure|excrement|feces|stool|droppings|waste|compost).*\bshit\b/i', // Agricultural/medical context
            '/\b(archaeology|fossil|coprolite).*\bshit\b/i', // Scientific context
        ],
        'fuck' => [
            '/\b(etymology|linguistic|historical slang|taboo language|expletive|profanity research).*\bfuck\b/i', // Linguistic study context
            '/\b(sociolinguistics|language taboos|forbidden vocabulary).*\bfuck\b/i', // Academic context
        ],
        'damn' => [
            '/\b(dam|dammed|damming).*\bwater\b/i',        // Water management context
            '/\b(hoover|beaver|hydro|hydroelectric).*\bdam\b/i', // Specific dams
            '/\b(god|hell|eternal|divine).*\b(damn(ation)?|damned)\b/i', // Religious context
            '/\b(judge|judgment|court|legal|sentence).*\b(damn|damned|damnation)\b/i', // Legal context
        ],
        'whore' => [
            '/\b(historical|ancient|biblical|literary|medieval|renaissance).*\bwhore\b/i', // Historical context
            '/\b(magdalene|jezebel|delilah|biblical figure).*\bwhore\b/i', // Biblical context
            '/\b(shakespeare|dickens|literature|character).*\bwhore\b/i', // Literary context
            '/\b(study|research|paper|analysis|book|article).*\bprostitution\b.*\bwhore\b/i', // Academic context
        ],
        'bastard' => [
            '/\b(illegitimate|child|son|birth|born out of wedlock|inheritance|legal).*\bbastard\b/i', // Legal/historical context
            '/\b(royal|noble|medieval|historical|lineage|succession).*\bbastard\b/i', // Historical nobility context
            '/\b(jon snow|game of thrones|william the conqueror).*\bbastard\b/i', // Specific historical/fictional references
            '/\b(metallurgy|steel|sword|knife|blade).*\bbastard\b/i', // Metallurgy context (bastard sword, etc.)
            '/\b(bastard) (file|sword|amber|title|operator|pop|force|halibut|toadflax)\b/i', // Technical terms
        ],
        'nigger' => [
            '/\b(historical|racism|civil rights|literature|huckleberry finn|mark twain|to kill a mockingbird|harper lee|racist language|slur|historical context).*\bnigger\b/i', // Academic/literary context
            '/\b(study|research|paper|analysis|book|article|racism|discrimination).*\bnigger\b/i', // Academic context
        ],
        'fag' => [
            '/\b(british|uk|england|english|cigarette).*\bfag\b/i', // British English meaning
            '/\b(slang|historical|homosexuality|gay rights|homophobia|slur|pejorative).*\bfag\b/i', // Academic context
            '/\b(fagging|public school|boarding school|british tradition).*\bfag\b/i', // British school tradition
        ],
        'blowjob' => [
            '/\b(sexual health|medical|clinical|study|research|paper|analysis).*\bblowjob\b/i', // Medical/academic context
            '/\b(oral sex|fellatio|sexual activity|human sexuality).*\bblowjob\b/i', // Academic/medical context
        ],
        'sex' => [
            '/\b(gender|male|female|biological|chromosomal|genetic).*\bsex\b/i', // Biological context
            '/\b(sexual reproduction|sexual selection|sexual dimorphism).*\bsex\b/i', // Biological context
            '/\b(study|research|paper|analysis|book|article).*\bsex\b/i', // Academic context
            '/\b(sex) (education|determination|ratio|linked|change|chromosome|organ|cell|hormone|characteristic|difference|discrimination)\b/i', // Scientific compounds
        ],
    ],
];
