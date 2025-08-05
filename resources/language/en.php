<?php

/**
 * En language definitions for profanity detection
 * These define contextual words and patterns that help analyze the severity and intent
 * of potentially offensive content.
 */
return [
    'words' => [
        'offensive' => [
            'anal', 'anus', 'ass', 'asshole', 'bastard', 'bitch', 'boob', 'cock', 'cum',
            'cunt', 'dick', 'dildo', 'dyke', 'fag', 'faggot', 'fuck', 'fuk', 'handjob',
            'homo', 'jizz', 'kike', 'kunt', 'muff', 'nigger', 'penis', 'piss', 'poop',
            'pussy', 'queer', 'rape', 'semen', 'sex', 'shit', 'slut', 'titties', 'twat',
            'vagina', 'vulva', 'wank', 'analplug', 'analsex', 'arse', 'assassin', 'balls',
            'bimbo', 'bloody', 'bloodyhell', 'blowjob', 'bollocks', 'boner', 'boobies',
            'boobs', 'bugger', 'bukkake', 'bullshit', 'chink', 'clit', 'clitoris', 'cocksucker',
            'condom', 'coon', 'crap', 'cumshot', 'damm', 'dammit', 'damn', 'dickhead', 'doggystyle',
            'f0ck', 'fags', 'fanny', 'fck', 'fcker', 'fckr', 'fcku', 'fcuk', 'fucker', 'fuckface',
            'fuckr', 'fuct', 'genital', 'genitalia', 'genitals', 'glory hole', 'gloryhole',
            'gobshite', 'godammet', 'godammit', 'goddammet', 'goddammit', 'goddamn', 'gypo',
            'hitler', 'hooker', 'hore', 'horny', 'jesussucks', 'jizzum', 'kaffir', 'kill', 'killer',
            'killin', 'killing', 'lesbo', 'masturbate', 'milf', 'molest', 'moron', 'motherfuck',
            'mthrfckr', 'murder', 'murderer', 'nazi', 'negro', 'nigga', 'niggah', 'nonce', 'paedo',
            'paedophile', 'paki', 'pecker', 'pedo', 'pedofile', 'pedophile', 'phuk', 'pig', 'pimp',
            'poof', 'porn', 'prick', 'pron', 'prostitute', 'raped', 'rapes', 'rapist', 'schlong',
            'screw', 'scrotum', 'shag', 'shemale', 'shite', 'shiz', 'slag', 'spastic', 'spaz',
            'sperm', 'spunk', 'stripper', 'tart', 'terrorist', 'tits', 'tittyfuck', 'tosser', 'turd',
            'vaginal', 'vibrator', 'wanker', 'weed', 'wetback', 'whor', 'whore', 'wog', 'wtf', 'xxx',
            'abortion', 'anus', 'beastiality', 'bestiality', 'bewb', 'blow', 'blumpkin', 'cawk',
            'choad', 'cooter', 'cornhole', 'dong', 'douche', 'fart', 'foreskin', 'gangbang',
            'gook', 'hell', 'honkey', 'humping', 'jiz', 'labia', 'nutsack', 'pen1s', 'poon', 'punani',
            'queef', 'quim', 'rectal', 'rectum', 'rimjob', 'spick', 'spoo', 'spooge', 'taint',
            'titty', 'vag', 'whore',
        ],
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
        'modifiers' => [
            'negative' => [
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
            'positive' => [
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
        ],
        'quote' => [],
        'excuse' => [
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
    ],
    'prefixes' => [
        'un', 're', 'dis', 'mis', 'pre', 'over', 'under', 'sub', 'super', 'anti', 'auto', 'bi', 'co', 'de', 'en', 'ex',
        'fore', 'in', 'inter', 'mid', 'non', 'out', 'post', 'semi', 'tri', 'un', 'under', 'up', 'with',
    ],
    'suffixes' => [
        'ing', 'ed', 'er', 's', 'ers', "'s", 'es', 'est', 'ly', 'ier', 'iest',
    ],
    'pronouns' => [
        'you', 'your', 'yours', 'yourself', 'yourselves', 'they', 'them', 'their', 'theirs', 'themselves',
        'he', 'him', 'his', 'himself', 'she', 'her', 'hers', 'herself', 'we', 'us', 'our', 'ours', 'ourselves',
        'it', 'its', 'itself', 'who', 'whom', 'whose', 'that', 'which', 'this', 'these', 'those',
    ],
    'markers' => [
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
    'contexts' => [
        'educational' => [
            'markers' => [
                'research', 'study', 'analysis', 'education', 'educational', 'academic', 'scholarly', 'scientific', 'biological', 'history', 'historical', 'literature', 'political', 'psychology', 'sociology', 'anthropology', 'linguistics', 'paper', 'thesis', 'dissertation', 'lecture', 'explain', 'explanation', 'definition', 'define', 'analyze', 'examine', 'discuss', 'course', 'university', 'college', 'professor', 'doctoral', 'theory', 'concept', 'classroom', 'science', 'experiment', 'laboratory', 'anatomy', 'physiology', 'biology', 'textbook', 'curriculum', 'journal', 'publication', 'article', 'investigation', 'scholar', 'academia', 'seminar', 'conference', 'symposium', 'workshop', 'hypothesis', 'methodology', 'data', 'evidence', 'findings', 'results', 'conclusion', 'abstract', 'introduction', 'review', 'background', 'method', 'discussion', 'bibliography', 'reference', 'argument', 'monograph', 'treatise', 'critique', 'criticism', 'assessment', 'evaluation', 'examination', 'inquiry', 'exploration', 'survey', 'interview', 'questionnaire', 'observation', 'case', 'study', 'field', 'work', 'empirical', 'theoretical', 'conceptual', 'analytical', 'qualitative', 'quantitative', 'statistical', 'mathematical', 'logical', 'reasoning', 'inference', 'deduction', 'induction', 'syllogism', 'premise', 'claim', 'warrant', 'backing', 'rebuttal', 'counterargument', 'debate', 'discourse', 'dialectic', 'rhetoric', 'persuasion', 'eloquence', 'articulation', 'vocabulary', 'terminology', 'lexicon', 'glossary', 'etymology', 'semantics', 'syntax', 'grammar', 'orthography', 'phonology', 'morphology', 'philology', 'epistemology', 'ontology', 'metaphysics', 'ethics', 'aesthetics', 'philosophy', 'archaeology', 'geography', 'geology', 'astronomy', 'physics', 'chemistry', 'zoology', 'botany', 'ecology', 'neuroscience', 'cognitive', 'behavioral', 'developmental', 'forensic', 'mathematical', 'civilization', 'culture', 'society', 'politics', 'government', 'economics', 'justice', 'morality', 'religion', 'spirituality', 'theology', 'art', 'drama', 'poetry', 'fiction', 'nonfiction', 'biography', 'autobiography', 'memoir', 'journalism', 'media', 'communication', 'composition', 'language', 'dialect', 'slang', 'colloquialism', 'idiom', 'proverb', 'metaphor', 'simile', 'analogy', 'allegory', 'symbolism', 'motif', 'theme', 'narrative', 'plot', 'characterization', 'dialogue', 'monologue', 'soliloquy', 'exposition', 'climax', 'resolution', 'denouement', 'conflict', 'protagonist', 'antagonist', 'setting', 'atmosphere', 'tone', 'mood', 'purpose', 'audience', 'genre', 'subgenre', 'convention', 'tradition', 'innovation', 'influence', 'intertextuality', 'allusion', 'homage', 'parody', 'satire', 'irony', 'sarcasm', 'wit', 'humor', 'comedy', 'tragedy', 'tragicomedy', 'romance', 'epic', 'lyric', 'didactic', 'medieval', 'renaissance', 'baroque', 'neoclassical', 'romantic', 'realistic', 'naturalistic', 'modernist', 'postmodernist', 'contemporary', 'clinical',
            ],
            'whitelist' => [
                'anal', 'sex', 'sexual', 'sexuality', 'intercourse', 'reproduction', 'penis', 'vagina', 'breast', 'rectum', 'testicle', 'ovary', 'uterus', 'menstruation', 'ejaculation', 'erection', 'climax', 'orgasm', 'sperm', 'egg', 'zygote', 'embryo', 'fetus', 'conception', 'fertilization', 'gestation', 'birth', 'puberty', 'adolescence', 'adulthood', 'homosexual', 'heterosexual', 'bisexual', 'transgender', 'gender', 'identity', 'orientation', 'preference', 'attraction', 'dyke', 'queer', 'gay', 'lesbian', 'mating', 'copulation', 'coitus', 'breeding', 'procreation', 'promiscuity', 'libido', 'hormones', 'testosterone', 'estrogen', 'progesterone', 'circumcision', 'contraception', 'sterilization', 'infertility', 'impotence', 'dysfunction', 'stds', 'sti', 'hiv', 'aids', 'condom', 'diaphragm', 'pill', 'iud', 'abstinence', 'celibacy', 'virginity', 'purity', 'chastity', 'monogamy', 'polygamy', 'polyamory', 'pornography', 'erotica', 'prostitution', 'brothel', 'harem', 'concubine', 'mistress', 'adultery', 'fornication', 'sodomy', 'incest', 'pedophilia', 'rape', 'molestation', 'assault', 'harassment', 'victim', 'trauma', 'consent', 'ethics', 'morality', 'class', 'assignment',
            ],
        ],
        'technical' => [
            'markers' => [
                'research', 'analysis', 'scientific', 'biological', 'linguistics', 'paper', 'explain', 'explanation', 'definition', 'define', 'analyze', 'examine', 'theory', 'concept', 'science', 'experiment', 'laboratory', 'biology', 'publication', 'article', 'investigation', 'conference', 'symposium', 'workshop', 'hypothesis', 'methodology', 'data', 'evidence', 'findings', 'results', 'conclusion', 'abstract', 'introduction', 'review', 'background', 'method', 'assessment', 'evaluation', 'examination', 'inquiry', 'exploration', 'survey', 'questionnaire', 'observation', 'experiment', 'field', 'work', 'empirical', 'theoretical', 'conceptual', 'analytical', 'qualitative', 'quantitative', 'statistical', 'mathematical', 'logical', 'reasoning', 'inference', 'deduction', 'induction', 'articulation', 'vocabulary', 'terminology', 'lexicon', 'glossary', 'definition', 'etymology', 'semantics', 'syntax', 'grammar', 'orthography', 'phonology', 'morphology', 'epistemology', 'ontology', 'physics', 'chemistry', 'zoology', 'botany', 'ecology', 'geology', 'astronomy', 'cognitive', 'behavioral', 'forensic', 'mathematical', 'innovation', 'language', 'media', 'communication', 'jargon', 'reference',
            ],
            'whitelist' => [
                'screw','bang','stroke','execute','kill','suicide','master','slave','execution','abort','dummy','crack', 'bullet', 'shoot', 'injection', 'penetration', 'force', 'exploit', 'attack', 'dead', 'death', 'hardcore', 'hard', 'soft', 'naked', 'abuse', 'violation', 'hit', 'flush', 'dirty', 'hook', 'race', 'dump', 'hole', 'finger', 'pipe', 'socket', 'daemon', 'orphan', 'zombie', 'strip', 'exposed', 'binding', 'mount', 'unmount', 'anonymous', 'member', 'head', 'tail', 'sniff', 'native', 'deadlock', 'threaded', 'orphaned', 'hung', 'latency', 'throttle', 'bind', 'unbind', 'grind', 'patch', 'token', 'cookie', 'worm', 'virus', 'trojan', 'backdoor', 'flood', 'bounce', 'spam',
            ],
        ],
        'medical' => [
            'markers' => [
                'research', 'study', 'analysis', 'scientific', 'medical', 'biological', 'psychology', 'anthropology', 'definition', 'define', 'analyze', 'examine', 'theory', 'concept', 'science', 'experiment', 'laboratory', 'clinical', 'anatomy', 'physiology', 'biology', 'journal', 'publication', 'article', 'investigation', 'conference', 'symposium', 'workshop', 'hypothesis', 'methodology', 'data', 'evidence', 'findings', 'results', 'conclusion', 'abstract', 'introduction', 'review', 'background', 'method', 'assessment', 'evaluation', 'examination', 'inquiry', 'exploration', 'survey', 'interview', 'questionnaire', 'observation', 'experiment', 'case', 'study', 'field', 'work', 'empirical', 'theoretical', 'conceptual', 'analytical', 'qualitative', 'quantitative', 'statistical', 'physiology', 'medicine', 'psychiatry', 'psychology', 'neuroscience', 'cognitive', 'behavioral', 'developmental', 'clinical', 'social', 'personality', 'abnormal', 'physiological', 'comparative', 'evolutionary', 'forensic', 'ethics', 'morality', 'spirituality', 'jargon', 'lexicon', 'glossary', 'definition', 'etymology', 'ontology', 'metaphysics', 'philosophy', 'physics', 'chemistry', 'zoology', 'botany', 'ecology', 'anatomy',
            ],
            'whitelist' => [
                'anal', 'sex', 'sexual', 'sexuality', 'intercourse', 'reproduction', 'penis', 'vagina', 'breast', 'rectum', 'testicle', 'ovary', 'uterus', 'menstruation', 'ejaculation', 'erection', 'climax', 'orgasm', 'sperm', 'egg', 'zygote', 'embryo', 'fetus', 'conception', 'fertilization', 'gestation', 'birth', 'puberty', 'coitus', 'breeding', 'procreation', 'libido', 'hormones', 'testosterone', 'estrogen', 'progesterone', 'circumcision', 'contraception', 'sterilization', 'infertility', 'impotence', 'dysfunction', 'stds', 'sti', 'hiv', 'aids', 'condom', 'diaphragm', 'pill', 'iud', 'abstinence', 'celibacy', 'virginity', 'trauma',
            ],
        ],
        'legal' => [
            'markers' => [
                'research', 'study', 'analysis', 'history', 'historical', 'literature', 'political', 'psychology', 'sociology', 'paper', 'explain', 'explanation', 'definition', 'define', 'analyze', 'examine', 'discuss', 'theory', 'concept', 'experiment', 'clinical', 'journal', 'publication', 'article', 'investigation', 'conference', 'symposium', 'workshop', 'methodology', 'data', 'evidence', 'findings', 'results', 'conclusion', 'abstract', 'introduction', 'review', 'background', 'method', 'discussion', 'bibliography', 'reference', 'citation', 'quote', 'paraphrase', 'summary', 'argument', 'treatise', 'critique', 'criticism', 'assessment', 'evaluation', 'examination', 'inquiry', 'exploration', 'survey', 'interview', 'questionnaire', 'observation', 'case', 'work', 'empirical', 'theoretical', 'conceptual', 'analytical', 'statistical', 'logical', 'reasoning', 'inference', 'deduction', 'induction', 'syllogism', 'premise', 'claim', 'warrant', 'backing', 'rebuttal', 'counterargument', 'debate', 'discourse', 'dialectic', 'rhetoric', 'persuasion', 'eloquence', 'articulation', 'vocabulary', 'terminology', 'lexicon', 'glossary', 'definition', 'etymology', 'semantics', 'syntax', 'grammar', 'orthography', 'phonology', 'morphology', 'philology', 'epistemology', 'ontology', 'ethics', 'philosophy', 'psychiatry', 'forensic', 'civilization', 'culture', 'society', 'politics', 'government', 'economics', 'law', 'justice', 'rights', 'religion', 'theology', 'journalism', 'media', 'communication', 'language', 'dialect', 'jargon',
            ],
            'whitelist' => [
                'intercourse', 'conception', 'adulthood', 'homosexual', 'heterosexual', 'bisexual', 'transgender', 'gender', 'identity', 'orientation', 'circumcision', 'purity', 'chastity', 'polygamy', 'pornography', 'prostitution', 'brothel', 'concubine', 'mistress', 'adultery', 'fornication', 'sodomy', 'incest', 'pedophilia', 'rape', 'molestation', 'assault', 'harassment', 'victim', 'consent', 'ethics', 'morality',
            ],
        ],
        'quoted' => [
            'markers' => [
                'said', 'says', 'say', 'saying', 'quoted', 'quotes', 'quoting', 'according', 'claimed', 'claims', 'claiming', 'stated', 'states', 'stating', 'wrote', 'writes', 'writing', 'mentioned', 'mentions', 'mentioning', 'tweeted', 'tweets', 'tweeting', 'reported', 'reports', 'reporting', 'commented', 'comments', 'commenting', 'noted', 'notes', 'noting', 'expressed', 'expresses', 'expressing', 'testified', 'testifies', 'testifying', 'admitted', 'admits', 'admitting', 'confessed', 'confesses', 'confessing', 'declared', 'declares', 'declaring', 'announced', 'announces', 'announcing', 'explained', 'explains', 'explaining', 'added', 'adds', 'adding', 'replied', 'replies', 'replying', 'answered', 'answers', 'answering', 'responded', 'responds', 'responding', 'shouted', 'shouts', 'shouting', 'yelled', 'yells', 'yelling', 'screamed', 'screams', 'screaming', 'whispered', 'whispers', 'whispering', 'called', 'calls', 'calling', 'texted', 'texts', 'texting', 'emailed', 'emails', 'emailing', 'posted', 'posts', 'posting', 'published', 'publishes', 'publishing', 'told', 'tells', 'telling', 'asked', 'asks', 'asking', 'questioned', 'questions', 'questioning', 'inquired', 'inquires', 'inquiring', 'discussed', 'discusses', 'discussing', 'argued', 'argues', 'arguing', 'debated', 'debates', 'debating', 'disputed', 'disputes', 'disputing', 'alleged', 'alleges', 'alleging', 'asserted', 'asserts', 'asserting', 'maintained', 'maintains', 'maintaining', 'insisted', 'insists', 'insisting', 'suggested', 'suggests', 'suggesting', 'implied', 'implies', 'implying', 'indicated', 'indicates', 'indicating', 'signaled', 'signals', 'signaling', 'hinted', 'hints', 'hinting', 'alluded', 'alludes', 'alluding', 'referred', 'refers', 'referring', 'cited', 'cites', 'citing', 'paraphrased', 'paraphrases', 'paraphrasing', 'summarized', 'summarizes', 'summarizing', 'recounted', 'recounts', 'recounting', 'related', 'relates', 'relating', 'described', 'describes', 'describing', 'narrated', 'narrates', 'narrating', 'chronicled', 'chronicles', 'chronicling', 'documented', 'documents', 'documenting', 'recorded', 'records', 'recording', 'remarked', 'remarks', 'remarking', 'observed', 'observes', 'observing', 'noticed', 'notices', 'noticing', 'pointed', 'points', 'pointing', 'highlighted', 'highlights', 'highlighting', 'emphasized', 'emphasizes', 'emphasizing', 'stressed', 'stresses', 'stressing', 'underscored', 'underscores', 'underscoring', 'articulated', 'articulates', 'articulating', 'voiced', 'voices', 'voicing', 'uttered', 'utters', 'uttering', 'pronounced', 'pronounces', 'pronouncing', 'verbalized', 'verbalizes', 'verbalizing', 'phrased', 'phrases', 'phrasing', 'worded', 'words', 'wording', 'formulated', 'formulates', 'formulating', 'communicated', 'communicates', 'communicating', 'conveyed', 'conveys', 'conveying', 'relayed', 'relays', 'relaying', 'transmitted', 'transmits', 'transmitting', 'disseminated', 'disseminates', 'disseminating', 'broadcast', 'broadcasts', 'broadcasting',
            ],
            'whitelist' => [
                'bullshit',
            ],
        ],
    ],
    'patterns' => [
        'word_specific' => [
            'ass' => [
                '/\b(donkey|burro|mule).*\bass\b/i',
                '/\b(jack|smart|dumb|bad|lazy|silly|stupid|wise|lame|poor|pompous|pain in the|kick|ride|haul|bust|save|cover|crazy|wild|bad|stubborn)(?:\s+|\-)(ass)\b/i',
                '/\bass(et|ignment|ociation|embly|essment|istant|ume|ert|ess|ume|uage|ay|ault|ent|orted|imilate|ist|ociate|ure)/i',
                '/\b(class|glass|brass|pass|mass|sass|bass|grass|lass|compass)/i',
                '/\b(assassin|assault|assay|assent|assert|assess|asset|assign|assimilate|assist|associate|assure|assortment)\b/i',
            ],
            'cock' => [
                '/\b(pea|wea|ban|han|shu|hi|game|tur|wood|weather|stop|hay|shuttle)cock\b/i',
                '/\bcock(pit|tail|roach|le|ed|fight|up|sure|crow|y|screw|atoo|atiel|ade|er)\b/i',
                '/\b(hay|pea|pop|shut|stop)cock\b/i',
                '/\b(cockatoo|cockatiel|cockerel|cockroach|cockpit|cocktail|cockney|cockamamie|cocksure)\b/i',
            ],
            'dick' => [
                '/\b(moby|harry|philip|private|detective|spotted|speckled|great spotted|lesser spotted) dick\b/i',
                '/\bdick(ens|ensian|inson|inson\'s)\b/i',
                '/\b(dick)tionary\b/i',
                '/\b(dick)tation\b/i',
                '/\b(moby|ahab|melville|ishmael|queequeg).*\bdick\b/i',
                '/\bdick (tracy|francis|van dyke|cavett|cheney|clark|durbin|wolf|york|button|powell|smothers|morris)\b/i',
                '/\bdetective dick\b/i',
                '/\bprivate dick\b/i',
            ],
            'pussy' => [
                '/\b(cat|kitten|feline|pet|domestic|house|stray|alley|tomcat|siamese|persian|maine coon|tabby|calico).*\bpussy\b/i',
                '/\b(pussy)(cat|willow|foot|toe|footer)\b/i',
                '/\b(scaredy|scared|fraidy)[\s-]cat\b/i',
            ],
            'bitch' => [
                '/\b(female|breeding|show|hunting) (dog|canine|hound|terrier|retriever|shepherd|collie).*\bbitch\b/i',
                '/\b(dog|canine|puppy|kennel|breed|breeding).*\bbitch\b/i',
                '/\b(bitch) (puppy|pup|wolf|fox)\b/i',
                '/\b(dog|puppy|wolf|fox) (bitch)\b/i',
                '/\b(breeding|whelping).*\bbitch\b/i',
            ],
            'cunt' => [
                '/\b(chaucer|canterbury|medieval literature|middle english|old english).*\bcunt\b/i',
                '/\b(etymology|linguistic history|historical terms).*\bcunt\b/i',
            ],
            'shit' => [
                '/\b(bull|horse|cow|dog|cat|bat|bird|owl|chicken).*\bshit\b/i',
                '/\b(fertilizer|manure|excrement|feces|stool|droppings|waste|compost).*\bshit\b/i',
                '/\b(archaeology|fossil|coprolite).*\bshit\b/i',
            ],
            'fuck' => [
                '/\b(etymology|linguistic|historical slang|taboo language|expletive|profanity research).*\bfuck\b/i',
                '/\b(sociolinguistics|language taboos|forbidden vocabulary).*\bfuck\b/i',
            ],
            'damn' => [
                '/\b(dam|dammed|damming).*\bwater\b/i',
                '/\b(hoover|beaver|hydro|hydroelectric).*\bdam\b/i',
                '/\b(god|hell|eternal|divine).*\b(damn(ation)?|damned)\b/i',
                '/\b(judge|judgment|court|legal|sentence).*\b(damn|damned|damnation)\b/i',
            ],
            'whore' => [
                '/\b(historical|ancient|biblical|literary|medieval|renaissance).*\bwhore\b/i',
                '/\b(magdalene|jezebel|delilah|biblical figure).*\bwhore\b/i',
                '/\b(shakespeare|dickens|literature|character).*\bwhore\b/i',
                '/\b(study|research|paper|analysis|book|article).*\bprostitution\b.*\bwhore\b/i',
            ],
            'bastard' => [
                '/\b(illegitimate|child|son|birth|born out of wedlock|inheritance|legal).*\bbastard\b/i',
                '/\b(royal|noble|medieval|historical|lineage|succession).*\bbastard\b/i',
                '/\b(jon snow|game of thrones|william the conqueror).*\bbastard\b/i',
                '/\b(metallurgy|steel|sword|knife|blade).*\bbastard\b/i',
                '/\b(bastard) (file|sword|amber|title|operator|pop|force|halibut|toadflax)\b/i',
            ],
            'nigger' => [
                '/\b(historical|racism|civil rights|literature|huckleberry finn|mark twain|to kill a mockingbird|harper lee|racist language|slur|historical language).*\bnigger\b/i',
                '/\b(study|research|paper|analysis|book|article|racism|discrimination).*\bnigger\b/i',
            ],
            'fag' => [
                '/\b(british|uk|england|english|cigarette).*\bfag\b/i',
                '/\b(slang|historical|homosexuality|gay rights|homophobia|slur|pejorative).*\bfag\b/i',
                '/\b(fagging|public school|boarding school|british tradition).*\bfag\b/i',
            ],
            'blowjob' => [
                '/\b(sexual health|medical|clinical|study|research|paper|analysis).*\bblowjob\b/i',
                '/\b(oral sex|fellatio|sexual activity|human sexuality).*\bblowjob\b/i',
            ],
            'sex' => [
                '/\b(gender|male|female|biological|chromosomal|genetic).*\bsex\b/i',
                '/\b(sexual reproduction|sexual selection|sexual dimorphism).*\bsex\b/i',
                '/\b(study|research|paper|analysis|book|article).*\bsex\b/i',
                '/\b(sex) (education|determination|ratio|linked|change|chromosome|organ|cell|hormone|characteristic|difference|discrimination)\b/i',
            ],
        ],
    ],
    'rules' => [
        Ninja\Sentinel\Language\Rules\En\AdverbRule::class,
        Ninja\Sentinel\Language\Rules\En\AffixRule::class,
        Ninja\Sentinel\Language\Rules\En\PluralizeRule::class,
    ],
];
