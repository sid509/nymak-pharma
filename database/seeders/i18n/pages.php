<?php

/**
 * Baseline FR/ES translations for PageContent slots.
 *
 * Key format: "<page>.<slot>". Values: ['fr' => …, 'es' => …].
 * JSON slots carry nested arrays — the seeder json_encodes them into
 * i18n.<locale>.value so PageContent::for() resolves them like English.
 * {placeholders} must be preserved verbatim.
 */
return [
    // ── home ─────────────────────────────────────────────────────────
    'home.hero_badge' => [
        'fr' => 'Certifié WHO-GMP · Star Export House',
        'es' => 'Certificado WHO-GMP · Star Export House',
    ],
    'home.hero_title' => [
        'fr' => 'Plus de 25 ans de lifecare axée sur l’efficacité',
        'es' => 'Más de 25 años de lifecare orientada a la eficacia',
    ],
    'home.hero_subtitle' => [
        'fr' => 'Votre partenaire fiable en solutions de lifecare efficaces — présent dans 24 pays et ce n’est que le début. Fabricant pharmaceutique certifié WHO-GMP et Star Export House fournissant des solutés IV, des formes finies, des dispositifs médicaux, des tests de diagnostic rapide et des vaccins.',
        'es' => 'Su socio fiable en soluciones de lifecare eficaces — presente en 24 países y en crecimiento. Fabricante farmacéutico certificado WHO-GMP y Star Export House que suministra fluidos IV, formas farmacéuticas terminadas, dispositivos médicos, pruebas de diagnóstico rápido y vacunas.',
    ],
    'home.hero_primary_label' => ['fr' => 'Découvrir nos produits', 'es' => 'Explorar nuestros productos'],
    'home.hero_secondary_label' => ['fr' => 'Devenir partenaire', 'es' => 'Asóciese con nosotros'],
    'home.stats_years_label' => ['fr' => 'Années de lifecare', 'es' => 'Años de lifecare'],
    'home.stats_countries_label' => ['fr' => 'Pays d’exportation', 'es' => 'Países de exportación'],
    'home.stats_containers_label' => ['fr' => 'Conteneurs par exercice', 'es' => 'Contenedores por ejercicio'],
    'home.stats_products_label' => ['fr' => 'Produits au catalogue', 'es' => 'Productos en cartera'],
    'home.about_eyebrow' => ['fr' => 'À propos de Nymak Pharma', 'es' => 'Acerca de Nymak Pharma'],
    'home.about_title' => [
        'fr' => 'Un fabricant pharmaceutique indien exportateur depuis 1998',
        'es' => 'Un fabricante farmacéutico indio exportador desde 1998',
    ],
    'home.about_p1' => [
        'fr' => 'Fondée en 1998 sous la direction de M. Ranjit Advani, Nymak Pharma a débuté avec de l’eau stérilisée pour préparations injectables BP en ampoules plastiques, au service du Pacifique Sud. De ces débuts, nous avons grandi vers le Honduras, puis le Nigeria en 2000 — une étape qui a fait progresser nos exportations de 25 % et ouvert notre expansion à travers l’Afrique.',
        'es' => 'Fundada en 1998 bajo la dirección del Sr. Ranjit Advani, Nymak Pharma comenzó con agua esterilizada para preparaciones inyectables BP en ampollas de plástico, sirviendo al Pacífico Sur. De esos inicios crecimos hacia Honduras y luego Nigeria en 2000 — un hito que elevó las exportaciones un 25 % y abrió nuestra expansión por África.',
    ],
    'home.about_p2' => [
        'fr' => 'Aujourd’hui, nous opérons depuis un site certifié WHO-GMP à Mundra, Gujarat, soutenus par des équipes internes de réglementaire, de laboratoire, de CQ/QA et de design — et reconnus comme Star Export House certifiée par le gouvernement indien.',
        'es' => 'Hoy operamos desde una planta certificada WHO-GMP en Mundra, Gujarat, respaldados por equipos internos de asuntos regulatorios, laboratorio, CQ/QA y diseño — y reconocidos como Star Export House certificada por el Gobierno de la India.',
    ],
    'home.about_cta_label' => ['fr' => 'Notre histoire', 'es' => 'Nuestra historia'],
    'home.about_cta2_label' => ['fr' => 'Voir notre site', 'es' => 'Ver nuestra planta'],
    'home.about_badge_caption' => ['fr' => 'Mundra, Gujarat, Inde', 'es' => 'Mundra, Gujarat, India'],
    'home.portfolio_eyebrow' => ['fr' => 'Notre portefeuille', 'es' => 'Nuestra cartera'],
    'home.portfolio_title' => [
        'fr' => 'Cinq segments de produits, une seule exigence de qualité',
        'es' => 'Cinco segmentos de producto, un mismo estándar de calidad',
    ],
    'home.portfolio_lead' => [
        'fr' => 'Un portefeuille pharmaceutique d’exportation conçu pour les hôpitaux, les distributeurs, les ONG et les programmes de santé publique.',
        'es' => 'Una cartera farmacéutica de exportación pensada para hospitales, distribuidores, ONG y programas de salud pública.',
    ],
    'home.portfolio_card_label' => ['fr' => 'Explorer la catégorie', 'es' => 'Explorar la categoría'],
    'home.portfolio_cta_label' => ['fr' => 'Toutes les catégories', 'es' => 'Todas las categorías'],
    'home.brands_eyebrow' => ['fr' => 'Marques commercialisées', 'es' => 'Marcas comercializadas'],
    'home.brands_title' => ['fr' => 'La gamme de marque Nymak', 'es' => 'La gama de marca Nymak'],
    'home.brands_lead' => [
        'fr' => 'Des marques déposées distribuées sur les marchés d’Afrique de l’Ouest — chacune fabriquée dans des conditions WHO-GMP.',
        'es' => 'Marcas registradas suministradas en mercados de África Occidental — cada una fabricada bajo condiciones WHO-GMP.',
    ],
    'home.quality_eyebrow' => ['fr' => 'Qualité & conformité', 'es' => 'Calidad y cumplimiento'],
    'home.quality_title' => [
        'fr' => 'Certifiés pour les marchés qui exigent des preuves',
        'es' => 'Certificados para los mercados que exigen pruebas',
    ],
    'home.quality_body' => [
        'fr' => 'Chaque lot est analysé par notre laboratoire de CQ interne et libéré après revue AQ. Chaque distinction reflète notre engagement profond envers la qualité, l’intégrité et l’excellence en santé mondiale — la confiance de nos partenaires, la sécurité de nos produits et les vies que nous nous efforçons d’améliorer.',
        'es' => 'Cada lote es analizado por nuestro laboratorio de CQ interno y liberado tras la revisión de CG. Cada reconocimiento refleja nuestro compromiso profundo con la calidad, la integridad y la excelencia en salud global — la confianza de nuestros socios, la seguridad de nuestros productos y las vidas que nos esforzamos por mejorar.',
    ],
    'home.quality_cta_label' => ['fr' => 'Toutes les certifications', 'es' => 'Todas las certificaciones'],
    'home.global_eyebrow' => ['fr' => 'Présence mondiale', 'es' => 'Presencia global'],
    'home.global_title' => [
        'fr' => 'De Mundra à plus de 24 marchés',
        'es' => 'De Mundra a más de 24 mercados',
    ],
    'home.global_body' => [
        'fr' => 'Présents en Afrique de l’Ouest, centrale et de l’Est, en Amérique centrale et dans le Pacifique Sud — avec des bureaux au Royaume-Uni, en Sierra Leone et au Liberia, et des produits comme Alumak, Cefmak et Cipromak enregistrés dans le cadre de partenariats locaux.',
        'es' => 'Operando en África Occidental, Central y Oriental, América Central y el Pacífico Sur — con oficinas en el Reino Unido, Sierra Leona y Liberia, y productos como Alumak, Cefmak y Cipromak registrados mediante asociaciones locales.',
    ],
    'home.global_cta_label' => ['fr' => 'Explorer nos marchés', 'es' => 'Explorar nuestros mercados'],
    'home.global_more_label' => ['fr' => '+ autres marchés', 'es' => '+ más mercados'],
    'home.testimonials_eyebrow' => ['fr' => 'Avis de partenaires', 'es' => 'Opiniones de socios'],
    'home.testimonials_title' => ['fr' => 'Ce que disent nos clients', 'es' => 'Lo que dicen nuestros clientes'],
    'home.clients_lead' => [
        'fr' => 'La confiance de partenaires pharmaceutiques sur tous nos marchés',
        'es' => 'La confianza de socios farmacéuticos en todos los mercados',
    ],
    'home.faq_eyebrow' => ['fr' => 'FAQ', 'es' => 'Preguntas frecuentes'],
    'home.faq_title' => ['fr' => 'Les questions de nos partenaires', 'es' => 'Las preguntas de nuestros socios'],
    'home.faq_lead' => [
        'fr' => 'Des réponses directes sur qui nous sommes, ce que nous fabriquons et comment nous exportons.',
        'es' => 'Respuestas directas sobre quiénes somos, qué fabricamos y cómo exportamos.',
    ],
    'home.faq_cta_label' => ['fr' => 'Toutes les FAQ', 'es' => 'Todas las preguntas'],
    'home.journal_eyebrow' => ['fr' => 'Perspectives', 'es' => 'Perspectivas'],
    'home.journal_title' => ['fr' => 'Le journal Nymak', 'es' => 'El diario de Nymak'],
    'home.journal_cta_label' => ['fr' => 'Tous les articles', 'es' => 'Todos los artículos'],
    'home.cta_title' => [
        'fr' => 'Un besoin à exprimer ? Parlons-en.',
        'es' => '¿Tiene un requerimiento? Hablemos.',
    ],
    'home.cta_body' => [
        'fr' => 'Demandes de produits, partenariats de distribution, appels d’offres et support d’enregistrement — notre équipe export répond à chaque demande.',
        'es' => 'Consultas de producto, alianzas de distribución, licitaciones y soporte de registro — nuestro equipo de exportación responde a cada solicitud.',
    ],
    'home.cta_primary_label' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'home.cta_whatsapp_label' => ['fr' => 'WhatsApp', 'es' => 'WhatsApp'],

    // ── about ────────────────────────────────────────────────────────
    'about.hero_eyebrow' => ['fr' => 'À propos', 'es' => 'Acerca de'],
    'about.hero_title' => [
        'fr' => 'Plus de 25 ans de lifecare axée sur l’efficacité',
        'es' => 'Más de 25 años de lifecare orientada a la eficacia',
    ],
    'about.hero_lead' => [
        'fr' => 'D’un seul injectable destiné au Pacifique Sud à une Star Export House fournissant plus de 24 pays — l’histoire de Nymak Pharma est celle d’une qualité qui se cumule.',
        'es' => 'De un solo inyectable para el Pacífico Sur a una Star Export House que abastece más de 24 países — la historia de Nymak Pharma es una historia de calidad acumulada.',
    ],
    'about.overview_title' => ['fr' => 'Présentation de l’entreprise', 'es' => 'Resumen de la empresa'],
    'about.overview_p1' => [
        'fr' => 'Fondée en 1998 sous la direction visionnaire de M. Ranjit Advani, Nymak Pharma a entrepris son parcours en produisant de l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml. Nos débuts furent modestes — nos premiers clients se trouvaient dans le Pacifique Sud, où nous avons affirmé notre engagement envers la qualité, le service et l’efficacité, sans jamais oublier que derrière chaque produit se trouve une personne dans le besoin.',
        'es' => 'Fundada en 1998 bajo el liderazgo visionario del Sr. Ranjit Advani, Nymak Pharma emprendió su camino produciendo agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml. Nuestros inicios fueron humildes — nuestros primeros clientes estaban en el Pacífico Sur, donde consolidamos nuestra dedicación a la calidad, el servicio y la eficacia, recordando siempre que detrás de cada producto hay una persona que lo necesita.',
    ],
    'about.overview_p2' => [
        'fr' => 'À mesure que notre expertise grandissait, notre portée aussi — plusieurs marchés insulaires du Pacifique Sud, puis le Honduras en Amérique centrale. Anticipant l’évolution des besoins, nous nous sommes diversifiés vers une large gamme de produits pharmaceutiques et de dispositifs médicaux conçus pour les défis de santé des communautés que nous servons.',
        'es' => 'A medida que florecía nuestra experiencia, también lo hacía nuestro alcance — varios mercados insulares del Pacífico Sur y luego Honduras en América Central. Anticipando las necesidades cambiantes, nos diversificamos hacia una amplia gama de productos farmacéuticos y dispositivos médicos pensados para los retos sanitarios de las comunidades que servimos.',
    ],
    'about.overview_p3' => [
        'fr' => 'Aujourd’hui, avec plus de 25 ans d’excellence en lifecare, Nymak Pharma est présente dans plus de 24 pays et a exporté plus de 200 conteneurs au cours de l’exercice 2023–24. Star Export House certifiée par le gouvernement indien, notre infrastructure comprend une équipe réglementaire interne, un laboratoire de contrôle qualité, un entrepôt dédié et des équipes CQ/QA et design passionnées — toutes dévouées aux plus hauts standards de soin et d’excellence.',
        'es' => 'Hoy, con más de 25 años de excelencia en lifecare, Nymak Pharma mantiene presencia en más de 24 países y exportó más de 200 contenedores en el ejercicio 2023–24. Como Star Export House certificada por el Gobierno de la India, nuestra infraestructura incluye un equipo regulatorio interno, un laboratorio de control de calidad, un almacén dedicado y equipos de CQ/QA y diseño comprometidos — todos dedicados a los más altos estándares de cuidado y excelencia.',
    ],
    'about.capabilities' => [
        'fr' => [
            ['icon' => 'FlaskConical', 'title' => 'Laboratoire CQ interne', 'text' => 'Les lots sont analysés par le contrôle qualité avant libération.'],
            ['icon' => 'PackageCheck', 'title' => 'Supervision AQ', 'text' => 'Une fonction assurance qualité dédiée examine et approuve chaque libération.'],
            ['icon' => 'Award', 'title' => 'Équipe réglementaire', 'text' => 'Préparation des dossiers et support d’enregistrement pour les marchés de destination.'],
        ],
        'es' => [
            ['icon' => 'FlaskConical', 'title' => 'Laboratorio de CQ interno', 'text' => 'Los lotes son analizados por control de calidad antes de su liberación.'],
            ['icon' => 'PackageCheck', 'title' => 'Supervisión de CG', 'text' => 'Una función de garantía de calidad dedicada revisa y aprueba cada liberación.'],
            ['icon' => 'Award', 'title' => 'Equipo regulatorio', 'text' => 'Preparación de dossiers y soporte de registro para los mercados de destino.'],
        ],
    ],
    'about.story_eyebrow' => ['fr' => 'Notre histoire', 'es' => 'Nuestra historia'],
    'about.story_title' => [
        'fr' => 'Tout a commencé à un seul bureau en 1998',
        'es' => 'Comenzó en un solo escritorio en 1998',
    ],
    'about.story_p1' => [
        'fr' => 'Nymak Pharma a commencé à un seul bureau en 1998. M. Ranjit Advani — pharmacien, entrepreneur et notre fondateur — est parti d’une conviction simple : des médicaments fiables doivent atteindre les communautés qui en ont le plus besoin, où qu’elles soient.',
        'es' => 'Nymak Pharma comenzó en un solo escritorio en 1998. El Sr. Ranjit Advani — farmacéutico, empresario y nuestro fundador — partió de una convicción sencilla: los medicamentos fiables deben llegar a las comunidades que más los necesitan, estén donde estén.',
    ],
    'about.story_p2' => [
        'fr' => 'Le premier produit fut l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml. Les premiers clients étaient dans le Pacifique Sud — hôpitaux et pharmacies à des milliers de kilomètres du fabricant le plus proche. Chaque envoi portait le même principe : derrière chaque produit, une personne dans le besoin.',
        'es' => 'El primer producto fue agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml. Los primeros clientes estaban en el Pacífico Sur — hospitales y farmacias a miles de kilómetros del fabricante más cercano. Cada envío llevaba el mismo principio: detrás de cada producto hay una persona que lo necesita.',
    ],
    'about.story_p3' => [
        'fr' => 'Les premières photographies le disent mieux que nous — le premier bureau, les premiers cartons étiquetés à destination de Lae, les premiers conteneurs vers le port. Vingt-cinq ans plus tard, ce bureau est devenu un site WHO-GMP servant plus de 24 pays. La conviction, elle, n’a pas changé.',
        'es' => 'Las primeras fotografías lo cuentan mejor que nadie — la primera oficina, los primeros cartones etiquetados con destino a Lae, los primeros contenedores rumbo al puerto. Veinticinco años después, ese escritorio se ha convertido en una planta WHO-GMP que sirve a más de 24 países. La convicción no ha cambiado.',
    ],
    'about.story_image_caption' => [
        'fr' => 'M. Ranjit Advani dans le premier bureau de Nymak, c. 1998',
        'es' => 'El Sr. Ranjit Advani en la primera oficina de Nymak, c. 1998',
    ],
    'about.story_badge_label' => ['fr' => 'Années de lifecare', 'es' => 'Años de lifecare'],
    'about.story_archive_1_caption' => [
        'fr' => 'Envoi à destination de Lae, Papouasie-Nouvelle-Guinée',
        'es' => 'Envío con destino a Lae, Papúa Nueva Guinea',
    ],
    'about.story_archive_2_caption' => [
        'fr' => 'Premier départ de conteneur vers le port',
        'es' => 'Primer despacho de contenedor al puerto',
    ],
    'about.story_signature_role' => ['fr' => 'Fondateur & mentor', 'es' => 'Fundador y mentor'],
    'about.journey_eyebrow' => ['fr' => 'Notre parcours', 'es' => 'Nuestro recorrido'],
    'about.journey_title' => ['fr' => 'Les étapes qui ont forgé Nymak', 'es' => 'Los hitos que forjaron a Nymak'],
    'about.timeline' => [
        'fr' => [
            ['year' => '1998', 'title' => 'Fondation au Gujarat', 'text' => 'M. Ranjit Advani crée Nymak Pharma, débutant avec de l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml pour les marchés du Pacifique Sud.'],
            ['year' => '2000', 'title' => 'L’étape du Nigeria', 'text' => 'L’entrée sur le marché nigérian fait progresser les ventes à l’export de 25 % et ouvre une expansion plus large à travers le continent africain.'],
            ['year' => 'Années 2000', 'title' => 'Diversification du portefeuille', 'text' => 'De l’eau pour injectables, la gamme s’étend aux produits pharmaceutiques, solutés IV, dispositifs médicaux et consommables pour l’export.'],
            ['year' => 'Aujourd’hui', 'title' => '24+ pays, 200+ conteneurs', 'text' => 'Star Export House certifiée par le gouvernement indien, opérant depuis un site WHO-GMP à Mundra, avec des bureaux au Royaume-Uni, en Sierra Leone et au Liberia.'],
        ],
        'es' => [
            ['year' => '1998', 'title' => 'Fundación en Gujarat', 'text' => 'El Sr. Ranjit Advani crea Nymak Pharma, comenzando con agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml para los mercados del Pacífico Sur.'],
            ['year' => '2000', 'title' => 'El hito de Nigeria', 'text' => 'La entrada en el mercado nigeriano eleva las ventas de exportación un 25 % y abre una expansión más amplia por el continente africano.'],
            ['year' => 'Década de 2000', 'title' => 'Diversificación de la cartera', 'text' => 'Del agua para inyectables, la gama crece hacia productos farmacéuticos, fluidos IV, dispositivos médicos y material desechable para exportación.'],
            ['year' => 'Hoy', 'title' => '24+ países, 200+ contenedores', 'text' => 'Star Export House certificada por el Gobierno de la India, operando desde una planta WHO-GMP en Mundra, con oficinas en el Reino Unido, Sierra Leona y Liberia.'],
        ],
    ],
    'about.values_eyebrow' => ['fr' => 'Ce qui nous guide', 'es' => 'Lo que nos guía'],
    'about.values_title' => ['fr' => 'Les valeurs derrière les produits', 'es' => 'Los valores detrás de los productos'],
    'about.values' => [
        'fr' => [
            ['icon' => 'ShieldCheck', 'title' => 'Efficacité', 'text' => 'Chaque produit doit tenir sa promesse. L’efficacité est le critère selon lequel nous formulons, fabriquons et libérons.'],
            ['icon' => 'HeartHandshake', 'title' => 'Le client d’abord', 'text' => 'Derrière chaque produit, une personne dans le besoin. Nous construisons pour le patient au bout de la chaîne et le partenaire qui passe commande.'],
            ['icon' => 'BadgeCheck', 'title' => 'Sincérité', 'text' => 'Des transactions transparentes, une documentation honnête, des certifications vérifiables. La confiance est notre véritable exportation.'],
        ],
        'es' => [
            ['icon' => 'ShieldCheck', 'title' => 'Eficacia', 'text' => 'Cada producto debe funcionar como se promete. La eficacia es el estándar con el que formulamos, fabricamos y liberamos.'],
            ['icon' => 'HeartHandshake', 'title' => 'El cliente primero', 'text' => 'Detrás de cada producto hay una persona que lo necesita. Construimos para el paciente al final de la cadena y para el socio que realiza el pedido.'],
            ['icon' => 'BadgeCheck', 'title' => 'Sinceridad', 'text' => 'Tratos transparentes, documentación honesta, certificaciones verificables. La confianza es nuestra verdadera exportación.'],
        ],
    ],
    'about.credentials_eyebrow' => ['fr' => 'Références', 'es' => 'Credenciales'],
    'about.credentials_title' => ['fr' => 'Vérifiées, pas seulement affirmées', 'es' => 'Verificadas, no solo declaradas'],
    'about.credentials_body' => [
        'fr' => 'Fabrication certifiée WHO-GMP, systèmes qualité ISO 13485:2016, reconnaissance Star Export House et adhésion à Pharmexcil — des références que régulateurs et partenaires peuvent vérifier.',
        'es' => 'Fabricación certificada WHO-GMP, sistemas de calidad ISO 13485:2016, reconocimiento Star Export House y membresía en Pharmexcil — credenciales que reguladores y socios pueden verificar.',
    ],

    // ── manufacturing ────────────────────────────────────────────────
    'manufacturing.hero_eyebrow' => ['fr' => 'Fabrication', 'es' => 'Fabricación'],
    'manufacturing.hero_title' => [
        'fr' => 'Un site WHO-GMP conçu pour l’export',
        'es' => 'Una planta WHO-GMP construida para exportar',
    ],
    'manufacturing.hero_lead' => [
        'fr' => 'Nymak Pharma fabrique au Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat — à quelques minutes de deux des ports d’exportation les plus actifs de l’Inde.',
        'es' => 'Nymak Pharma fabrica en Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat — a minutos de dos de los puertos de exportación más activos de la India.',
    ],
    'manufacturing.overview_title' => ['fr' => 'Fabriquer à Mundra', 'es' => 'Fabricación en Mundra'],
    'manufacturing.overview_p1' => [
        'fr' => 'Notre siège et notre usine se trouvent dans le Port Biz Industrial Park, sur l’axe Kandla–Mundra au Gujarat — un emplacement choisi délibérément pour son accès direct aux ports de Mundra et de Kandla, les portes par lesquelles plus de 200 conteneurs de produits Nymak ont été expédiés au cours de l’exercice 2023–24.',
        'es' => 'Nuestra sede y planta se encuentran en el Port Biz Industrial Park, en la carretera Kandla–Mundra de Gujarat — una ubicación elegida deliberadamente por su acceso directo a los puertos de Mundra y Kandla, las puertas por las que más de 200 contenedores de productos Nymak se embarcaron en el ejercicio 2023–24.',
    ],
    'manufacturing.overview_p2' => [
        'fr' => 'Le site opère sous certification WHO-GMP avec des systèmes de management de la qualité ISO 13485:2016. La production s’appuie sur une structure qui garde les fonctions critiques en interne : laboratoire de contrôle qualité, équipe assurance qualité, équipe réglementaire chargée des dossiers et enregistrements, équipe design pour des emballages conformes aux marchés, et une fonction logistique gérant entreposage et expédition.',
        'es' => 'La planta opera bajo certificación WHO-GMP con sistemas de gestión de calidad ISO 13485:2016. La producción se apoya en una estructura que mantiene las funciones críticas en casa: laboratorio de control de calidad, equipo de garantía de calidad, equipo de asuntos regulatorios para dossiers y registros, equipo de diseño para envases conformes a cada mercado y una función logística que gestiona almacenamiento y despacho.',
    ],
    'manufacturing.overview_p3' => [
        'fr' => 'Les inspections de nos clients racontent l’histoire mieux que nous — les partenaires qui visitent l’usine décrivent des machines et un stockage modernes, des processus bien maîtrisés selon les exigences GMP et une direction soucieuse de la qualité et attentive.',
        'es' => 'Las inspecciones de nuestros clientes cuentan la historia mejor que nosotros — los socios que visitan la planta describen maquinaria y almacenamiento modernos, procesos bien controlados según los requisitos GMP y una dirección consciente de la calidad y colaboradora.',
    ],
    'manufacturing.capabilities_eyebrow' => ['fr' => 'Capacités', 'es' => 'Capacidades'],
    'manufacturing.capabilities_title' => ['fr' => 'Ce qui fonctionne dans le site', 'es' => 'Lo que funciona dentro de la planta'],
    'manufacturing.capabilities_lead' => [
        'fr' => 'Qualité, réglementaire, design et logistique sous un même toit — un seul interlocuteur responsable pour nos partenaires.',
        'es' => 'Calidad, regulación, diseño y logística bajo un mismo techo — un solo equipo responsable para nuestros socios.',
    ],
    'manufacturing.capabilities' => [
        'fr' => [
            ['icon' => 'FlaskConical', 'title' => 'Laboratoire CQ interne', 'text' => 'Un laboratoire de contrôle qualité dédié analyse les lots avant libération — les partenaires qui auditent le site notent systématiquement des processus bien maîtrisés et un stockage moderne.'],
            ['icon' => 'ClipboardCheck', 'title' => 'Supervision assurance qualité', 'text' => 'Une fonction AQ distincte examine et approuve chaque lot avant son départ, garantissant la conformité de chaque envoi aux spécifications et à la documentation.'],
            ['icon' => 'FileCheck2', 'title' => 'Support réglementaire & dossiers', 'text' => 'Une équipe réglementaire interne prépare et gère les dossiers produits, soutenant les exigences d’enregistrement des marchés de destination en Afrique, en Amérique centrale et dans le Pacifique.'],
            ['icon' => 'Package', 'title' => 'Design & emballage', 'text' => 'Une équipe design interne produit des emballages et étiquetages conformes et prêts pour le marché — y compris les gammes de marque fournies en Afrique de l’Ouest.'],
            ['icon' => 'Warehouse', 'title' => 'Entreposage & logistique', 'text' => 'Infrastructure d’entrepôt dédiée avec stockage contrôlé, dirigée par un responsable logistique — plus de 200 conteneurs expédiés au cours de l’exercice 2023–24.'],
            ['icon' => 'Microscope', 'title' => 'Amélioration continue', 'text' => 'Le site fonctionne avec une attention documentée portée à l’innovation et à la mise à niveau des installations, vérifiée par les inspections et audits des clients.'],
        ],
        'es' => [
            ['icon' => 'FlaskConical', 'title' => 'Laboratorio de CQ interno', 'text' => 'Un laboratorio de control de calidad dedicado analiza los lotes antes de su liberación — los socios que auditan la planta señalan consistentemente procesos bien controlados y almacenamiento moderno.'],
            ['icon' => 'ClipboardCheck', 'title' => 'Supervisión de garantía de calidad', 'text' => 'Una función de CG independiente revisa y aprueba cada lote antes de que salga de la planta, asegurando que cada envío cumpla especificación y documentación.'],
            ['icon' => 'FileCheck2', 'title' => 'Soporte regulatorio y de dossiers', 'text' => 'Un equipo regulatorio interno prepara y gestiona los dossiers de producto, apoyando los requisitos de registro en mercados de África, América Central y el Pacífico.'],
            ['icon' => 'Package', 'title' => 'Diseño y empaque', 'text' => 'Un equipo de diseño interno produce empaques y etiquetado conformes y listos para el mercado — incluidas las gamas de marca suministradas en África Occidental.'],
            ['icon' => 'Warehouse', 'title' => 'Almacenamiento y logística', 'text' => 'Infraestructura de almacén dedicada con almacenamiento controlado, dirigida por un jefe de logística — más de 200 contenedores despachados en el ejercicio 2023–24.'],
            ['icon' => 'Microscope', 'title' => 'Mejora continua', 'text' => 'La planta opera con un enfoque documentado en innovación y actualización de las instalaciones, verificado mediante inspecciones y auditorías de clientes.'],
        ],
    ],
    'manufacturing.dosage_eyebrow' => ['fr' => 'Ce que nous fabriquons', 'es' => 'Lo que fabricamos'],
    'manufacturing.dosage_title' => ['fr' => 'Formes pharmaceutiques & gammes', 'es' => 'Formas farmacéuticas y líneas'],
    'manufacturing.dosage_forms' => [
        'fr' => [
            ['title' => 'Solutés IV & perfusions', 'text' => 'Parenteraux à grand volume — chlorure de sodium, glucose, lactate de Ringer, multi-électrolytes, perfusions thérapeutiques (100 ml–1000 ml).'],
            ['title' => 'Comprimés & gélules', 'text' => 'Y compris les présentations dispersibles, sublinguales, à libération prolongée et les associations.'],
            ['title' => 'Liquides oraux', 'text' => 'Sirops, suspensions et gouttes — formulations pédiatriques et adultes.'],
            ['title' => 'Injections', 'text' => 'Ampoules et flacons — solutions et poudres sèches pour reconstitution.'],
            ['title' => 'Dispositifs médicaux', 'text' => 'Accès IV, perfuseurs, seringues, aiguilles et consommables de soins.'],
            ['title' => 'Diagnostics & antisérums', 'text' => 'Tests rapides, antivenin polyvalent et antitoxine tétanique.'],
        ],
        'es' => [
            ['title' => 'Fluidos IV y perfusiones', 'text' => 'Parenterales de gran volumen — cloruro de sodio, glucosa, lactato de Ringer, multielectrolitos, perfusiones terapéuticas (100 ml–1000 ml).'],
            ['title' => 'Comprimidos y cápsulas', 'text' => 'Incluidas presentaciones dispersables, sublinguales, de liberación prolongada y combinaciones.'],
            ['title' => 'Líquidos orales', 'text' => 'Jarabes, suspensiones y gotas — formulaciones pediátricas y de adultos.'],
            ['title' => 'Inyecciones', 'text' => 'Ampollas y viales — soluciones y polvo seco para reconstitución.'],
            ['title' => 'Dispositivos médicos', 'text' => 'Acceso IV, equipos de infusión, jeringas, agujas y consumibles de cuidado del paciente.'],
            ['title' => 'Diagnóstico y antisueros', 'text' => 'Pruebas rápidas, antisuero antiofídico y antitoxina tetánica.'],
        ],
    ],

    // ── quality ──────────────────────────────────────────────────────
    'quality.hero_eyebrow' => ['fr' => 'Qualité & certifications', 'es' => 'Calidad y certificaciones'],
    'quality.hero_title' => [
        'fr' => 'Une qualité certifiée, une conformité vérifiable',
        'es' => 'Calidad certificada, cumplimiento verificable',
    ],
    'quality.hero_lead' => [
        'fr' => 'Chaque distinction reflète notre engagement envers la qualité, l’intégrité et les partenaires qui comptent sur nos produits — WHO-GMP, ISO 13485:2016, Star Export House et plus encore.',
        'es' => 'Cada reconocimiento refleja nuestro compromiso con la calidad, la integridad y los socios que confían en nuestros productos — WHO-GMP, ISO 13485:2016, Star Export House y más.',
    ],
    'quality.cred_eyebrow' => ['fr' => 'Références', 'es' => 'Credenciales'],
    'quality.cred_title' => ['fr' => 'Distinctions & certifications', 'es' => 'Premios y certificaciones'],
    'quality.cred_lead' => [
        'fr' => 'Chaque distinction et certification reflète notre engagement profond envers la qualité, l’intégrité et l’excellence en santé mondiale — la confiance de nos partenaires, la sécurité de nos produits et les vies que nous nous efforçons d’améliorer. Les certificats sont à la disposition des partenaires pour vérification lors des enregistrements et audits.',
        'es' => 'Cada reconocimiento y certificación refleja nuestro compromiso profundo con la calidad, la integridad y la excelencia en salud global — la confianza de nuestros socios, la seguridad de nuestros productos y las vidas que nos esforzamos por mejorar. Los certificados están disponibles para los socios durante registros y auditorías.',
    ],
    'quality.system_title' => ['fr' => 'Comment la qualité fonctionne ici', 'es' => 'Cómo funciona la calidad aquí'],
    'quality.system_p1' => [
        'fr' => 'Chez Nymak, la qualité n’est pas un département — c’est la séquence que traverse chaque produit. Les matières premières sont contrôlées à l’entrée, la production suit des processus GMP documentés, les lots sont analysés par le laboratoire CQ interne et une fonction AQ distincte examine chaque libération avant expédition.',
        'es' => 'En Nymak, la calidad no es un departamento — es la secuencia por la que pasa cada producto. Las materias primas se controlan a la entrada, la producción sigue procesos GMP documentados, los lotes son analizados por el laboratorio de CQ interno y una función de CG independiente revisa cada liberación antes del despacho.',
    ],
    'quality.system_p2' => [
        'fr' => 'Autour de la production s’organise la structure de support : une équipe réglementaire préparant les dossiers d’enregistrement pour les marchés de destination, une équipe design produisant des étiquetages conformes et des équipes d’entrepôt maintenant un stockage contrôlé jusqu’à l’expédition.',
        'es' => 'Alrededor de la producción se organiza la estructura de soporte: un equipo regulatorio que prepara dossiers para el registro en los mercados de destino, un equipo de diseño que produce etiquetado conforme y equipos de almacén que mantienen el almacenamiento controlado hasta el envío.',
    ],
    'quality.system_p3' => [
        'fr' => 'C’est ce que les partenaires vérifient lorsqu’ils nous auditent — et ce que les certifications WHO-GMP, ISO 13485 et Star Export House attestent de l’extérieur.',
        'es' => 'Esto es lo que los socios verifican cuando nos auditan — y lo que las credenciales WHO-GMP, ISO 13485 y Star Export House certifican desde fuera.',
    ],
    'quality.faq_title' => ['fr' => 'Questions qualité', 'es' => 'Preguntas de calidad'],

    // ── contact ──────────────────────────────────────────────────────
    'contact.hero_eyebrow' => ['fr' => 'Contact', 'es' => 'Contacto'],
    'contact.hero_title' => ['fr' => 'Parlons de votre marché', 'es' => 'Hablemos de su mercado'],
    'contact.hero_lead' => [
        'fr' => 'Distributeur, hôpital, ONG ou programme de santé — décrivez votre besoin et notre équipe export vous répondra.',
        'es' => 'Distribuidor, hospital, ONG o programa de salud — cuéntenos su requerimiento y nuestro equipo de exportación responderá.',
    ],
    'contact.form_title' => ['fr' => 'Envoyer une demande', 'es' => 'Enviar una consulta'],
    'contact.form_lead' => ['fr' => 'Les champs marqués * sont obligatoires.', 'es' => 'Los campos marcados * son obligatorios.'],

    // ── products ─────────────────────────────────────────────────────
    'products.index.hero_eyebrow' => ['fr' => 'Nos produits', 'es' => 'Nuestros productos'],
    'products.index.hero_title' => [
        'fr' => 'Un portefeuille pharmaceutique d’exportation conçu pour les besoins réels',
        'es' => 'Una cartera farmacéutica de exportación pensada para necesidades reales',
    ],
    'products.index.hero_lead' => [
        'fr' => 'Cinq segments, plus de 300 références, un même standard de fabrication. Chaque produit est expédié dans des conditions WHO-GMP avec un support d’enregistrement pour votre marché.',
        'es' => 'Cinco segmentos, más de 300 referencias, un mismo estándar de fabricación. Cada producto se envía bajo condiciones WHO-GMP con soporte de registro para su mercado.',
    ],
    'products.index.card_label' => ['fr' => 'Explorer la catégorie', 'es' => 'Explorar la categoría'],
    'products.index.cta_card_title' => ['fr' => 'Besoin de quelque chose de précis ?', 'es' => '¿Necesita algo específico?'],
    'products.index.cta_card_body' => [
        'fr' => 'Notre équipe réglementaire accompagne les présentations personnalisées, les conditionnements et les enregistrements spécifiques à chaque marché. Dites-nous ce dont votre marché a besoin.',
        'es' => 'Nuestro equipo regulatorio apoya presentaciones personalizadas, tamaños de envase y registros específicos de cada mercado. Cuéntenos qué necesita su mercado.',
    ],
    'products.index.cta_card_button' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'products.index.brands_eyebrow' => ['fr' => 'Portefeuille de marque', 'es' => 'Cartera de marca'],
    'products.index.brands_title' => ['fr' => 'Marques Nymak déposées sur le marché', 'es' => 'Marcas Nymak registradas en el mercado'],
    'products.index.brands_lead' => [
        'fr' => 'Des produits commercialisés sous les marques Nymak sur les marchés d’Afrique de l’Ouest — Alumak, Cefmak, Cipromak et autres.',
        'es' => 'Productos comercializados bajo marcas Nymak en mercados de África Occidental — Alumak, Cefmak, Cipromak y más.',
    ],
    'products.category.eyebrow' => ['fr' => 'Catégorie de produits', 'es' => 'Categoría de producto'],
    'products.category.siblings_title' => ['fr' => 'Catégories', 'es' => 'Categorías'],
    'products.category.siblings_all_label' => ['fr' => 'Tous les produits', 'es' => 'Todos los productos'],
    'products.category.range_eyebrow' => ['fr' => 'Dans cette catégorie', 'es' => 'En esta categoría'],
    'products.category.range_title' => ['fr' => 'Ce que couvre la gamme', 'es' => 'Lo que cubre la gama'],
    'products.category.range_lead' => [
        'fr' => 'La liste complète des produits avec dosages et conditionnements est à un clic.',
        'es' => 'La lista completa de productos con concentraciones y presentaciones está a un clic.',
    ],
    'products.category.catalogue_label' => ['fr' => 'Voir tous les produits {category}', 'es' => 'Ver todos los productos de {category}'],
    'products.category.cta_title' => ['fr' => 'Approvisionner {category} pour votre marché ?', 'es' => '¿Abastecer {category} para su mercado?'],
    'products.category.cta_body' => [
        'fr' => 'Nous accompagnons les dossiers d’enregistrement, les emballages spécifiques aux marchés et la logistique conteneur. Décrivez votre besoin et votre marché de destination.',
        'es' => 'Apoyamos dossiers de registro, empaque específico del mercado y logística de contenedores. Cuéntenos su requerimiento y mercado de destino.',
    ],
    'products.category.cta_button' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'products.catalogue.eyebrow' => ['fr' => 'Liste des produits', 'es' => 'Lista de productos'],
    'products.catalogue.title' => ['fr' => '{category} — liste complète', 'es' => '{category} — lista completa'],
    'products.catalogue.lead' => [
        'fr' => 'Chaque produit que nous fabriquons ou fournissons dans cette catégorie, avec dosages et conditionnements. Les noms accompagnés d’un lien ouvrent une fiche produit.',
        'es' => 'Cada producto que fabricamos o suministramos en esta categoría, con concentraciones y presentaciones. Los nombres con enlace abren una ficha de producto.',
    ],
    'products.catalogue.branded_title' => ['fr' => 'Gamme de marque Nymak', 'es' => 'Gama de marca Nymak'],
    'products.catalogue.search_label' => ['fr' => 'Rechercher dans cette liste ({count} produits)', 'es' => 'Buscar en esta lista ({count} productos)'],
    'products.catalogue.search_placeholder' => ['fr' => 'ex. ceftriaxone, perfusion, comprimés…', 'es' => 'ej. ceftriaxona, perfusión, comprimidos…'],
    'products.catalogue.empty_title' => ['fr' => 'Aucun produit ne correspond à « {query} ».', 'es' => 'Ningún producto coincide con «{query}».'],
    'products.catalogue.empty_body' => [
        'fr' => 'Essayez un nom générique ou une classe thérapeutique — ou demandez-nous directement.',
        'es' => 'Pruebe un nombre genérico o una clase terapéutica — o pregúntenos directamente.',
    ],
    'products.catalogue.back_label' => ['fr' => 'À propos de {category}', 'es' => 'Acerca de {category}'],
    'products.catalogue.cta_title' => ['fr' => 'Vous ne trouvez pas ce qu’il vous faut ?', 'es' => '¿No encuentra lo que necesita?'],
    'products.catalogue.cta_body' => [
        'fr' => 'Notre portefeuille va au-delà de cette liste. Envoyez-nous la molécule, le dosage et le marché de destination et nous confirmerons la disponibilité.',
        'es' => 'Nuestra cartera va más allá de esta lista. Envíenos la molécula, la concentración y el mercado de destino y confirmaremos la disponibilidad.',
    ],
    'products.catalogue.cta_button' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'products.show.standard_label' => ['fr' => 'Standard', 'es' => 'Estándar'],
    'products.show.standard_value' => ['fr' => 'Fabriqué dans des conditions WHO-GMP', 'es' => 'Fabricado bajo condiciones WHO-GMP'],
    'products.show.cta_button' => ['fr' => 'Nous contacter à propos de ce produit', 'es' => 'Contactarnos sobre este producto'],
    'products.show.back_label' => ['fr' => 'Retour à {category}', 'es' => 'Volver a {category}'],
    'products.show.related_title' => ['fr' => 'Produits associés', 'es' => 'Productos relacionados'],
    'products.show.support_title' => ['fr' => 'Support export & enregistrement', 'es' => 'Soporte de exportación y registro'],
    'products.show.support_body' => [
        'fr' => 'Notre équipe réglementaire accompagne les dossiers, l’étiquetage spécifique au marché et les exigences d’enregistrement. Indiquez-nous votre marché de destination.',
        'es' => 'Nuestro equipo regulatorio apoya dossiers, etiquetado específico del mercado y requisitos de registro. Indíquenos su mercado de destino.',
    ],
    'products.show.support_button' => ['fr' => 'Contacter l’équipe export', 'es' => 'Contactar al equipo de exportación'],

    // ── markets ──────────────────────────────────────────────────────
    'markets.index.hero_eyebrow' => ['fr' => 'Présence mondiale', 'es' => 'Presencia global'],
    'markets.index.hero_title' => [
        'fr' => 'Des produits de santé vers plus de 24 pays — et ce n’est pas fini',
        'es' => 'Productos de salud para más de 24 países — y seguimos creciendo',
    ],
    'markets.index.hero_lead' => [
        'fr' => 'Présents dans plus de 24 pays comme la Somalie, le Kenya, la RD Congo, le Nigeria et la Sierra Leone, nous apportons plus que des produits de santé — nous apportons de l’engagement. À chaque étape, notre engagement est clair : améliorer des vies en livrant des produits de qualité et efficaces, et laisser une empreinte positive partout où nous allons.',
        'es' => 'Operando en más de 24 países como Somalia, Kenia, RD Congo, Nigeria y Sierra Leona, aportamos más que productos de salud — aportamos dedicación. En cada paso, nuestro compromiso es claro: mejorar vidas entregando productos de calidad y eficaces, y dejar una huella positiva dondequiera que vayamos.',
    ],
    'markets.index.map_eyebrow' => ['fr' => 'Où nous travaillons', 'es' => 'Dónde trabajamos'],
    'markets.index.map_title' => ['fr' => 'Une ligne d’approvisionnement de Mundra au monde', 'es' => 'Una línea de suministro de Mundra al mundo'],
    'markets.index.map_lead' => [
        'fr' => 'Chaque arc sur le globe est une route d’approvisionnement active depuis notre site de Mundra. Faites tourner le globe, cliquez sur un pays en surbrillance — ou choisissez dans la liste — pour voir le travail, les produits et les équipes sur place.',
        'es' => 'Cada arco del globo es una ruta de suministro activa desde nuestra planta de Mundra. Arrastre para girar, haga clic en un país resaltado — o elija de la lista — para ver el trabajo, los productos y las personas sobre el terreno.',
    ],
    'markets.index.map_empty_title' => ['fr' => 'Faites tourner le globe — choisissez un pays', 'es' => 'Gire el globo — elija un país'],
    'markets.index.map_empty_body' => [
        'fr' => 'Les pays en surbrillance sont nos marchés d’exportation actuels. Sélectionnez-en un pour découvrir ce que nous y faisons et quels produits nous y fournissons.',
        'es' => 'Los países resaltados son nuestros mercados de exportación actuales. Seleccione uno para conocer qué hacemos allí y qué productos suministramos.',
    ],
    'markets.index.map_empty_cta' => ['fr' => 'Votre marché n’est pas listé ? Demandez-nous', 'es' => '¿Su mercado no aparece? Pregúntenos'],
    'markets.index.map_market_empty_title' => ['fr' => 'Nous servons {country} via des partenaires export', 'es' => 'Servimos {country} a través de socios exportadores'],
    'markets.index.map_market_empty_body' => [
        'fr' => 'Notre portefeuille pour {country} grandit avec la demande. Si vous y êtes distributeur, groupe hospitalier ou acheteur de programme, demandez-nous ce que nous fournissons actuellement et quels dossiers nous pouvons accompagner.',
        'es' => 'Nuestra cartera para {country} crece con la demanda. Si es distribuidor, grupo hospitalario o comprador de programas allí, pregunte qué suministramos actualmente y qué dossiers podemos apoyar.',
    ],
    'markets.index.map_market_cta' => ['fr' => 'Parler à notre équipe export', 'es' => 'Hablar con nuestro equipo de exportación'],
    'markets.index.footprint_eyebrow' => ['fr' => 'Empreinte export', 'es' => 'Huella de exportación'],
    'markets.index.footprint_title' => ['fr' => 'Chaque conteneur raconte une histoire', 'es' => 'Cada contenedor cuenta una historia'],
    'markets.index.footprint_body' => [
        'fr' => 'Plus de 200 conteneurs expédiés au cours de l’exercice 2023–24 vers plus de 24 pays répartis sur quatre régions — et le nombre continue de croître.',
        'es' => 'Más de 200 contenedores despachados en el ejercicio 2023–24 hacia más de 24 países en cuatro regiones — y la cifra sigue creciendo.',
    ],
    'markets.index.footprint_stats' => [
        'fr' => [
            ['value' => '24+', 'label' => 'Pays desservis'],
            ['value' => '200+', 'label' => 'Conteneurs en 2023–24'],
            ['value' => '4', 'label' => 'Régions'],
            ['value' => '3', 'label' => 'Bureaux internationaux'],
        ],
        'es' => [
            ['value' => '24+', 'label' => 'Países atendidos'],
            ['value' => '200+', 'label' => 'Contenedores en 2023–24'],
            ['value' => '4', 'label' => 'Regiones'],
            ['value' => '3', 'label' => 'Oficinas internacionales'],
        ],
    ],
    'markets.index.offices_eyebrow' => ['fr' => 'Sur le terrain', 'es' => 'Sobre el terreno'],
    'markets.index.offices_title' => ['fr' => 'Bureaux & partenaires internationaux', 'es' => 'Oficinas y socios internacionales'],
    'markets.index.cta_title' => ['fr' => 'Votre marché n’y figure pas ?', 'es' => '¿No ve su mercado?'],
    'markets.index.cta_body' => [
        'fr' => 'Nous ouvrons de nouveaux marchés avec les bons partenaires. Si vous distribuez des produits pharmaceutiques ou gérez des achats de santé publique, parlons de votre territoire.',
        'es' => 'Abrimos nuevos mercados con los socios adecuados. Si distribuye productos farmacéuticos o gestiona compras de salud pública, hablemos de su territorio.',
    ],
    'markets.index.cta_label' => ['fr' => 'Démarrer la conversation', 'es' => 'Iniciar la conversación'],
    'markets.index.cta_alt_label' => ['fr' => 'WhatsApp — équipe export', 'es' => 'WhatsApp — equipo de exportación'],

    // ── posts / team / inside / faqs ─────────────────────────────────
    'posts.index.hero_eyebrow' => ['fr' => 'Blog & ressources', 'es' => 'Blog y recursos'],
    'posts.index.hero_title' => [
        'fr' => 'Regards sur l’export pharmaceutique, de l’intérieur',
        'es' => 'Perspectivas desde dentro de la exportación farmacéutica',
    ],
    'posts.index.hero_lead' => [
        'fr' => 'Actualités de l’entreprise, décryptages qualité et connaissance produit par l’équipe Nymak.',
        'es' => 'Noticias de la empresa, explicaciones de calidad y conocimiento de producto del equipo Nymak.',
    ],
    'team.index.hero_eyebrow' => ['fr' => 'Notre équipe', 'es' => 'Nuestro equipo'],
    'team.index.hero_title' => ['fr' => 'Les personnes derrière la promesse', 'es' => 'Las personas detrás de la promesa'],
    'team.index.hero_lead' => [
        'fr' => 'Derrière chaque innovation, chaque produit et chaque promesse que nous faisons — se tient une équipe unie par l’expertise et l’empathie. Nous allions précision clinique et engagement sincère pour livrer des solutions de santé qui font vraiment la différence.',
        'es' => 'Detrás de cada innovación, cada producto y cada promesa que hacemos — hay un equipo unido por la experiencia y la empatía. Combinamos precisión clínica con compromiso sincero para entregar soluciones de salud que realmente marcan la diferencia.',
    ],
    'team.index.leadership_eyebrow' => ['fr' => 'Direction', 'es' => 'Liderazgo'],
    'team.index.leadership_title' => ['fr' => 'Guidés par l’expérience', 'es' => 'Guiados por la experiencia'],
    'team.index.team_eyebrow' => ['fr' => 'Spécialistes', 'es' => 'Especialistas'],
    'team.index.team_title' => ['fr' => 'Chaque discipline, un même standard', 'es' => 'Cada disciplina, un mismo estándar'],
    'inside.hero_eyebrow' => ['fr' => 'Dans les coulisses de Nymak', 'es' => 'Dentro de Nymak'],
    'inside.hero_title' => ['fr' => 'D’une seule ampoule à plus de 24 pays', 'es' => 'De una sola ampolla a más de 24 países'],
    'inside.hero_lead' => [
        'fr' => 'Faites défiler l’histoire d’une startup de 1998 à Mundra devenue un exportateur de confiance sur quatre régions.',
        'es' => 'Recorra la historia de cómo una startup de 1998 en Mundra se convirtió en un exportador de confianza en cuatro regiones.',
    ],
    'inside.story_eyebrow' => ['fr' => 'Le parcours', 'es' => 'El recorrido'],
    'inside.story_title' => ['fr' => 'Comment nous en sommes arrivés là', 'es' => 'Cómo llegamos hasta aquí'],
    'inside.journey' => [
        'fr' => [
            ['year' => '1998', 'title' => 'Fondation au Gujarat', 'text' => 'M. Ranjit Advani crée Nymak Pharma, débutant avec de l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml pour les marchés du Pacifique Sud.', 'icon' => 'Sprout'],
            ['year' => '2000', 'title' => 'L’étape du Nigeria', 'text' => 'L’entrée au Nigeria fait progresser les exportations de 25 % et ouvre une expansion plus large en Afrique ; le Honduras rejoint la carte en Amérique centrale.', 'icon' => 'Globe2'],
            ['year' => '2002', 'title' => 'Au-delà des ampoules', 'text' => 'La gamme se diversifie de l’eau pour injectables vers un portefeuille de formulations pharmaceutiques plus large pour l’export.', 'icon' => 'Package'],
            ['year' => '2004', 'title' => 'Solutés IV & perfusions', 'text' => 'Les parenteraux à grand volume rejoignent la ligne — chlorure de sodium, glucose, lactate de Ringer et perfusions multi-électrolytes.', 'icon' => 'Droplets'],
            ['year' => '2006', 'title' => 'Dispositifs & consommables', 'text' => 'Accès IV, perfuseurs, seringues et consommables de soins prolongent Nymak au-delà des médicaments.', 'icon' => 'Syringe'],
            ['year' => '2008', 'title' => 'La qualité en interne', 'text' => 'Un laboratoire de contrôle qualité dédié est créé — chaque lot analysé avant libération.', 'icon' => 'FlaskConical'],
            ['year' => '2010', 'title' => 'Diagnostics rapides', 'text' => 'Des tests rapides pour le paludisme, la typhoïde et le VIH rejoignent le portefeuille pour les programmes de santé publique.', 'icon' => 'Microscope'],
            ['year' => '2012', 'title' => 'Le réglementaire sous un même toit', 'text' => 'Préparation des dossiers, support d’enregistrement et design d’emballages conformes internalisés.', 'icon' => 'FileCheck2'],
            ['year' => '2014', 'title' => 'Certifié ISO 13485', 'text' => 'Le système de management de la qualité est certifié pour la fabrication de dispositifs médicaux.', 'icon' => 'BadgeCheck'],
            ['year' => '2016', 'title' => 'La gamme de marque', 'text' => 'Alumak, Cefmak, Cipromak et leurs marques sœurs sont enregistrées sur les marchés d’Afrique de l’Ouest.', 'icon' => 'Tag'],
            ['year' => '2018', 'title' => 'Ouverture du bureau au Royaume-Uni', 'text' => 'Une présence à Londres rapproche le support réglementaire et commercial des partenaires.', 'icon' => 'Building2'],
            ['year' => '2020', 'title' => 'À travers la pandémie', 'text' => 'Médicaments essentiels, solutés IV et consommables continuent d’affluer vers les marchés partenaires malgré la crise mondiale.', 'icon' => 'ShieldCheck'],
            ['year' => '2022', 'title' => 'Star Export House', 'text' => 'Le gouvernement indien certifie Nymak Star Export House en reconnaissance de ses performances à l’export.', 'icon' => 'Award'],
            ['year' => '2024', 'title' => '24+ pays, 200+ conteneurs', 'text' => 'Une année record — plus de 200 conteneurs expédiés au cours de l’exercice 2023–24, avec des bureaux en Sierra Leone et au Liberia pour l’Afrique de l’Ouest.', 'icon' => 'TrendingUp'],
        ],
        'es' => [
            ['year' => '1998', 'title' => 'Fundación en Gujarat', 'text' => 'El Sr. Ranjit Advani crea Nymak Pharma, comenzando con agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml para los mercados del Pacífico Sur.', 'icon' => 'Sprout'],
            ['year' => '2000', 'title' => 'El hito de Nigeria', 'text' => 'La entrada en Nigeria eleva las exportaciones un 25 % y abre una expansión más amplia por África; Honduras se suma al mapa en América Central.', 'icon' => 'Globe2'],
            ['year' => '2002', 'title' => 'Más allá de las ampollas', 'text' => 'La gama se diversifica del agua para inyectables hacia una cartera más amplia de formulaciones farmacéuticas para exportación.', 'icon' => 'Package'],
            ['year' => '2004', 'title' => 'Fluidos IV y perfusiones', 'text' => 'Los parenterales de gran volumen se incorporan — cloruro de sodio, glucosa, lactato de Ringer y perfusiones multielectrolíticas.', 'icon' => 'Droplets'],
            ['year' => '2006', 'title' => 'Dispositivos y desechables', 'text' => 'Acceso IV, equipos de infusión, jeringas y consumibles de cuidado del paciente extienden a Nymak más allá de los medicamentos.', 'icon' => 'Syringe'],
            ['year' => '2008', 'title' => 'La calidad en casa', 'text' => 'Se crea un laboratorio de control de calidad dedicado — cada lote analizado antes de su liberación.', 'icon' => 'FlaskConical'],
            ['year' => '2010', 'title' => 'Diagnóstico rápido', 'text' => 'Pruebas rápidas de malaria, fiebre tifoidea y VIH se incorporan a la cartera para programas de salud pública.', 'icon' => 'Microscope'],
            ['year' => '2012', 'title' => 'Regulación bajo un mismo techo', 'text' => 'Preparación de dossiers, soporte de registro y diseño de empaque conforme internalizados.', 'icon' => 'FileCheck2'],
            ['year' => '2014', 'title' => 'Certificación ISO 13485', 'text' => 'El sistema de gestión de calidad se certifica para la fabricación de dispositivos médicos.', 'icon' => 'BadgeCheck'],
            ['year' => '2016', 'title' => 'La gama de marca', 'text' => 'Alumak, Cefmak, Cipromak y marcas hermanas se registran en mercados de África Occidental.', 'icon' => 'Tag'],
            ['year' => '2018', 'title' => 'Apertura de la oficina en el Reino Unido', 'text' => 'Una presencia en Londres acerca el soporte regulatorio y comercial a los socios.', 'icon' => 'Building2'],
            ['year' => '2020', 'title' => 'A través de la pandemia', 'text' => 'Medicamentos esenciales, fluidos IV y desechables siguen fluyendo hacia los mercados socios durante la disrupción global.', 'icon' => 'ShieldCheck'],
            ['year' => '2022', 'title' => 'Star Export House', 'text' => 'El Gobierno de la India certifica a Nymak como Star Export House en reconocimiento a su desempeño exportador.', 'icon' => 'Award'],
            ['year' => '2024', 'title' => '24+ países, 200+ contenedores', 'text' => 'Un año récord — más de 200 contenedores despachados en el ejercicio 2023–24, con oficinas en Sierra Leona y Liberia para África Occidental.', 'icon' => 'TrendingUp'],
        ],
    ],
    'inside.explorer_eyebrow' => ['fr' => 'Empreinte mondiale', 'es' => 'Huella global'],
    'inside.explorer_title' => ['fr' => 'Touchez un marché. Voyez ce que nous y avons construit.', 'es' => 'Toque un mercado. Vea lo que construimos allí.'],
    'inside.explorer_lead' => [
        'fr' => 'Chaque pays ci-dessous est une véritable relation d’exploitation — sélectionnez-en un pour voir les produits que nous y livrons aujourd’hui.',
        'es' => 'Cada país de abajo es una relación operativa real — seleccione uno para ver los productos que suministramos allí hoy.',
    ],
    'inside.cta_title' => ['fr' => 'Prêt à écrire le prochain chapitre avec nous ?', 'es' => '¿Listo para escribir el próximo capítulo con nosotros?'],
    'inside.cta_body' => [
        'fr' => 'Distributeurs, ministères et groupes hospitaliers — dites-nous ce dont votre marché a besoin et nous définirons un plan d’approvisionnement.',
        'es' => 'Distribuidores, ministerios y grupos hospitalarios — díganos qué necesita su mercado y definiremos un plan de suministro.',
    ],
    'faqs.hero_eyebrow' => ['fr' => 'FAQ', 'es' => 'Preguntas frecuentes'],
    'faqs.hero_title' => ['fr' => 'Questions fréquentes', 'es' => 'Preguntas frecuentes'],
    'faqs.hero_lead' => [
        'fr' => 'Des réponses directes sur qui nous sommes, ce que nous fabriquons, où nous exportons et comment travailler avec nous.',
        'es' => 'Respuestas directas sobre quiénes somos, qué fabricamos, a dónde exportamos y cómo trabajar con nosotros.',
    ],
    'faqs.cta_title' => ['fr' => 'Encore une question ?', 'es' => '¿Aún tiene una pregunta?'],
    'faqs.cta_body' => [
        'fr' => 'Nos équipes export et réglementaire répondent à chaque demande — produits, tarifs, enregistrement, emballage et logistique.',
        'es' => 'Nuestros equipos de exportación y regulación responden a cada consulta — productos, precios, registro, empaque y logística.',
    ],
];
