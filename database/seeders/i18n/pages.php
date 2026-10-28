<?php

/**
 * Baseline FR/ES translations for PageContent slots.
 *
 * Key format: "<page>.<slot>". Values: ['fr' => …, 'es' => …].
 * JSON slots carry nested arrays: the seeder json_encodes them into
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
        'fr' => 'Plus de 25 ans de lifecare axée sur l’efficacité, exportée depuis l’Inde',
        'es' => 'Más de 25 años de lifecare orientada a la eficacia, exportada desde la India',
    ],
    'home.hero_subtitle' => [
        'fr' => 'Votre partenaire fiable en solutions de lifecare efficaces, présent dans 24 pays et ce n’est que le début. Parmi les fabricants pharmaceutiques en Inde, Nymak Pharma se distingue : une société pharmaceutique certifiée WHO-GMP et Star Export House reconnue par le gouvernement indien, fournissant solutés IV, formes finies, dispositifs médicaux et tests de diagnostic rapide.',
        'es' => 'Su socio fiable en soluciones de lifecare eficaces, presente en 24 países y en crecimiento. Entre los fabricantes farmacéuticos de la India, Nymak Pharma destaca: una compañía farmacéutica certificada WHO-GMP y Star Export House reconocida por el Gobierno de la India, que suministra fluidos IV, formas terminadas, dispositivos médicos y pruebas de diagnóstico rápido.',
    ],
    'home.hero_primary_label' => ['fr' => 'Découvrir nos produits', 'es' => 'Explorar nuestros productos'],
    'home.hero_secondary_label' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'home.stats_years_label' => ['fr' => 'Années de lifecare', 'es' => 'Años de lifecare'],
    'home.stats_countries_label' => ['fr' => 'Pays d’exportation', 'es' => 'Países de exportación'],
    'home.stats_containers_label' => ['fr' => 'Conteneurs par exercice', 'es' => 'Contenedores por ejercicio'],
    'home.stats_products_label' => ['fr' => 'Produits au catalogue', 'es' => 'Productos en cartera'],
    'home.about_eyebrow' => ['fr' => 'À propos de Nymak Pharma', 'es' => 'Acerca de Nymak Pharma'],
    'home.about_title' => [
        'fr' => 'Une société pharmaceutique indienne exportatrice depuis 1998',
        'es' => 'Una compañía farmacéutica india exportadora desde 1998',
    ],
    'home.about_p1' => [
        'fr' => 'Fondée en 1998 sous la direction de M. Ranjit Advani, Nymak Pharma a débuté avec un seul produit : de l’eau stérilisée pour préparations injectables BP en ampoules plastiques, livrée aux hôpitaux et pharmacies du Pacifique Sud. De ces débuts, nous avons grandi vers l’Amérique centrale, puis le Nigeria en 2000, une étape qui a fait progresser nos exportations de 25 % et ouvert notre expansion à travers le continent africain. Ce parcours couvre aujourd’hui plus de 24 pays sur quatre continents.',
        'es' => 'Fundada en 1998 bajo la dirección del Sr. Ranjit Advani, Nymak Pharma comenzó con un solo producto: agua esterilizada para preparaciones inyectables BP en ampollas de plástico, suministrada a hospitales y farmacias del Pacífico Sur. De esos inicios crecimos hacia Centroamérica y luego Nigeria en 2000, un hito que elevó las exportaciones un 25 % y abrió nuestra expansión por el continente africano. Ese recorrido abarca hoy más de 24 países en cuatro continentes.',
    ],
    'home.about_p2' => [
        'fr' => 'Ce qui nous distingue parmi les sociétés pharmaceutiques en Inde, c’est tout ce qui se fait sous un même toit. Notre site certifié WHO-GMP de Mundra, au Gujarat, s’appuie sur une équipe réglementaire interne qui prépare les dossiers produits, un laboratoire de contrôle qualité qui analyse chaque lot, une fonction AQ distincte qui approuve chaque libération, et une équipe design produisant des emballages conformes pour chaque marché. C’est cette structure qui fait de nous une société pharmaceutique basée au Gujarat que les partenaires peuvent réellement auditer, et pas seulement un nom sur une facture proforma.',
        'es' => 'Lo que nos distingue entre las compañías farmacéuticas de la India es cuánto se hace bajo un mismo techo. Nuestra planta certificada WHO-GMP de Mundra, Gujarat, cuenta con un equipo regulatorio interno que prepara los dosieres de producto, un laboratorio de control de calidad que analiza cada lote, una función de CG independiente que aprueba cada liberación y un equipo de diseño que produce embalajes conformes para cada mercado. Esa estructura nos convierte en una compañía farmacéutica con sede en Gujarat que los socios pueden auditar de verdad, no solo un nombre en una proforma.',
    ],
    'home.about_p3' => [
        'fr' => 'En tant que Star Export House certifiée par le gouvernement indien, nous avons expédié plus de 200 conteneurs au cours de l’exercice 2023-24. Pour les distributeurs qui comparent les fournisseurs pharmaceutiques en Inde, la différence tient à la responsabilité : une seule équipe répond du produit, des documents, de l’emballage et du port. Qu’il s’agisse d’un appel d’offres pour des solutés IV, d’une gamme de marque pour un marché ouest-africain ou d’un support d’enregistrement pour un nouveau territoire, la même équipe qui produit gère la documentation, l’étiquetage et l’expédition.',
        'es' => 'Como Star Export House certificada por el Gobierno de la India, enviamos más de 200 contenedores en el ejercicio 2023-24. Para los distribuidores que comparan proveedores farmacéuticos en la India, la diferencia es la responsabilidad: un solo equipo responde del producto, la documentación, el embalaje y el puerto.',
    ],
    'home.about_cta_label' => ['fr' => 'Notre histoire', 'es' => 'Nuestra historia'],
    'home.about_cta2_label' => ['fr' => 'Voir notre site', 'es' => 'Ver nuestra planta'],
    'home.about_badge_caption' => ['fr' => 'Mundra, Gujarat, Inde', 'es' => 'Mundra, Gujarat, India'],
    'home.portfolio_eyebrow' => ['fr' => 'Notre portefeuille', 'es' => 'Nuestra cartera'],
    'home.portfolio_title' => [
        'fr' => 'Quatre segments de produits, un seul standard qualité',
        'es' => 'Cuatro segmentos de productos, un solo estándar de calidad',
    ],
    'home.portfolio_lead' => [
        'fr' => 'Un portefeuille pharmaceutique d’exportation construit pour les hôpitaux, distributeurs, ONG et programmes de santé publique, organisé en quatre segments : solutés et perfusions IV, formes finies, dispositifs médicaux et consommables, et tests de diagnostic rapide. En tant que fournisseurs pharmaceutiques en Inde au service de marchés réglementés et semi-réglementés, chaque article expédie avec la documentation exigée par sa destination.',
        'es' => 'Una cartera farmacéutica de exportación construida para hospitales, distribuidores, ONG y programas de salud pública, organizada en cuatro segmentos: fluidos e infusiones IV, formas terminadas, dispositivos médicos y consumibles, y pruebas de diagnóstico rápido. Como proveedores farmacéuticos en la India al servicio de mercados regulados y semirregulados, cada artículo se despacha con la documentación que su destino exige.',
    ],
    'home.portfolio_card_label' => ['fr' => 'Explorer la catégorie', 'es' => 'Explorar la categoría'],
    'home.portfolio_cta_label' => ['fr' => 'Toutes les catégories', 'es' => 'Todas las categorías'],
    'home.brands_eyebrow' => ['fr' => 'Marques commercialisées', 'es' => 'Marcas comercializadas'],
    'home.brands_title' => ['fr' => 'La gamme de marque Nymak', 'es' => 'La gama de marca Nymak'],
    'home.brands_lead' => [
        'fr' => 'Marques Nymak déposées fournies sur les marchés d’Afrique de l’Ouest, chacune produite dans des conditions WHO-GMP et accompagnée par nos équipes réglementaires et design internes : Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak et plus.',
        'es' => 'Marcas Nymak registradas suministradas en mercados de África Occidental, cada una producida bajo condiciones WHO-GMP y respaldada por nuestros equipos internos regulatorios y de diseño: Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak y más.',
    ],
    'home.quality_eyebrow' => ['fr' => 'Qualité & conformité', 'es' => 'Calidad y cumplimiento'],
    'home.quality_title' => [
        'fr' => 'Certifiés pour les marchés qui exigent des preuves',
        'es' => 'Certificados para los mercados que exigen pruebas',
    ],
    'home.quality_body' => [
        'fr' => 'Chaque lot est analysé par notre laboratoire de contrôle qualité interne et libéré uniquement après revue AQ. Notre équipe réglementaire accompagne les dossiers et enregistrements de produits sur les marchés de destination : c’est ce qui distingue une société de fabrication pharmaceutique vérifiée en Inde d’une société de papier. Chaque distinction reflète notre engagement profond envers la qualité, l’intégrité et l’excellence en santé mondiale : la confiance de nos partenaires, la sécurité de nos produits et les vies que nous nous efforçons d’améliorer. La certification WHO-GMP, les systèmes qualité ISO 13485:2016, le statut Star Export House et l’adhésion Pharmexcil sont maintenus comme des systèmes vivants, audités régulièrement et vérifiés par les partenaires et inspecteurs qui visitent le site.',
        'es' => 'Cada lote es analizado por nuestro laboratorio de control de calidad interno y liberado solo tras la revisión de CG. Nuestro equipo regulatorio apoya los dosieres y registros de producto en los mercados de destino: es lo que distingue a una compañía de fabricación farmacéutica verificada en la India de una de papel. Cada reconocimiento refleja nuestro compromiso profundo con la calidad, la integridad y la excelencia sanitaria global: la confianza de nuestros socios, la seguridad de nuestros productos y las vidas que nos esforzamos por mejorar. La certificación WHO-GMP, los sistemas de calidad ISO 13485:2016, el estatus Star Export House y la membresía Pharmexcil se mantienen como sistemas vivos, auditados regularmente y verificados por los socios e inspectores que visitan la planta.',
    ],
    'home.quality_cta_label' => ['fr' => 'Toutes les certifications', 'es' => 'Todas las certificaciones'],
    'home.global_eyebrow' => ['fr' => 'Présence mondiale', 'es' => 'Presencia global'],
    'home.global_title' => [
        'fr' => 'De l’Inde vers plus de 24 pays',
        'es' => 'De la India a más de 24 países',
    ],
    'home.global_body' => [
        'fr' => 'Un exportateur pharmaceutique depuis l’Inde vers plus de 24 pays : présence en Afrique de l’Ouest, centrale, de l’Est et australe, au Moyen-Orient, en Asie et dans le Pacifique Sud, avec des sociétés du groupe et des bureaux au Royaume-Uni, en Sierra Leone et au Liberia, et des produits comme Alumak, Cefmak et Cipromak enregistrés via des partenariats locaux. Notre présence s’organise en trois formes : nos propres sociétés du groupe, les marchés éthiques où les produits Nymak sont enregistrés et promus auprès des prescripteurs, et les marchés partenaires fournis par des distributeurs nommés partageant nos exigences qualité.',
        'es' => 'Un exportador farmacéutico desde la India hacia más de 24 países: operando en África Occidental, Central, Oriental y Austral, Oriente Medio, Asia y el Pacífico Sur, con compañías del grupo y oficinas en el Reino Unido, Sierra Leona y Liberia, y productos como Alumak, Cefmak y Cipromak registrados mediante alianzas locales. Nuestra presencia se estructura en tres formas: nuestras propias compañías del grupo, mercados éticos donde los productos Nymak están registrados y promocionados ante prescriptores, y mercados socios abastecidos por distribuidores designados que comparten nuestras exigencias de calidad.',
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
        'fr' => 'Des réponses directes sur qui nous sommes, les produits que nous fournissons, nos certifications WHO-GMP et comment nous exportons vers plus de 24 marchés.',
        'es' => 'Respuestas directas sobre quiénes somos, los productos que suministramos, nuestras certificaciones WHO-GMP y cómo exportamos a más de 24 mercados.',
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
        'fr' => 'Demandes de produits, partenariats de distribution, appels d’offres et support d’enregistrement : notre équipe export répond à chaque demande. Si vous comparez les fabricants pharmaceutiques en Inde pour votre marché, commencez la conversation ici. Indiquez-nous votre marché cible et votre catégorie de produits : nous reviendrons avec disponibilités, statut documentaire et un calendrier réaliste.',
        'es' => 'Consultas de producto, alianzas de distribución, licitaciones y soporte de registro: nuestro equipo de exportación responde a cada consulta. Si compara fabricantes farmacéuticos en la India para su mercado, comience la conversación aquí. Indíquenos su mercado objetivo y categoría de producto: le responderemos con disponibilidad, estado documental y un plazo realista.',
    ],
    'home.cta_primary_label' => ['fr' => 'Contactez-nous', 'es' => 'Contáctenos'],
    'home.cta_whatsapp_label' => ['fr' => 'WhatsApp', 'es' => 'WhatsApp'],

    // ── about ────────────────────────────────────────────────────────
    'about.hero_eyebrow' => ['fr' => 'À propos', 'es' => 'Acerca de'],
    'about.hero_title' => [
        'fr' => 'Une société pharmaceutique en Inde depuis 1998',
        'es' => 'Una compañía farmacéutica en la India desde 1998',
    ],
    'about.hero_lead' => [
        'fr' => 'D’un seul injectable destiné au Pacifique Sud à une Star Export House fournissant plus de 24 pays. L’histoire de Nymak Pharma est celle d’une qualité qui se cumule.',
        'es' => 'De un solo inyectable para el Pacífico Sur a una Star Export House que abastece más de 24 países. La historia de Nymak Pharma es una historia de calidad acumulada.',
    ],
    'about.overview_title' => ['fr' => 'Présentation de l’entreprise', 'es' => 'Resumen de la empresa'],
    'about.overview_p1' => [
        'fr' => 'Parmi les sociétés pharmaceutiques en Inde, Nymak Pharma a commencé modestement et est restée délibérée. Fondée en 1998 sous la direction visionnaire de M. Ranjit Advani, la société a entrepris son parcours en produisant de l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml. Nos débuts furent modestes. Nos premiers clients se trouvaient dans le Pacifique Sud, où nous avons affirmé notre engagement envers la qualité, le service et l’efficacité, sans jamais oublier que derrière chaque produit se trouve une personne dans le besoin.',
        'es' => 'Entre las compañías farmacéuticas de la India, Nymak Pharma comenzó pequeña y siguió siendo deliberada. Fundada en 1998 bajo el liderazgo visionario del Sr. Ranjit Advani, la empresa emprendió su camino produciendo agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml. Nuestros inicios fueron humildes. Nuestros primeros clientes estaban en el Pacífico Sur, donde consolidamos nuestra dedicación a la calidad, el servicio y la eficacia, recordando siempre que detrás de cada producto hay una persona que lo necesita.',
    ],
    'about.overview_p2' => [
        'fr' => 'À mesure que notre expertise grandissait, notre portée aussi : plusieurs marchés insulaires du Pacifique Sud, puis l’Amérique centrale, et une entrée marquante au Nigeria en 2000 qui a fait progresser les exportations de 25 %. Anticipant l’évolution des besoins, cette société de fabrication pharmaceutique indienne s’est diversifiée vers une large gamme de produits pharmaceutiques et de dispositifs médicaux conçus pour les défis de santé des communautés que nous servons : solutés et perfusions IV, formes finies, dispositifs médicaux et consommables, et tests de diagnostic rapide.',
        'es' => 'A medida que florecía nuestra experiencia, también lo hacía nuestro alcance: varios mercados insulares del Pacífico Sur, luego Centroamérica, y una entrada histórica en Nigeria en 2000 que elevó las exportaciones un 25 %. Anticipando las necesidades cambiantes, esta compañía de fabricación farmacéutica india se diversificó hacia una amplia gama de productos farmacéuticos y dispositivos médicos pensados para los retos sanitarios de las comunidades que servimos: fluidos e infusiones IV, formas terminadas, dispositivos médicos y consumibles, y pruebas de diagnóstico rápido.',
    ],
    'about.overview_p3' => [
        'fr' => 'Aujourd’hui, avec plus de 25 ans d’excellence en lifecare, Nymak Pharma est une société pharmaceutique basée au Gujarat présente dans plus de 24 pays. Nous avons exporté plus de 200 conteneurs au cours de l’exercice 2023-24. En tant que Star Export House certifiée par le gouvernement indien, notre infrastructure comprend une équipe réglementaire interne préparant les dossiers produits, un laboratoire de contrôle qualité, un entrepôt dédié et des équipes CQ/AQ et design passionnées, toutes dévouées aux plus hauts standards de soin et d’excellence dans l’industrie pharmaceutique que l’Inde sait offrir.',
        'es' => 'Hoy, con más de 25 años de excelencia en lifecare, Nymak Pharma es una compañía farmacéutica con sede en Gujarat presente en más de 24 países. Exportamos más de 200 contenedores en el ejercicio 2023-24. Como Star Export House certificada por el Gobierno de la India, nuestra infraestructura incluye un equipo regulatorio interno que prepara los dosieres de producto, un laboratorio de control de calidad, un almacén dedicado y equipos de CQ/CG y diseño comprometidos, todos dedicados a los más altos estándares de cuidado y excelencia en la industria farmacéutica que la India ofrece.',
    ],
    'about.capabilities' => [
        'fr' => [
            ['icon' => 'faFlask', 'title' => 'Laboratoire CQ interne', 'text' => 'Les lots sont analysés par le contrôle qualité avant libération.'],
            ['icon' => 'faBoxesStacked', 'title' => 'Supervision AQ', 'text' => 'Une fonction assurance qualité dédiée examine et approuve chaque libération.'],
            ['icon' => 'faAward', 'title' => 'Équipe réglementaire', 'text' => 'Préparation des dossiers et support d’enregistrement pour les marchés de destination.'],
        ],
        'es' => [
            ['icon' => 'faFlask', 'title' => 'Laboratorio de CQ interno', 'text' => 'Los lotes son analizados por control de calidad antes de su liberación.'],
            ['icon' => 'faBoxesStacked', 'title' => 'Supervisión de CG', 'text' => 'Una función de garantía de calidad dedicada revisa y aprueba cada liberación.'],
            ['icon' => 'faAward', 'title' => 'Equipo regulatorio', 'text' => 'Preparación de dossiers y soporte de registro para los mercados de destino.'],
        ],
    ],
    'about.story_eyebrow' => ['fr' => 'Notre histoire', 'es' => 'Nuestra historia'],
    'about.story_title' => [
        'fr' => 'Tout a commencé à un seul bureau en 1998',
        'es' => 'Comenzó en un solo escritorio en 1998',
    ],
    'about.story_p1' => [
        'fr' => 'Nymak Pharma a commencé à un seul bureau en 1998. M. Ranjit Advani, entrepreneur et notre fondateur, est parti d’une conviction simple : des médicaments fiables doivent atteindre les communautés qui en ont le plus besoin, où qu’elles soient.',
        'es' => 'Nymak Pharma comenzó en un solo escritorio en 1998. El Sr. Ranjit Advani, empresario y nuestro fundador, partió de una convicción sencilla: los medicamentos fiables deben llegar a las comunidades que más los necesitan, estén donde estén.',
    ],
    'about.story_p2' => [
        'fr' => 'Le premier produit fut l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml. Les premiers clients étaient dans le Pacifique Sud : hôpitaux et pharmacies à des milliers de kilomètres d’un approvisionnement fiable. Chaque envoi portait le même principe : derrière chaque produit, une personne dans le besoin.',
        'es' => 'El primer producto fue agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml. Los primeros clientes estaban en el Pacífico Sur: hospitales y farmacias a miles de kilómetros de un suministro fiable. Cada envío llevaba el mismo principio: detrás de cada producto hay una persona que lo necesita.',
    ],
    'about.story_p3' => [
        'fr' => 'Les premières photographies le disent mieux que nous: le premier bureau, les premiers cartons étiquetés à destination de Lae, les premiers conteneurs vers le port. Vingt-cinq ans plus tard, ce bureau est devenu un site WHO-GMP servant plus de 24 pays. La conviction, elle, n’a pas changé.',
        'es' => 'Las primeras fotografías lo cuentan mejor que nadie: la primera oficina, los primeros cartones etiquetados con destino a Lae, los primeros contenedores rumbo al puerto. Veinticinco años después, ese escritorio se ha convertido en una planta WHO-GMP que sirve a más de 24 países. La convicción no ha cambiado.',
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
    'about.journey_eyebrow' => ['fr' => 'Depuis 1998', 'es' => 'Desde 1998'],
    'about.journey_title' => ['fr' => 'Notre parcours', 'es' => 'Nuestro recorrido'],
    'about.values_eyebrow' => ['fr' => 'Ce qui nous guide', 'es' => 'Lo que nos guía'],
    'about.values_title' => ['fr' => 'Les valeurs derrière les produits', 'es' => 'Los valores detrás de los productos'],
    'about.values' => [
        'fr' => [
            ['icon' => 'faShieldHalved', 'title' => 'Efficacité', 'text' => 'Chaque produit doit tenir sa promesse. L’efficacité est le critère selon lequel nous formulons, fabriquons et libérons.'],
            ['icon' => 'faHandHoldingHeart', 'title' => 'Le client d’abord', 'text' => 'Derrière chaque produit, une personne dans le besoin. Nous construisons pour le patient au bout de la chaîne et le partenaire qui passe commande.'],
            ['icon' => 'faCircleCheck', 'title' => 'Sincérité', 'text' => 'Des transactions transparentes, une documentation honnête, des certifications vérifiables. La confiance est notre véritable exportation.'],
        ],
        'es' => [
            ['icon' => 'faShieldHalved', 'title' => 'Eficacia', 'text' => 'Cada producto debe funcionar como se promete. La eficacia es el estándar con el que formulamos, fabricamos y liberamos.'],
            ['icon' => 'faHandHoldingHeart', 'title' => 'El cliente primero', 'text' => 'Detrás de cada producto hay una persona que lo necesita. Construimos para el paciente al final de la cadena y para el socio que realiza el pedido.'],
            ['icon' => 'faCircleCheck', 'title' => 'Sinceridad', 'text' => 'Tratos transparentes, documentación honesta, certificaciones verificables. La confianza es nuestra verdadera exportación.'],
        ],
    ],
    'about.credentials_eyebrow' => ['fr' => 'Références', 'es' => 'Credenciales'],
    'about.credentials_title' => ['fr' => 'Vérifiées, pas seulement affirmées', 'es' => 'Verificadas, no solo declaradas'],
    'about.credentials_body' => [
        'fr' => 'Fabrication certifiée WHO-GMP, systèmes qualité ISO 13485:2016, reconnaissance Star Export House et adhésion à Pharmexcil: des références que régulateurs et partenaires peuvent vérifier.',
        'es' => 'Fabricación certificada WHO-GMP, sistemas de calidad ISO 13485:2016, reconocimiento Star Export House y membresía en Pharmexcil: credenciales que reguladores y socios pueden verificar.',
    ],

    // ── manufacturing ────────────────────────────────────────────────
    'manufacturing.hero_eyebrow' => ['fr' => 'Fabrication', 'es' => 'Fabricación'],
    'manufacturing.hero_title' => [
        'fr' => 'Au cœur d’un site de fabrication pharmaceutique conçu pour l’export',
        'es' => 'Dentro de una planta de fabricación farmacéutica pensada para exportar',
    ],
    'manufacturing.hero_lead' => [
        'fr' => 'Nymak Pharma regroupe ses opérations au Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat, à quelques minutes de deux des ports d’exportation les plus actifs de l’Inde. Production, contrôle qualité, affaires réglementaires, design et entreposage fonctionnent tous depuis ce site unique certifié WHO-GMP.',
        'es' => 'Nymak Pharma concentra sus operaciones en Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat, a pocos minutos de dos de los puertos de exportación más activos de la India. Producción, control de calidad, asuntos regulatorios, diseño y almacenamiento funcionan desde esta única planta certificada WHO-GMP.',
    ],
    'manufacturing.overview_title' => ['fr' => 'Siège & usine, Mundra', 'es' => 'Sede y planta, Mundra'],
    'manufacturing.overview_p1' => [
        'fr' => 'Parmi les sociétés de fabrication de médicaments en Inde, l’emplacement est une stratégie. Notre siège et notre usine se trouvent dans le Port Biz Industrial Park sur la Kandla-Mundra Highway au Gujarat, un emplacement choisi délibérément pour son accès direct aux ports de Mundra et Kandla, les portes par lesquelles plus de 200 conteneurs de produits Nymak ont été expédiés au cours de l’exercice 2023-24. De la ligne de remplissage au navire, la ligne d’approvisionnement se mesure en kilomètres, pas en jours. Pour une société de fabrication de médicaments en Inde en concurrence sur le coût rendu et les délais, cette géographie est un avantage structurel que les concurrents de l’intérieur ne peuvent copier.',
        'es' => 'Entre las compañías de fabricación de medicamentos en la India, la ubicación es estrategia. Nuestra sede y planta se encuentran en el Port Biz Industrial Park de la Kandla-Mundra Highway en Gujarat, una ubicación elegida deliberadamente por su acceso directo a los puertos de Mundra y Kandla, las puertas por las que más de 200 contenedores de productos Nymak se enviaron en el ejercicio 2023-24. De la línea de llenado al buque, la línea de suministro se mide en kilómetros, no en días. Para una compañía de fabricación de medicamentos en la India que compite en coste en destino y plazos, esa geografía es una ventaja estructural que los competidores del interior no pueden copiar.',
    ],
    'manufacturing.overview_p2' => [
        'fr' => 'Le site fonctionne sous certification WHO-GMP avec des systèmes de management qualité ISO 13485:2016, le standard attendu d’une société de fabrication pharmaceutique en Inde fournissant des marchés régulés. La production s’appuie sur une structure qui garde les fonctions critiques en interne : un laboratoire de contrôle qualité analysant chaque lot, une équipe d’assurance qualité approuvant chaque libération, une équipe d’affaires réglementaires gérant dossiers et enregistrements, une équipe design produisant des emballages conformes, et une fonction logistique gérant l’entreposage et l’expédition. Des processus documentés couvrent tout le cycle de production, du contrôle des matières premières et de la préparation au remplissage, à l’étiquetage et à l’inspection finale, avec des dossiers de lot traçant chaque envoi jusqu’à sa source.',
        'es' => 'La planta opera bajo certificación WHO-GMP con sistemas de gestión de calidad ISO 13485:2016, el estándar que se espera de una compañía de fabricación farmacéutica en la India que abastece mercados regulados. La producción se apoya en una estructura que mantiene las funciones críticas en casa: un laboratorio de control de calidad que analiza cada lote, un equipo de aseguramiento de calidad que aprueba cada liberación, un equipo de asuntos regulatorios que gestiona dosieres y registros, un equipo de diseño que produce embalajes conformes, y una función logística que gestiona el almacenamiento y la expedición. Procesos documentados cubren todo el ciclo de producción, desde el control de materias primas y la preparación hasta el llenado, el etiquetado y la inspección final, con registros de lote que trazan cada envío hasta su origen.',
    ],
    'manufacturing.overview_p3' => [
        'fr' => 'Les inspections clients racontent l’histoire mieux que nous : les partenaires visitant le site décrivent des machines et un stockage modernes, des processus bien contrôlés selon les exigences GMP et un management attentif à la qualité. En tant que société de fabrication de médicaments en Inde servant plus de 24 pays, cette ouverture prête aux audits est le standard que nous tenons à chaque poste. Les audits font partie du rythme de travail ici : les inspecteurs et les équipes AQ des partenaires parcourent les lignes, examinent les dossiers et repartent avec la documentation exigée par leurs propres autorités.',
        'es' => 'Las inspecciones de clientes cuentan la historia mejor que nosotros: los socios que visitan la planta describen maquinaria y almacenamiento modernos, procesos bien controlados según los requisitos GMP y una dirección consciente de la calidad. Como compañía de fabricación de medicamentos en la India que sirve a más de 24 países, esa apertura lista para auditorías es el estándar que mantenemos en cada turno. Las auditorías forman parte del ritmo de trabajo aquí: los inspectores y los equipos de AQ de los socios recorren las líneas, revisan los registros y se llevan la documentación que exigen sus propias autoridades.',
    ],
    'manufacturing.capabilities_eyebrow' => ['fr' => 'Capacités', 'es' => 'Capacidades'],
    'manufacturing.capabilities_title' => ['fr' => 'Ce qui fonctionne dans le site', 'es' => 'Lo que funciona dentro de la planta'],
    'manufacturing.capabilities_lead' => [
        'fr' => 'Qualité, réglementaire, design et logistique sous un même toit, pour que les partenaires traitent avec une seule équipe responsable, du lot au connaissement. Chaque fonction ci-dessous existe parce qu’une société de fabrication de médicaments en Inde exportant vers plus de 24 marchés ne peut sous-traiter ce que les acheteurs auditent.',
        'es' => 'Calidad, regulación, diseño y logística bajo un mismo techo, para que los socios traten con un solo equipo responsable, del lote al conocimiento de embarque. Cada función a continuación existe porque una compañía de fabricación de medicamentos en la India que exporta a más de 24 mercados no puede subcontratar lo que los compradores auditan.',
    ],
    'manufacturing.capabilities' => [
        'fr' => [
            ['icon' => 'faFlask', 'title' => 'Laboratoire CQ interne', 'text' => 'Un laboratoire de contrôle qualité dédié analyse les lots avant libération. Les partenaires qui auditent le site notent systématiquement des processus bien maîtrisés et un stockage moderne.'],
            ['icon' => 'faClipboardCheck', 'title' => 'Supervision assurance qualité', 'text' => 'Une fonction AQ distincte examine et approuve chaque lot avant son départ, garantissant la conformité de chaque envoi aux spécifications et à la documentation.'],
            ['icon' => 'faFileCircleCheck', 'title' => 'Support réglementaire & dossiers', 'text' => 'Une équipe réglementaire interne prépare et gère les dossiers produits, soutenant les exigences d’enregistrement des marchés de destination en Afrique, en Amérique centrale et dans le Pacifique.'],
            ['icon' => 'faBox', 'title' => 'Design & emballage', 'text' => 'Une équipe design interne produit des emballages et étiquetages conformes et prêts pour le marché, y compris les gammes de marque fournies en Afrique de l’Ouest.'],
            ['icon' => 'faWarehouse', 'title' => 'Entreposage & logistique', 'text' => 'Infrastructure d’entrepôt dédiée avec stockage contrôlé, dirigée par un responsable logistique. Plus de 200 conteneurs expédiés au cours de l’exercice 2023-24.'],
            ['icon' => 'faMicroscope', 'title' => 'Amélioration continue', 'text' => 'Le site fonctionne avec une attention documentée portée à la mise à niveau des installations, vérifiée par les inspections et audits des clients.'],
        ],
        'es' => [
            ['icon' => 'faFlask', 'title' => 'Laboratorio de CQ interno', 'text' => 'Un laboratorio de control de calidad dedicado analiza los lotes antes de su liberación. Los socios que auditan la planta señalan consistentemente procesos bien controlados y almacenamiento moderno.'],
            ['icon' => 'faClipboardCheck', 'title' => 'Supervisión de garantía de calidad', 'text' => 'Una función de CG independiente revisa y aprueba cada lote antes de que salga de la planta, asegurando que cada envío cumpla especificación y documentación.'],
            ['icon' => 'faFileCircleCheck', 'title' => 'Soporte regulatorio y de dossiers', 'text' => 'Un equipo regulatorio interno prepara y gestiona los dossiers de producto, apoyando los requisitos de registro en mercados de África, América Central y el Pacífico.'],
            ['icon' => 'faBox', 'title' => 'Diseño y empaque', 'text' => 'Un equipo de diseño interno produce empaques y etiquetado conformes y listos para el mercado, incluidas las gamas de marca suministradas en África Occidental.'],
            ['icon' => 'faWarehouse', 'title' => 'Almacenamiento y logística', 'text' => 'Infraestructura de almacén dedicada con almacenamiento controlado, dirigida por un jefe de logística. Más de 200 contenedores despachados en el ejercicio 2023-24.'],
            ['icon' => 'faMicroscope', 'title' => 'Mejora continua', 'text' => 'La planta opera con un enfoque documentado en la actualización de las instalaciones, verificado mediante inspecciones y auditorías de clientes.'],
        ],
    ],
    'manufacturing.dosage_eyebrow' => ['fr' => 'Ce que nous fabriquons', 'es' => 'Lo que fabricamos'],
    'manufacturing.dosage_title' => ['fr' => 'Formes pharmaceutiques & gammes', 'es' => 'Formas farmacéuticas y líneas'],
    'manufacturing.dosage_forms' => [
        'fr' => [
            ['title' => 'Solutés IV & perfusions', 'text' => 'Parenteraux à grand volume: chlorure de sodium, glucose, lactate de Ringer, multi-électrolytes, perfusions thérapeutiques (100 ml-1000 ml).'],
            ['title' => 'Comprimés & gélules', 'text' => 'Y compris les présentations dispersibles, sublinguales, à libération prolongée et les associations.'],
            ['title' => 'Liquides oraux', 'text' => 'Sirops, suspensions et gouttes: formulations pédiatriques et adultes.'],
            ['title' => 'Injections', 'text' => 'Ampoules et flacons: solutions et poudres sèches pour reconstitution.'],
            ['title' => 'Dispositifs médicaux', 'text' => 'Accès IV, perfuseurs, seringues, aiguilles et consommables de soins.'],
            ['title' => 'Diagnostics', 'text' => 'Tests de diagnostic rapide pour les infections prioritaires et le dépistage au point de soin.'],
        ],
        'es' => [
            ['title' => 'Fluidos IV y perfusiones', 'text' => 'Parenterales de gran volumen: cloruro de sodio, glucosa, lactato de Ringer, multielectrolitos, perfusiones terapéuticas (100 ml-1000 ml).'],
            ['title' => 'Comprimidos y cápsulas', 'text' => 'Incluidas presentaciones dispersables, sublinguales, de liberación prolongada y combinaciones.'],
            ['title' => 'Líquidos orales', 'text' => 'Jarabes, suspensiones y gotas: formulaciones pediátricas y de adultos.'],
            ['title' => 'Inyecciones', 'text' => 'Ampollas y viales: soluciones y polvo seco para reconstitución.'],
            ['title' => 'Dispositivos médicos', 'text' => 'Acceso IV, equipos de infusión, jeringas, agujas y consumibles de cuidado del paciente.'],
            ['title' => 'Diagnósticos', 'text' => 'Pruebas de diagnóstico rápido para infecciones prioritarias y detección en el punto de atención.'],
        ],
    ],

    // ── quality ──────────────────────────────────────────────────────
    'quality.hero_eyebrow' => ['fr' => 'Qualité & certifications', 'es' => 'Calidad y certificaciones'],
    'quality.hero_title' => [
        'fr' => 'Une qualité certifiée, une conformité vérifiable',
        'es' => 'Calidad certificada, cumplimiento verificable',
    ],
    'quality.hero_lead' => [
        'fr' => 'Chaque distinction reflète notre engagement envers la qualité, l’intégrité et les partenaires qui comptent sur nos produits: WHO-GMP, ISO 13485:2016, Star Export House et plus encore.',
        'es' => 'Cada reconocimiento refleja nuestro compromiso con la calidad, la integridad y los socios que confían en nuestros productos: WHO-GMP, ISO 13485:2016, Star Export House y más.',
    ],
    'quality.cred_eyebrow' => ['fr' => 'Références', 'es' => 'Credenciales'],
    'quality.cred_title' => ['fr' => 'Distinctions & certifications', 'es' => 'Premios y certificaciones'],
    'quality.cred_lead' => [
        'fr' => 'Chaque distinction et certification reflète notre engagement profond envers la qualité, l’intégrité et l’excellence en santé mondiale: la confiance de nos partenaires, la sécurité de nos produits et les vies que nous nous efforçons d’améliorer. Les certificats sont à la disposition des partenaires pour vérification lors des enregistrements et audits.',
        'es' => 'Cada reconocimiento y certificación refleja nuestro compromiso profundo con la calidad, la integridad y la excelencia en salud global: la confianza de nuestros socios, la seguridad de nuestros productos y las vidas que nos esforzamos por mejorar. Los certificados están disponibles para los socios durante registros y auditorías.',
    ],
    'quality.system_title' => ['fr' => 'Comment la qualité fonctionne ici', 'es' => 'Cómo funciona la calidad aquí'],
    'quality.system_p1' => [
        'fr' => 'Chez Nymak, la qualité n’est pas un département. C’est la séquence que traverse chaque produit. Les matières premières sont contrôlées à l’entrée, la production suit des processus GMP documentés, les lots sont analysés par le laboratoire CQ interne et une fonction AQ distincte examine chaque libération avant expédition.',
        'es' => 'En Nymak, la calidad no es un departamento. Es la secuencia por la que pasa cada producto. Las materias primas se controlan a la entrada, la producción sigue procesos GMP documentados, los lotes son analizados por el laboratorio de CQ interno y una función de CG independiente revisa cada liberación antes del despacho.',
    ],
    'quality.system_p2' => [
        'fr' => 'Autour de la production s’organise la structure de support : une équipe réglementaire préparant les dossiers d’enregistrement pour les marchés de destination, une équipe design produisant des étiquetages conformes et des équipes d’entrepôt maintenant un stockage contrôlé jusqu’à l’expédition.',
        'es' => 'Alrededor de la producción se organiza la estructura de soporte: un equipo regulatorio que prepara dossiers para el registro en los mercados de destino, un equipo de diseño que produce etiquetado conforme y equipos de almacén que mantienen el almacenamiento controlado hasta el envío.',
    ],
    'quality.system_p3' => [
        'fr' => 'C’est ce que les partenaires vérifient lorsqu’ils nous auditent, et ce que les certifications WHO-GMP, ISO 13485 et Star Export House attestent de l’extérieur.',
        'es' => 'Esto es lo que los socios verifican cuando nos auditan, y lo que las credenciales WHO-GMP, ISO 13485 y Star Export House certifican desde fuera.',
    ],
    'quality.faq_title' => ['fr' => 'Questions qualité', 'es' => 'Preguntas de calidad'],
    'quality.reg_eyebrow' => ['fr' => 'Réglementaire & dossiers', 'es' => 'Regulatorio y dosieres'],
    'quality.reg_title' => ['fr' => 'Des services réglementaires pharmaceutiques pour votre marché', 'es' => 'Servicios regulatorios farmacéuticos para su mercado'],
    'quality.reg_p1' => [
        'fr' => 'Les services réglementaires pharmaceutiques en Inde varient fortement selon les exportateurs : les nôtres sont internes. Notre équipe d’affaires réglementaires gère la préparation des dossiers pharmaceutiques, compile la documentation réglementaire et accompagne l’enregistrement des médicaments sur les marchés de destination en Afrique, au Moyen-Orient, en Asie et dans le Pacifique Sud.',
        'es' => 'Los servicios regulatorios farmacéuticos en la India varían mucho según el exportador: los nuestros son internos. Nuestro equipo de asuntos regulatorios gestiona la preparación de dosieres farmacéuticos, compila la documentación regulatoria y apoya el registro de medicamentos en los mercados de destino de África, Oriente Medio, Asia y el Pacífico Sur.',
    ],
    'quality.reg_p2' => [
        'fr' => 'Chaque envoi voyage avec les documents attendus par votre autorité : dossiers produits, certificats d’analyse, preuves WHO-GMP et ISO, et étiquetage conforme produit par notre équipe design. Le support d’enregistrement pharmaceutique en Inde que nos partenaires reçoivent couvre nouveaux enregistrements, renouvellements et variations, pour qu’un produit entré sur votre marché y reste enregistré.',
        'es' => 'Cada envío viaja con la documentación que su autoridad espera: dosieres de producto, certificados de análisis, evidencias WHO-GMP e ISO, y etiquetado conforme producido por nuestro equipo de diseño. El soporte de registro farmacéutico en la India que reciben nuestros socios cubre nuevos registros, renovaciones y variaciones, para que un producto que entra en su mercado siga registrado.',
    ],

    // ── contact ──────────────────────────────────────────────────────
    'contact.hero_eyebrow' => ['fr' => 'Contact', 'es' => 'Contacto'],
    'contact.hero_title' => ['fr' => 'Parlons de votre marché', 'es' => 'Hablemos de su mercado'],
    'contact.hero_lead' => [
        'fr' => 'Distributeur, hôpital, ONG ou programme de santé: décrivez votre besoin et notre équipe export vous répondra.',
        'es' => 'Distribuidor, hospital, ONG o programa de salud: cuéntenos su requerimiento y nuestro equipo de exportación responderá.',
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
        'fr' => 'Quatre segments, plus de 300 références, un même standard qualité. Chaque produit est expédié dans des conditions WHO-GMP avec un support d’enregistrement pour votre marché.',
        'es' => 'Cuatro segmentos, más de 300 referencias, un mismo estándar de calidad. Cada producto se envía bajo condiciones WHO-GMP con soporte de registro para su mercado.',
    ],
    'products.index.body_eyebrow' => ['fr' => 'Le portefeuille', 'es' => 'La cartera'],
    'products.index.body_title' => ['fr' => 'Quatre segments, un fournisseur responsable', 'es' => 'Cuatro segmentos, un proveedor responsable'],
    'products.index.body_intro' => [
        'fr' => 'Chaque produit de ce catalogue part de notre usine certifiée WHO-GMP à Mundra, au Gujarat, avec le support d’enregistrement, la documentation de lots et la logistique consolidée par lesquels on juge les fournisseurs pharmaceutiques en Inde.',
        'es' => 'Cada producto de este catálogo sale de nuestra planta certificada WHO-GMP en Mundra, Gujarat, con el soporte de registro, la documentación de lotes y la logística consolidada por las que se juzga a los proveedores farmacéuticos en la India.',
    ],
    'products.index.body_p1' => [
        'fr' => 'Nymak Pharma est un fournisseur de produits pharmaceutiques en Inde dont le catalogue est construit autour de la façon dont nos acheteurs approvisionnent réellement. Groupes hospitaliers, importateurs, ONG et programmes de santé publique veulent rarement des commandes à ligne unique : ils veulent des solutés IV à côté des dispositifs qui les délivrent, des formulations à côté des diagnostics qui les guident, et un seul jeu de dossiers derrière le tout. Notre portefeuille en quatre segments répond exactement à cela, avec plus de 300 références tenues au même standard de fabrication et à la même piste documentaire. Pour un fournisseur de médicaments travaillant sur plus de 24 marchés d’exportation, l’ampleur et la cohérence sont ce que les acheteurs auditent en premier : la gamme doit couvrir le formulaire, et chaque ligne doit porter le même dossier de preuves.',
        'es' => 'Nymak Pharma es un proveedor de productos farmacéuticos en la India cuyo catálogo está construido en torno a cómo compran realmente nuestros clientes. Grupos hospitalarios, importadores, ONG y programas de salud pública rara vez quieren pedidos de una sola línea: quieren fluidos IV junto a los dispositivos que los administran, formulaciones junto a los diagnósticos que los guían, y un solo juego de dosieres detrás. Nuestra cartera de cuatro segmentos responde exactamente a eso, con más de 300 referencias mantenidas bajo un mismo estándar de fabricación y una misma traza documental. Para un proveedor de medicamentos que trabaja en más de 24 mercados de exportación, la amplitud y la consistencia son lo primero que auditan los compradores: la gama debe cubrir el formulario, y cada línea debe llevar el mismo expediente de evidencias.',
    ],
    'products.index.body_p2' => [
        'fr' => 'La gamme de solutés IV couvre les parentéraux grand volume et les perfusions thérapeutiques de 100 ml à 1000 ml : les essentiels de fluidothérapie et d’électrolytes pour le service et le bloc, plus des perfusions antibactériennes, antifongiques, anti-amibiennes et analgésiques. Les formes finies couvrent comprimés, gélules, sirops, suspensions, gouttes et injections dans les groupes antipaludique, antibactérien, antirétroviral, analgésique, cardiovasculaire et compléments, y compris des présentations dispersibles, sublinguales et à libération prolongée. Beaucoup de ces produits portent des enregistrements de marque Nymak sur les marchés de destination, permettant à un distributeur de commercialiser un nom établi plutôt que d’en construire un. D’un segment à l’autre, le schéma se répète : des molécules choisies pour la charge de morbidité réellement rapportée par nos marchés, des présentations adaptées aux normes d’achat et des formats conçus pour la distribution tropicale.',
        'es' => 'La gama de fluidos IV cubre parenterales de gran volumen e infusiones terapéuticas de 100 ml a 1000 ml: los básicos de fluidoterapia y electrolitos para planta y quirófano, además de infusiones antibacterianas, antifúngicas, antiamébicas y analgésicas. Las formas terminadas abarcan comprimidos, cápsulas, jarabes, suspensiones, gotas e inyectables en los grupos antipalúdico, antibacteriano, antirretroviral, analgésico, cardiovascular y suplementos, incluidas presentaciones dispersables, sublinguales y de liberación prolongada. Muchos de estos productos llevan registros de marca Nymak en los mercados de destino, permitiendo al distribuidor comercializar un nombre establecido en lugar de crearlo desde cero. De un segmento a otro, el patrón se repite: moléculas elegidas por la carga de enfermedad que reportan nuestros mercados, presentaciones ajustadas a las normas de compra y formatos pensados para la distribución tropical.',
    ],
    'products.index.body_p3' => [
        'fr' => 'Le segment dispositifs médicaux et consommables couvre l’accès IV, les consommables d’injection, les cathéters et les consommables chirurgicaux sous notre système qualité ISO 13485:2016, tandis que la gamme de tests rapides couvre les dépistages les plus demandés : paludisme, VIH, hépatites B et C, syphilis, typhoïde, dengue, grossesse et plus. En tant que fournisseur de produits pharmaceutiques en Inde régulièrement retenu dans les appels d’offres, nous tenons chaque segment aux mêmes conditions WHO-GMP et au même support d’enregistrement, pour qu’un envoi mixte ne signifie jamais des standards mixtes. L’enregistrement suit le même modèle consolidé : notre équipe des affaires réglementaires détient les dossiers marché par marché, suivant renouvellements et variations pour qu’un produit référencé le reste.',
        'es' => 'El segmento de dispositivos médicos y consumibles cubre acceso IV, consumibles de inyección, catéteres y material quirúrgico bajo nuestro sistema de calidad ISO 13485:2016, mientras que la gama de pruebas rápidas cubre las detecciones más solicitadas: malaria, VIH, hepatitis B y C, sífilis, tifoidea, dengue, embarazo y más. Como proveedor de productos farmacéuticos en la India seleccionado repetidamente en licitaciones, mantenemos cada segmento bajo las mismas condiciones WHO-GMP y el mismo soporte de registro, para que un envío mixto nunca signifique estándares mixtos. El registro sigue el mismo modelo consolidado: nuestro equipo de asuntos regulatorios mantiene los dosieres mercado por mercado, siguiendo renovaciones y variaciones para que un producto listado permanezca listado.',
    ],
    'products.index.body_p4' => [
        'fr' => 'Chaque page de segment liste la table complète des produits avec dosages et formats, et notre équipe export confirme disponibilité, statut d’enregistrement et délais pour votre marché sur demande. Pour les acheteurs comparant les fournisseurs pharmaceutiques en Inde, l’offre pratique est simple : un fournisseur, un système qualité, un envoi. Dites-nous votre liste de produits et votre marché de destination et nous la ferons correspondre à la gamme. Parce que les affaires réglementaires, l’emballage et la logistique sont en interne, nous pouvons aussi accompagner des présentations sur mesure et des formats spécifiques quand les volumes le justifient.',
        'es' => 'Cada página de segmento lista la tabla completa de productos con concentraciones y formatos, y nuestro equipo de exportación confirma disponibilidad, estado de registro y plazos para su mercado a solicitud. Para los compradores que comparan proveedores farmacéuticos en la India, la oferta práctica es simple: un proveedor, un sistema de calidad, un envío. Indíquenos su lista de productos y mercado de destino y la mapearemos con la gama. Como regulación, diseño y logística están en casa, también podemos apoyar presentaciones a medida y formatos específicos del mercado cuando los volúmenes lo justifican.',
    ],
    'products.index.body_p5' => [
        'fr' => 'La documentation fait partie du produit. Notre équipe des affaires réglementaires prépare et maintient les dossiers produits pour l’enregistrement sur les marchés de destination, notre équipe design produit un étiquetage et des visuels conformes dans les langues exigées, et notre équipe qualité fournit les certificats d’analyse de chaque lot. Pour beaucoup d’acheteurs de produits pharmaceutiques, cette paperasse transforme un devis en référencement fournisseur, et elle est gérée par la même société qui remplit les conteneurs.',
        'es' => 'La documentación es parte del producto. Nuestro equipo de asuntos regulatorios prepara y mantiene los dosieres de producto para el registro en los mercados de destino, nuestro equipo de diseño produce etiquetado y material gráfico conforme en los idiomas requeridos, y nuestro equipo de calidad entrega certificados de análisis de cada lote. Para muchos compradores de productos farmacéuticos, ese papeleo convierte una cotización en una aprobación de proveedor, y lo gestiona la misma compañía que llena los contenedores.',
    ],
    'products.index.body_p6' => [
        'fr' => 'En tant que fournisseur de médicaments travaillant depuis une seule usine certifiée WHO-GMP à quelques minutes des ports de Mundra et Kandla, nous consolidons efficacement les commandes mixtes : solutés IV, formes finies, dispositifs et diagnostics peuvent partir ensemble sous un seul connaissement, avec un seul responsable de la commande à la livraison. C’est ainsi que les programmes de produits pharmaceutiques en Inde achètent à l’échelle, et c’est le modèle d’approvisionnement sur lequel nos partenaires dans plus de 24 pays construisent leurs plans depuis plus de vingt ans. Les nouveaux marchés suivent le même chemin : cadrage d’enregistrement d’abord, conditions commerciales ensuite, puis un plan d’envoi adapté à la réalité de stockage et de distribution de l’acheteur.',
        'es' => 'Como proveedor de medicamentos que trabaja desde una única planta certificada WHO-GMP a minutos de los puertos de Mundra y Kandla, consolidamos eficientemente los pedidos mixtos: fluidos IV, formas terminadas, dispositivos y diagnósticos pueden viajar juntos bajo un solo conocimiento de embarque, con un solo responsable desde el pedido hasta la entrega. Así es como los programas de productos farmacéuticos en la India compran a escala, y es el modelo de suministro sobre el que nuestros socios en más de 24 países han construido sus planes durante más de dos décadas. Los mercados nuevos siguen el mismo camino: primero el alcance del registro, luego las condiciones comerciales, y después un plan de envío ajustado a la realidad de almacenamiento y distribución del comprador.',
    ],
    'products.index.body_p7' => [
        'fr' => 'Le programme de marques mérite une note à part. Sur les marchés d’Afrique de l’Ouest, nos noms Nymak déposés, dont Alumak, Cefmak, Cipromak, Amoximak, Clavmak et Zincomak, offrent aux distributeurs une identité commercialisée dès le premier jour : marques déposées, emballages établis et documentation produit que les équipes locales connaissent déjà. Pour un fournisseur de médicaments entrant sur un nouveau territoire, ce capital de marque raccourcit la distance entre enregistrement et premières ventes.',
        'es' => 'El programa de marcas merece una nota aparte. En los mercados de África Occidental, nuestros nombres Nymak registrados, incluidos Alumak, Cefmak, Cipromak, Amoximak, Clavmak y Zincomak, dan a los distribuidores una identidad comercial desde el primer día: marcas registradas, empaque establecido y documentación de producto que los equipos locales ya conocen. Para un proveedor de medicamentos que entra en un territorio nuevo, ese capital de marca acorta la distancia entre el registro y las primeras ventas.',
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
        'fr' => 'Des produits commercialisés sous les marques Nymak sur les marchés d’Afrique de l’Ouest: Alumak, Cefmak, Cipromak et autres.',
        'es' => 'Productos comercializados bajo marcas Nymak en mercados de África Occidental: Alumak, Cefmak, Cipromak y más.',
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
    'products.catalogue.title' => ['fr' => '{category} : liste complète', 'es' => '{category}: lista completa'],
    'products.catalogue.lead' => [
        'fr' => 'Chaque produit que nous fournissons dans cette catégorie, avec dosages et conditionnements. Les noms accompagnés d’un lien ouvrent une fiche produit.',
        'es' => 'Cada producto que suministramos en esta categoría, con concentraciones y presentaciones. Los nombres con enlace abren una ficha de producto.',
    ],
    'products.catalogue.branded_title' => ['fr' => 'Gamme de marque Nymak', 'es' => 'Gama de marca Nymak'],
    'products.catalogue.search_label' => ['fr' => 'Rechercher dans cette liste ({count} produits)', 'es' => 'Buscar en esta lista ({count} productos)'],
    'products.catalogue.search_placeholder' => ['fr' => 'ex. ceftriaxone, perfusion, comprimés…', 'es' => 'ej. ceftriaxona, perfusión, comprimidos…'],
    'products.catalogue.empty_title' => ['fr' => 'Aucun produit ne correspond à « {query} ».', 'es' => 'Ningún producto coincide con «{query}».'],
    'products.catalogue.empty_body' => [
        'fr' => 'Essayez un nom générique ou une classe thérapeutique, ou demandez-nous directement.',
        'es' => 'Pruebe un nombre genérico o una clase terapéutica, o pregúntenos directamente.',
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
        'fr' => 'Un exportateur pharmaceutique que l’Inde envoie vers plus de 24 pays, et ce n’est pas fini',
        'es' => 'Un exportador farmacéutico que la India envía a más de 24 países, y seguimos creciendo',
    ],
    'markets.index.hero_lead' => [
        'fr' => 'Présents dans plus de 24 pays comme la Somalie, le Kenya, la RD Congo, le Nigeria et la Sierra Leone, nous apportons plus que des produits de santé. Nous apportons de l’engagement. En tant que société d’exportation pharmaceutique en Inde travaillant en Afrique de l’Ouest, centrale, de l’Est et australe, au Moyen-Orient, en Asie et dans le Pacifique Sud, notre engagement est clair à chaque étape : améliorer des vies en livrant des produits de qualité et efficaces, et laisser une empreinte positive partout où nous allons.',
        'es' => 'Operando en más de 24 países como Somalia, Kenia, RD Congo, Nigeria y Sierra Leona, aportamos más que productos de salud. Aportamos dedicación. Como compañía exportadora farmacéutica en la India que trabaja en África Occidental, Central, Oriental y Austral, Oriente Medio, Asia y el Pacífico Sur, nuestro compromiso es claro en cada paso: mejorar vidas entregando productos de calidad y eficaces, y dejar una huella positiva dondequiera que vayamos.',
    ],
    'markets.index.map_eyebrow' => ['fr' => 'Où nous travaillons', 'es' => 'Dónde trabajamos'],
    'markets.index.map_title' => ['fr' => 'Une seule ligne d’approvisionnement de l’Inde vers le monde', 'es' => 'Una sola línea de suministro de la India al mundo'],
    'markets.index.map_lead' => [
        'fr' => 'Chaque épingle marque un marché que nous approvisionnons aujourd’hui : or pour nos bureaux, bleu pour les marchés éthiques, vert pour les marchés partenaires. Cliquez sur une épingle, ou choisissez dans la liste, pour voir le travail, les produits et les équipes sur place.',
        'es' => 'Cada pin marca un mercado al que suministramos hoy: dorado para nuestras oficinas, azul para mercados éticos, verde para mercados asociados. Haga clic en un pin, o elija de la lista, para ver el trabajo, los productos y las personas sobre el terreno.',
    ],
    'markets.index.map_empty_title' => ['fr' => 'Choisissez une épingle, explorez un marché', 'es' => 'Elija un pin, explore un mercado'],
    'markets.index.map_empty_body' => [
        'fr' => 'Les épingles marquent nos marchés d’exportation actuels. Sélectionnez-en une pour découvrir ce que nous y faisons et quels produits nous y fournissons.',
        'es' => 'Los pines marcan nuestros mercados de exportación actuales. Seleccione uno para conocer qué hacemos allí y qué productos suministramos.',
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
        'fr' => 'Plus de 200 conteneurs expédiés au cours de l’exercice 2023-24 vers plus de 24 pays répartis sur quatre régions, et le nombre continue de croître. Chaque conteneur est documenté de bout en bout : enregistrement du dossier, certificats de lots, étiquetage conforme et logistique portuaire gérés par les mêmes équipes internes. Peu d’opérations pharmaceutiques export de l’Inde font passer ce volume par un seul site audité, et encore moins peuvent montrer la paperasse ligne par ligne.',
        'es' => 'Más de 200 contenedores despachados en el ejercicio 2023-24 hacia más de 24 países en cuatro regiones, y la cifra sigue creciendo. Cada contenedor se documenta de extremo a extremo: registro del dosier, certificados de lote, etiquetado conforme y logística portuaria gestionadas por los mismos equipos internos. Pocas operaciones farmacéuticas de exportación de la India mueven este volumen desde una sola planta auditada, y menos aún pueden mostrar la documentación línea por línea.',
    ],
    'markets.index.footprint_stats' => [
        'fr' => [
            ['value' => '24+', 'label' => 'Pays desservis'],
            ['value' => '200+', 'label' => 'Conteneurs en 2023-24'],
            ['value' => '4', 'label' => 'Régions'],
            ['value' => '5', 'label' => 'Sociétés du groupe & bureaux'],
        ],
        'es' => [
            ['value' => '24+', 'label' => 'Países atendidos'],
            ['value' => '200+', 'label' => 'Contenedores en 2023-24'],
            ['value' => '4', 'label' => 'Regiones'],
            ['value' => '5', 'label' => 'Compañías del grupo y oficinas'],
        ],
    ],
    'markets.index.presence_eyebrow' => ['fr' => 'Comment nous atteignons les marchés', 'es' => 'Cómo llegamos a los mercados'],
    'markets.index.presence_title' => ['fr' => 'Trois types de marchés, une seule ligne d’approvisionnement', 'es' => 'Tres tipos de mercado, una sola línea de suministro'],
    'markets.index.presence_p1' => [
        'fr' => 'En tant que société d’exportation pharmaceutique en Inde, Nymak Pharma atteint plus de 24 pays via trois canaux distincts, et les couleurs des épingles sur la carte ci-dessus marquent la différence. Les épingles dorées sont notre propre présence : le siège et l’usine de Mundra, le bureau corporate d’Ahmedabad, et les sociétés du groupe à Freetown (Sierra Leone), Monrovia (Liberia) et Londres (Royaume-Uni), où nos équipes gèrent distribution, appels d’offres et pharmacovigilance sur le terrain. Ce sont les marchés où un partenaire peut nous rencontrer face à face : nos équipes portent les produits, la paperasse et la responsabilité au même endroit que les acheteurs.',
        'es' => 'Como compañía exportadora farmacéutica en la India, Nymak Pharma llega a más de 24 países a través de tres canales distintos, y los colores de los pines del mapa marcan la diferencia. Los pines dorados son nuestra propia presencia: la sede y la planta de Mundra, la oficina corporativa de Ahmedabad, y las compañías del grupo en Freetown (Sierra Leona), Monrovia (Liberia) y Londres (Reino Unido), donde nuestros equipos gestionan distribución, licitaciones y farmacovigilancia sobre el terreno. Estos son los mercados donde un socio puede encontrarnos cara a cara: nuestra gente lleva los productos, la documentación y la responsabilidad en el mismo lugar que los compradores.',
    ],
    'markets.index.presence_p2' => [
        'fr' => 'Les épingles bleues sont les marchés éthiques : Cameroun, Tchad et Burkina Faso, où la promotion sur ordonnance et les produits enregistrés servent directement médecins, pharmacies et hôpitaux. Les épingles vertes sont les marchés partenaires : Nigeria, Sénégal, Mauritanie, Angola, RD Congo, Kenya, Somalie, Burundi, Malawi, Afrique du Sud, Irak, Azerbaïdjan, Philippines et notre région fondatrice du Pacifique Sud : Papouasie-Nouvelle-Guinée, Îles Salomon, Vanuatu, Tonga, Fidji et Samoa-Occidentale, où des distributeurs agréés portent nos gammes enregistrées dans le cadre de partenariats locaux. Sur les marchés partenaires, notre rôle va au-delà de l’expédition de cartons : nous préparons les dossiers d’enregistrement, produisons les visuels conformes au marché et garantissons chaque lot avec les certificats demandés par les autorités, pendant que nos partenaires exploitent le territoire commercial qu’ils connaissent le mieux.',
        'es' => 'Los pines azules son los mercados éticos: Camerún, Chad y Burkina Faso, donde la promoción con receta y los productos registrados sirven directamente a médicos, farmacias y hospitales. Los pines verdes son los mercados asociados: Nigeria, Senegal, Mauritania, Angola, RD Congo, Kenia, Somalia, Burundi, Malaui, Sudáfrica, Irak, Azerbaiyán, Filipinas y nuestra región fundadora del Pacífico Sur: Papúa Nueva Guinea, Islas Salomón, Vanuatu, Tonga, Fiyi y Samoa Occidental, donde distribuidores designados llevan nuestras gamas registradas mediante alianzas locales. En los mercados asociados, nuestro papel va más allá de despachar cajas: preparamos los dosieres de registro, producimos el material gráfico conforme al mercado y respaldamos cada lote con los certificados que piden las autoridades, mientras nuestros socios trabajan el territorio comercial que mejor conocen.',
    ],
    'markets.index.presence_p3' => [
        'fr' => 'Le modèle compte moins que le standard derrière. Quelle que soit la couleur d’un marché, les produits partent de la même usine certifiée WHO-GMP au Gujarat, soutenus par la même équipe réglementaire interne préparant les dossiers d’enregistrement, le même laboratoire CQ libérant chaque lot et la même équipe design produisant des emballages et étiquettes conformes dans la langue du marché. C’est ainsi que les exportateurs pharmaceutiques de l’Inde maintiennent la cohérence d’une carte de 24 pays : la chaîne d’approvisionnement ne change pas avec la couleur du repère. De la production WHO-GMP à Mundra aux documents portuaires gérés par notre bureau d’Ahmedabad, une seule séquence gouverne chaque marché : enregistrer, libérer, étiqueter, expédier, documenter.',
        'es' => 'El modelo importa menos que el estándar detrás. Sea cual sea el color de un mercado, los productos salen de la misma planta certificada WHO-GMP en Gujarat, respaldados por el mismo equipo regulatorio interno que prepara los dosieres de registro, el mismo laboratorio de CQ que libera cada lote y el mismo equipo de diseño que produce embalajes y etiquetado conformes en el idioma del mercado. Así es como los exportadores farmacéuticos de la India mantienen coherente un mapa de 24 países: la línea de suministro no cambia con el color del marcador. Desde la producción WHO-GMP en Mundra hasta el papeleo portuario gestionado por nuestra oficina de Ahmedabad, una sola secuencia gobierna cada mercado: registrar, liberar, etiquetar, enviar, documentar.',
    ],
    'markets.index.presence_p4' => [
        'fr' => 'Pour les acheteurs comparant un exportateur pharmaceutique indien aux alternatives régionales, voici la différence pratique : les marchés de présence ont un bureau local responsable, les marchés éthiques ont une présence terrain conforme à la promotion, et les marchés partenaires ont un fournisseur dont le dossier réglementaire arrive complet. Si votre pays n’est pas encore sur le tableau, la conversation commence de la même façon : dites-nous votre liste de produits et votre marché, et notre équipe export tracera la route. Parce que le travail de dossiers est en interne, le cadrage d’un nouveau marché fait partie de la demande normale : nous vous disons quel enregistrement votre autorité attend avant de chiffrer, pas après le blocage d’une première commande.',
        'es' => 'Para los compradores que comparan un exportador farmacéutico indio con alternativas regionales, esta es la diferencia práctica: los mercados de presencia tienen una oficina local responsable, los mercados éticos tienen una presencia de campo conforme a la promoción, y los mercados asociados tienen un proveedor cuyo expediente regulatorio llega completo. Si su país aún no está en el tablero, la conversación empieza igual: indíquenos su lista de productos y su mercado, y nuestro equipo de exportación trazará la ruta. Como el trabajo de dosieres está en casa, el análisis de un mercado nuevo forma parte de la consulta normal: le decimos qué registro espera su autoridad antes de cotizar, no después de que se detenga un primer pedido.',
    ],
    'markets.index.presence_p5' => [
        'fr' => 'La carte continue de s’étendre. De nouveaux enregistrements sont en cours sur d’autres marchés africains et asiatiques, et les partenaires évaluant les fournisseurs pharmaceutiques que l’Inde propose pour des programmes de long terme sont invités à se renseigner sur les territoires à venir. Où que le prochain repère se pose, il rejoint un réseau qui grandit depuis le premier envoi parti pour le Pacifique Sud en 1998. Chaque année ajoute des repères au tableau ; le standard derrière eux ne bouge pas.',
        'es' => 'El mapa sigue creciendo. Hay nuevos registros en curso en otros mercados de África y Asia, y los socios que evalúan a los proveedores farmacéuticos que la India ofrece para programas de largo plazo pueden preguntar por los próximos territorios. Dondequiera que caiga el próximo marcador, se une a una red que crece desde el primer envío que salió hacia el Pacífico Sur en 1998. Cada año suma marcadores al tablero; el estándar detrás de ellos no se mueve.',
    ],
    'markets.index.presence_p6' => [
        'fr' => 'Choisir entre les canaux est rarement un problème que l’acheteur résout seul. Un ministère menant un appel d’offres national a besoin d’un fournisseur dont le dossier résiste à l’examen ; un distributeur privé a besoin de marge et de soutien marketing ; une ONG a besoin de dates de livraison tenues. Notre équipe export travaille ce calcul marché par marché, c’est pourquoi le même catalogue atteint un bureau londonien, un grossiste pharmaceutique de Freetown et un programme de santé du Pacifique sous trois arrangements différents avec un même standard de preuves. C’est le type d’exportateur pharmaceutique sur lequel l’Inde a bâti sa réputation : présent là où cela compte, documenté partout.',
        'es' => 'Elegir entre canales rara vez es un problema que el comprador resuelve solo. Un ministerio con una licitación nacional necesita un proveedor cuyo expediente resista el escrutinio; un distribuidor privado necesita margen y apoyo de marketing; una ONG necesita fechas de entrega que se cumplan. Nuestro equipo de exportación resuelve ese cálculo mercado por mercado, por eso el mismo catálogo llega a una oficina londinense, un mayorista farmacéutico de Freetown y un programa de salud del Pacífico bajo tres acuerdos distintos con un mismo estándar de evidencia. Ese es el tipo de exportador farmacéutico sobre el que la India construyó su reputación: presente donde importa, documentado en todas partes.',
    ],
    'markets.index.offices_eyebrow' => ['fr' => 'Sur le terrain', 'es' => 'Sobre el terreno'],
    'markets.index.offices_title' => ['fr' => 'Sociétés du groupe', 'es' => 'Compañías del grupo'],
    'markets.index.cta_title' => ['fr' => 'Votre marché n’y figure pas ?', 'es' => '¿No ve su mercado?'],
    'markets.index.cta_body' => [
        'fr' => 'Nous ouvrons de nouveaux marchés avec les bons partenaires. Si vous distribuez des produits pharmaceutiques ou gérez des achats de santé publique, parlons de votre territoire.',
        'es' => 'Abrimos nuevos mercados con los socios adecuados. Si distribuye productos farmacéuticos o gestiona compras de salud pública, hablemos de su territorio.',
    ],
    'markets.index.cta_label' => ['fr' => 'Démarrer la conversation', 'es' => 'Iniciar la conversación'],
    'markets.index.cta_alt_label' => ['fr' => 'WhatsApp: équipe export', 'es' => 'WhatsApp: equipo de exportación'],

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
        'fr' => 'Derrière chaque produit et chaque promesse que nous faisons, il y a une équipe unie par l’expertise et l’empathie. Nous allions précision clinique et engagement sincère pour livrer des solutions de santé qui font vraiment la différence.',
        'es' => 'Detrás de cada producto y cada promesa que hacemos, hay un equipo unido por la experiencia y la empatía. Combinamos precisión clínica con compromiso sincero para entregar soluciones de salud que realmente marcan la diferencia.',
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
    'inside.explorer_eyebrow' => ['fr' => 'Empreinte mondiale', 'es' => 'Huella global'],
    'inside.explorer_title' => ['fr' => 'Touchez un marché. Voyez ce que nous y avons construit.', 'es' => 'Toque un mercado. Vea lo que construimos allí.'],
    'inside.explorer_lead' => [
        'fr' => 'Chaque pays ci-dessous est une véritable relation d’exploitation. Sélectionnez-en un pour voir les produits que nous y livrons aujourd’hui.',
        'es' => 'Cada país de abajo es una relación operativa real. Seleccione uno para ver los productos que suministramos allí hoy.',
    ],
    'inside.cta_title' => ['fr' => 'Prêt à écrire le prochain chapitre avec nous ?', 'es' => '¿Listo para escribir el próximo capítulo con nosotros?'],
    'inside.cta_body' => [
        'fr' => 'Distributeurs, ministères et groupes hospitaliers: dites-nous ce dont votre marché a besoin et nous définirons un plan d’approvisionnement.',
        'es' => 'Distribuidores, ministerios y grupos hospitalarios: díganos qué necesita su mercado y definiremos un plan de suministro.',
    ],
    'faqs.hero_eyebrow' => ['fr' => 'FAQ', 'es' => 'Preguntas frecuentes'],
    'faqs.hero_title' => ['fr' => 'Questions fréquentes', 'es' => 'Preguntas frecuentes'],
    'faqs.hero_lead' => [
        'fr' => 'Des réponses directes sur qui nous sommes, ce que nous fabriquons, où nous exportons et comment travailler avec nous.',
        'es' => 'Respuestas directas sobre quiénes somos, qué fabricamos, a dónde exportamos y cómo trabajar con nosotros.',
    ],
    'faqs.cta_title' => ['fr' => 'Encore une question ?', 'es' => '¿Aún tiene una pregunta?'],
    'faqs.cta_body' => [
        'fr' => 'Nos équipes export et réglementaire répondent à chaque demande: produits, tarifs, enregistrement, emballage et logistique.',
        'es' => 'Nuestros equipos de exportación y regulación responden a cada consulta: productos, precios, registro, empaque y logística.',
    ],

    // ── ahmedabad ────────────────────────────────────────────────────
    'ahmedabad.hero_eyebrow' => ['fr' => 'Ahmedabad · Gujarat', 'es' => 'Ahmedabad · Gujarat'],
    'ahmedabad.hero_title' => [
        'fr' => 'Une société de fabrication pharmaceutique à Ahmedabad, Gujarat',
        'es' => 'Una compañía de fabricación farmacéutica en Ahmedabad, Gujarat',
    ],
    'ahmedabad.hero_lead' => [
        'fr' => 'Le bureau corporate de Nymak Pharma à Ahmedabad dirige les opérations réglementaires, design et export aux côtés de notre usine certifiée WHO-GMP de Mundra, au service de plus de 24 pays depuis le Gujarat, en Inde.',
        'es' => 'La oficina corporativa de Nymak Pharma en Ahmedabad dirige las operaciones regulatorias, de diseño y exportación junto a nuestra planta certificada WHO-GMP de Mundra, sirviendo a más de 24 países desde Gujarat, India.',
    ],
    'ahmedabad.overview_title' => ['fr' => 'Bureau corporate, Ahmedabad', 'es' => 'Oficina corporativa, Ahmedabad'],
    'ahmedabad.overview_p1' => [
        'fr' => 'Parmi les sociétés pharmaceutiques d’Ahmedabad, Nymak Pharma dirige son bureau corporate au Money Plant High Street, SG Highway : le centre commercial où nos équipes export, affaires réglementaires, design et comptabilité coordonnent chaque envoi quittant notre usine de Mundra, à environ 90 kilomètres au sud-ouest sur la côte du Kutch. C’est l’adresse à laquelle les partenaires écrivent, l’équipe qui répond, et le point où les commandes d’export deviennent des envois enregistrés et documentés. Choisir Ahmedabad pour le bureau corporate était délibéré : cela place Nymak parmi les sociétés pharmaceutiques du Gujarat les plus proches de l’infrastructure d’exportation, des organismes professionnels et des talents commerciaux de l’État, tandis que l’usine reste à quelques minutes du quai.',
        'es' => 'Entre las compañías farmacéuticas de Ahmedabad, Nymak Pharma dirige su oficina corporativa en Money Plant High Street, SG Highway: el centro comercial donde nuestros equipos de exportación, asuntos regulatorios, diseño y contabilidad coordinan cada envío que sale de nuestra planta de Mundra, a unos 90 kilómetros al suroeste en la costa de Kutch. Es la dirección a la que los socios escriben, el equipo que responde, y el punto donde los pedidos de exportación se convierten en envíos registrados y documentados. Elegir Ahmedabad para la oficina corporativa fue deliberado: sitúa a Nymak entre las compañías farmacéuticas de Gujarat más cercanas a la infraestructura de exportación, los organismos del sector y el talento comercial del estado, mientras la planta permanece a minutos del muelle.',
    ],
    'ahmedabad.overview_p2' => [
        'fr' => 'Le bureau gère le travail que les acheteurs ressentent sans le voir : dossiers d’enregistrement pour les marchés de destination, emballages et étiquetage conformes conçus en interne, documentation d’appels d’offres pour les programmes, et documents d’exportation qui mènent un envoi de notre entrepôt aux ports de Mundra et Kandla. Quand un distributeur demande ce qui distingue un fabricant pharmaceutique d’Ahmedabad d’un bureau de négoce, la réponse est cette équipe : des spécialistes qui suivent le dossier de la première demande au connaissement final. Le bureau accueille aussi les aspects pour lesquels les acheteurs nous rendent visite : programmation des audits, validations d’emballage, envois d’échantillons et revues de contrat qui transforment un devis en accord d’approvisionnement durable.',
        'es' => 'La oficina gestiona el trabajo que los compradores sienten pero rara vez ven: dosieres de registro para los mercados de destino, embalajes y etiquetado conformes diseñados en casa, documentación de licitaciones para programas, y documentos de exportación que llevan un envío de nuestro almacén a los puertos de Mundra y Kandla. Cuando un distribuidor pregunta qué distingue a un fabricante farmacéutico de Ahmedabad de un mostrador de corretaje, la respuesta es este equipo: especialistas que siguen el expediente desde la primera consulta hasta el conocimiento de embarque final. La oficina también alberga los aspectos por los que nos visitan los compradores: programación de auditorías, aprobaciones de embalaje, envíos de muestras y revisiones de contrato que convierten una cotización en un acuerdo de suministro duradero.',
    ],
    'ahmedabad.why_title' => ['fr' => 'Pourquoi le Gujarat, et pourquoi cela compte pour les acheteurs', 'es' => 'Por qué Gujarat, y por qué importa a los compradores'],
    'ahmedabad.why_p1' => [
        'fr' => 'Le Gujarat est l’une des zones de fabrication pharmaceutique les plus profondes de l’Inde, et notre position y est délibérée. L’usine de Mundra se trouve à quelques minutes de deux des ports d’exportation les plus actifs de l’Inde, tandis que le bureau d’Ahmedabad place notre équipe commerciale dans la capitale économique de l’État : proche de Pharmexcil et des organismes d’exportation, des centres logistiques et bancaires, et du vivier de talents sur lequel les sociétés pharmaceutiques du Gujarat s’appuient. Les sociétés pharmaceutiques du Gujarat fournissent une grande part des formes que le monde achète ; être au cœur de cet écosystème signifie que fournisseurs, conditionneurs, transitaires et régulateurs sont tous à portée de main. L’approvisionnement en matières premières, les composants d’emballage et les services spécialisés se trouvent dans le même État, ce qui réduit les délais et résout les problèmes d’un appel téléphonique plutôt que d’une enquête logistique.',
        'es' => 'Gujarat es una de las zonas de fabricación farmacéutica más profundas de la India, y nuestra posición en ella es deliberada. La planta de Mundra está a pocos minutos de dos de los puertos de exportación más activos de la India, mientras que la oficina de Ahmedabad sitúa a nuestro equipo comercial en la capital económica del estado: cerca de Pharmexcil y organismos de exportación, centros de logística y banca, y la cantera de talento de las compañías farmacéuticas de Gujarat. Las compañías farmacéuticas de Gujarat suministran una gran parte de las formas que el mundo compra; estar dentro de ese ecosistema significa que proveedores, envasadores, transitarios y reguladores están todos al alcance. El abastecimiento de materias primas, los componentes de embalaje y los servicios especializados están dentro del mismo estado, así que los plazos se comprimen y los problemas se resuelven con una llamada en lugar de una consulta logística.',
    ],
    'ahmedabad.why_p2' => [
        'fr' => 'Pour les partenaires comparant les sociétés pharmaceutiques qu’Ahmedabad accueille, le résultat pratique est le temps de réponse : une question réglementaire, une demande de dossier ou une révision d’emballage atteint ses responsables en heures, pas via une chaîne d’intermédiaires. Les décisions se prennent là où siège la direction, et la direction siège ici. Pour une société pharmaceutique qu’Ahmedabad présélectionne, cette proximité se voit dans les détails : dossiers retournés plus vite, réponses le jour même sur le stock et révisions d’emballage bouclées en jours plutôt qu’en semaines.',
        'es' => 'Para los socios que comparan las compañías farmacéuticas que alberga Ahmedabad, el resultado práctico es el tiempo de respuesta: una pregunta regulatoria, una solicitud de dosier o una revisión de embalaje llega a sus responsables en horas, no a través de una cadena de intermediarios. Las decisiones se toman donde está la dirección, y la dirección está aquí. Para una compañía farmacéutica que los compradores preseleccionan en Ahmedabad, esa cercanía se nota en los detalles: dosieres devueltos más rápido, respuestas el mismo día sobre stock y revisiones de embalaje cerradas en días en lugar de semanas.',
    ],
    'ahmedabad.works_title' => ['fr' => 'Une seule société, deux adresses', 'es' => 'Una sola compañía, dos direcciones'],
    'ahmedabad.works_p1' => [
        'fr' => 'Le siège et l’usine se trouvent au Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), Gujarat, abritant production, laboratoire CQ, libération AQ et entreposage. Le bureau corporate d’Ahmedabad dirige les fonctions commerciales autour. Ensemble, ils font de Nymak une société pharmaceutique que le Gujarat peut offrir au monde : une usine auditée au port, une direction responsable en ville. Les partenaires en visite voient généralement les deux : l’atelier de fabrication le matin, les équipes réglementaires et design l’après-midi. Les deux adresses partagent une même ligne hiérarchique, donc ce qu’un partenaire se fait promettre dans la salle de réunion d’Ahmedabad est ce que l’usine de Mundra expédie.',
        'es' => 'La sede y la planta están en Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), Gujarat, albergando producción, laboratorio de CQ, liberación de CG y almacenamiento. La oficina corporativa de Ahmedabad dirige las funciones comerciales a su alrededor. Juntas hacen de Nymak una compañía farmacéutica que Gujarat puede ofrecer al mundo: una planta auditada en el puerto, una dirección responsable en la ciudad. Los socios que nos visitan suelen ver ambas: la planta de fabricación por la mañana, los equipos regulatorios y de diseño por la tarde. Las dos direcciones comparten una misma línea jerárquica, así que lo que se promete a un socio en la sala de juntas de Ahmedabad es lo que la planta de Mundra despacha.',
    ],
    'ahmedabad.works_p2' => [
        'fr' => 'Les sociétés du groupe prolongent cette structure à l’étranger : les bureaux de Londres, Freetown et Monrovia accompagnent distribution, appels d’offres et pharmacovigilance au Royaume-Uni et en Afrique de l’Ouest. Depuis Ahmedabad, la chaîne va de la ville au port puis au marché sans passage de relais à des tiers.',
        'es' => 'Las compañías del grupo extienden esa estructura al extranjero: las oficinas de Londres, Freetown y Monrovia apoyan distribución, licitaciones y farmacovigilancia en el Reino Unido y África Occidental. Desde Ahmedabad, la cadena va de la ciudad al puerto y luego al mercado sin relevos a terceros.',
    ],
    'ahmedabad.office_title' => ['fr' => 'Contacter le bureau d’Ahmedabad', 'es' => 'Contactar con la oficina de Ahmedabad'],
    'ahmedabad.cta_title' => ['fr' => 'Vous travaillez avec des sociétés pharmaceutiques du Gujarat ?', 'es' => '¿Trabaja con compañías farmacéuticas de Gujarat?'],
    'ahmedabad.cta_body' => [
        'fr' => 'Dites-nous votre liste de produits et votre marché de destination. L’équipe d’Ahmedabad répond avec disponibilités, statut d’enregistrement et délais. Que vous évaluiez les fabricants pharmaceutiques que le Gujarat propose pour un appel d’offres national ou un programme de marque propre, la demande arrive sur le bureau qui peut y répondre.',
        'es' => 'Indíquenos su lista de productos y mercado de destino. El equipo de Ahmedabad responde con disponibilidad, estado de registro y plazos. Tanto si evalúa los fabricantes farmacéuticos que Gujarat ofrece para una licitación nacional como para un programa de marca propia, la consulta llega al escritorio que puede responderla.',
    ],
];
