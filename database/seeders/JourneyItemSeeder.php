<?php

namespace Database\Seeders;

use App\Models\JourneyItem;
use Illuminate\Database\Seeder;

class JourneyItemSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'year' => '1998',
                'title' => 'Founded in Gujarat',
                'body' => 'Mr. Ranjit Advani establishes Nymak Pharma, beginning with Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules for South Pacific markets.',
                'icon' => 'faSeedling',
                'image' => 'images/about/founder-1998.png',
                'image_2' => 'images/about/early-consignment.jpg',
                'fit' => 'cover',
                'sort_order' => 10,
                'i18n' => [
                    'fr' => [
                        'title' => 'Fondation au Gujarat',
                        'body' => 'M. Ranjit Advani crée Nymak Pharma, débutant avec de l’eau stérilisée pour préparations injectables BP en ampoules plastiques de 5 ml et 10 ml pour les marchés du Pacifique Sud.',
                    ],
                    'es' => [
                        'title' => 'Fundación en Gujarat',
                        'body' => 'El Sr. Ranjit Advani crea Nymak Pharma, comenzando con agua esterilizada para preparaciones inyectables BP en ampollas de plástico de 5 ml y 10 ml para los mercados del Pacífico Sur.',
                    ],
                ],
            ],
            [
                'year' => '2000',
                'title' => 'The Nigeria milestone',
                'body' => 'Entry into Nigeria lifts export sales by 25% and opens wider expansion across Africa; Honduras joins the map in Central America.',
                'icon' => 'faGlobe',
                'image' => 'images/about/africa-nigeria.svg',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 20,
                'i18n' => [
                    'fr' => [
                        'title' => 'L’étape du Nigeria',
                        'body' => 'L’entrée au Nigeria fait progresser les exportations de 25 % et ouvre une expansion plus large en Afrique ; le Honduras rejoint la carte en Amérique centrale.',
                    ],
                    'es' => [
                        'title' => 'El hito de Nigeria',
                        'body' => 'La entrada en Nigeria eleva las exportaciones un 25 % y abre una expansión más amplia por África; Honduras se suma al mapa en América Central.',
                    ],
                ],
            ],
            [
                'year' => '2002',
                'title' => 'Beyond ampoules',
                'body' => 'The range diversifies from water-for-injections into a broader pharmaceutical formulations portfolio for export markets.',
                'icon' => 'faBox',
                'image' => 'images/products/sierra-leone/amoximak-250-sp.webp',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 30,
                'i18n' => [
                    'fr' => [
                        'title' => 'Au-delà des ampoules',
                        'body' => 'La gamme se diversifie de l’eau pour injectables vers un portefeuille de formulations pharmaceutiques plus large pour l’export.',
                    ],
                    'es' => [
                        'title' => 'Más allá de las ampollas',
                        'body' => 'La gama se diversifica del agua para inyectables hacia una cartera más amplia de formulaciones farmacéuticas para exportación.',
                    ],
                ],
            ],
            [
                'year' => '2004',
                'title' => 'IV fluids & infusions',
                'body' => 'Large-volume parenterals join the line: saline, dextrose, Ringer lactate and multi-electrolyte infusions.',
                'icon' => 'faDroplet',
                'image' => 'images/products/liberia/athermak-inj.webp',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 40,
                'i18n' => [
                    'fr' => [
                        'title' => 'Solutés IV & perfusions',
                        'body' => 'Les parenteraux à grand volume rejoignent la ligne: chlorure de sodium, glucose, lactate de Ringer et perfusions multi-électrolytes.',
                    ],
                    'es' => [
                        'title' => 'Fluidos IV y perfusiones',
                        'body' => 'Los parenterales de gran volumen se incorporan: cloruro de sodio, glucosa, lactato de Ringer y perfusiones multielectrolíticas.',
                    ],
                ],
            ],
            [
                'year' => '2006',
                'title' => 'Devices & disposables',
                'body' => 'IV access, infusion sets, syringes and patient-care consumables extend Nymak beyond medicines.',
                'icon' => 'faSyringe',
                'image' => null,
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 50,
                'i18n' => [
                    'fr' => [
                        'title' => 'Dispositifs & consommables',
                        'body' => 'Accès IV, perfuseurs, seringues et consommables de soins prolongent Nymak au-delà des médicaments.',
                    ],
                    'es' => [
                        'title' => 'Dispositivos y desechables',
                        'body' => 'Acceso IV, equipos de infusión, jeringas y consumibles de cuidado del paciente extienden a Nymak más allá de los medicamentos.',
                    ],
                ],
            ],
            [
                'year' => '2008',
                'title' => 'Quality in-house',
                'body' => 'A dedicated quality control laboratory is established: every batch analysed before release.',
                'icon' => 'faFlask',
                'image' => null,
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 60,
                'i18n' => [
                    'fr' => [
                        'title' => 'La qualité en interne',
                        'body' => 'Un laboratoire de contrôle qualité dédié est créé: chaque lot analysé avant libération.',
                    ],
                    'es' => [
                        'title' => 'La calidad en casa',
                        'body' => 'Se crea un laboratorio de control de calidad dedicado: cada lote analizado antes de su liberación.',
                    ],
                ],
            ],
            [
                'year' => '2010',
                'title' => 'Rapid diagnostics',
                'body' => 'Rapid test kits for malaria, typhoid and HIV join the portfolio for public-health programmes.',
                'icon' => 'faMicroscope',
                'image' => 'images/products/liberia/alumak-sp.webp',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 70,
                'i18n' => [
                    'fr' => [
                        'title' => 'Diagnostics rapides',
                        'body' => 'Des tests rapides pour le paludisme, la typhoïde et le VIH rejoignent le portefeuille pour les programmes de santé publique.',
                    ],
                    'es' => [
                        'title' => 'Diagnóstico rápido',
                        'body' => 'Pruebas rápidas de malaria, fiebre tifoidea y VIH se incorporan a la cartera para programas de salud pública.',
                    ],
                ],
            ],
            [
                'year' => '2012',
                'title' => 'Regulatory under one roof',
                'body' => 'Dossier preparation, market registration support and compliant packaging design brought in-house.',
                'icon' => 'faFileCircleCheck',
                'image' => null,
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 80,
                'i18n' => [
                    'fr' => [
                        'title' => 'Le réglementaire sous un même toit',
                        'body' => 'Préparation des dossiers, support d’enregistrement et design d’emballages conformes internalisés.',
                    ],
                    'es' => [
                        'title' => 'Regulación bajo un mismo techo',
                        'body' => 'Preparación de dossiers, soporte de registro y diseño de empaque conforme internalizados.',
                    ],
                ],
            ],
            [
                'year' => '2014',
                'title' => 'ISO 13485 certified',
                'body' => 'The quality management system is certified for medical device manufacturing.',
                'icon' => 'faCircleCheck',
                'image' => 'images/certifications/iso-13485-certificate.webp',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 90,
                'i18n' => [
                    'fr' => [
                        'title' => 'Certifié ISO 13485',
                        'body' => 'Le système de management de la qualité est certifié pour la fabrication de dispositifs médicaux.',
                    ],
                    'es' => [
                        'title' => 'Certificación ISO 13485',
                        'body' => 'El sistema de gestión de calidad se certifica para la fabricación de dispositivos médicos.',
                    ],
                ],
            ],
            [
                'year' => '2016',
                'title' => 'The branded range',
                'body' => 'Alumak, Cefmak, Cipromak and sister brands register across West African markets.',
                'icon' => 'faTag',
                'image' => 'images/products/liberia/alumak-80-480-tab.webp',
                'image_2' => 'images/products/liberia/cefmak-inj.webp',
                'fit' => 'cover',
                'sort_order' => 100,
                'i18n' => [
                    'fr' => [
                        'title' => 'La gamme de marque',
                        'body' => 'Alumak, Cefmak, Cipromak et leurs marques sœurs sont enregistrées sur les marchés d’Afrique de l’Ouest.',
                    ],
                    'es' => [
                        'title' => 'La gama de marca',
                        'body' => 'Alumak, Cefmak, Cipromak y marcas hermanas se registran en mercados de África Occidental.',
                    ],
                ],
            ],
            [
                'year' => '2018',
                'title' => 'UK office opens',
                'body' => 'A London presence brings partner-facing regulatory and commercial support closer to market.',
                'icon' => 'faBuilding',
                'image' => 'images/flags/gb.svg',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 110,
                'i18n' => [
                    'fr' => [
                        'title' => 'Ouverture du bureau au Royaume-Uni',
                        'body' => 'Une présence à Londres rapproche le support réglementaire et commercial des partenaires.',
                    ],
                    'es' => [
                        'title' => 'Apertura de la oficina en el Reino Unido',
                        'body' => 'Una presencia en Londres acerca el soporte regulatorio y comercial a los socios.',
                    ],
                ],
            ],
            [
                'year' => '2020',
                'title' => 'Through the pandemic',
                'body' => 'Essential medicines, IV fluids and disposables keep flowing to partner markets through global disruption.',
                'icon' => 'faShieldHalved',
                'image' => 'images/hero/facility-aerial.webp',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 120,
                'i18n' => [
                    'fr' => [
                        'title' => 'À travers la pandémie',
                        'body' => 'Médicaments essentiels, solutés IV et consommables continuent d’affluer vers les marchés partenaires malgré la crise mondiale.',
                    ],
                    'es' => [
                        'title' => 'A través de la pandemia',
                        'body' => 'Medicamentos esenciales, fluidos IV y desechables siguen fluyendo hacia los mercados socios durante la disrupción global.',
                    ],
                ],
            ],
            [
                'year' => '2022',
                'title' => 'Star Export House',
                'body' => 'The Government of India certifies Nymak a Star Export House in recognition of export performance.',
                'icon' => 'faAward',
                'image' => 'images/certifications/star-export-house.webp',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 130,
                'i18n' => [
                    'fr' => [
                        'title' => 'Star Export House',
                        'body' => 'Le gouvernement indien certifie Nymak Star Export House en reconnaissance de ses performances à l’export.',
                    ],
                    'es' => [
                        'title' => 'Star Export House',
                        'body' => 'El Gobierno de la India certifica a Nymak como Star Export House en reconocimiento a su desempeño exportador.',
                    ],
                ],
            ],
            [
                'year' => '2024',
                'title' => '24+ countries, 200+ containers',
                'body' => 'A record year: over 200 containers shipped in FY 2023–24, with offices in Sierra Leone and Liberia serving West Africa.',
                'icon' => 'faShip',
                'image' => 'images/about/early-dispatch.jpg',
                'image_2' => 'images/about/global-footprint.svg',
                'fit' => 'contain',
                'sort_order' => 140,
                'i18n' => [
                    'fr' => [
                        'title' => '24+ pays, 200+ conteneurs',
                        'body' => 'Une année record: plus de 200 conteneurs expédiés au cours de l’exercice 2023–24, avec des bureaux en Sierra Leone et au Liberia pour l’Afrique de l’Ouest.',
                    ],
                    'es' => [
                        'title' => '24+ países, 200+ contenedores',
                        'body' => 'Un año récord: más de 200 contenedores despachados en el ejercicio 2023–24, con oficinas en Sierra Leona y Liberia para África Occidental.',
                    ],
                ],
            ],
        ];

        foreach ($rows as $row) {
            JourneyItem::updateOrCreate(
                ['year' => $row['year'], 'title' => $row['title']],
                $row
            );
        }
    }
}
