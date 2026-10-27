<?php

namespace Database\Seeders;

use App\Models\JourneyItem;
use Illuminate\Database\Seeder;

class JourneyItemSeeder extends Seeder
{
    /**
     * The first cut seeded the old 14-entry story before the design's own
     * milestones were known. These (year, title) pairs are removed so the
     * reference timeline below is the only seeded set - anything an admin
     * added by hand is untouched.
     */
    private const LEGACY = [
        ['1998', 'Founded in Gujarat'],
        ['2000', 'The Nigeria milestone'],
        ['2002', 'Beyond ampoules'],
        ['2004', 'IV fluids & infusions'],
        ['2006', 'Devices & disposables'],
        ['2008', 'Quality in-house'],
        ['2010', 'Rapid diagnostics'],
        ['2012', 'Regulatory under one roof'],
        ['2014', 'ISO 13485 certified'],
        ['2016', 'The branded range'],
        ['2018', 'UK office opens'],
        ['2020', 'Through the pandemic'],
        ['2022', 'Star Export House'],
        ['2024', '24+ countries, 200+ containers'],
    ];

    public function run(): void
    {
        foreach (self::LEGACY as [$year, $title]) {
            JourneyItem::where('year', $year)->where('title', $title)->delete();
        }

        $rows = [
            [
                'year' => '1998',
                'title' => 'The journey begins',
                'body' => 'Founded by Mr. Ranjit Advani. First export shipment to Papua New Guinea.',
                'icon' => 'faSeedling',
                'image' => 'images/about/founder-1998.png',
                'image_2' => 'images/about/early-consignment.jpg',
                'fit' => 'cover',
                'sort_order' => 10,
                'i18n' => [
                    'fr' => ['title' => 'Le début du voyage', 'body' => 'Fondée par M. Ranjit Advani. Premier envoi exporté vers la Papouasie-Nouvelle-Guinée.'],
                    'es' => ['title' => 'El comienzo del viaje', 'body' => 'Fundada por el Sr. Ranjit Advani. Primer envío de exportación a Papúa Nueva Guinea.'],
                ],
            ],
            [
                'year' => '2000',
                'title' => 'Entering Nigeria',
                'body' => 'Nigeria became our first African market.',
                'icon' => 'faGlobe',
                'image' => 'images/about/africa-nigeria.svg',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 20,
                'i18n' => [
                    'fr' => ['title' => 'Entrée au Nigeria', 'body' => 'Le Nigeria devient notre premier marché africain.'],
                    'es' => ['title' => 'Entrada en Nigeria', 'body' => 'Nigeria se convierte en nuestro primer mercado africano.'],
                ],
            ],
            [
                'year' => '2005',
                'title' => 'Expanding across markets',
                'body' => 'Growing our international footprint.',
                'icon' => 'faGlobe',
                'image' => 'images/about/world-dots.svg',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 30,
                'i18n' => [
                    'fr' => ['title' => 'Expansion sur les marchés', 'body' => 'Une empreinte internationale grandissante.'],
                    'es' => ['title' => 'Expansión en los mercados', 'body' => 'Una huella internacional en crecimiento.'],
                ],
            ],
            [
                'year' => '2010',
                'title' => 'Expanding our portfolio',
                'body' => 'A broader range of pharmaceutical and healthcare products.',
                'icon' => 'faBox',
                'image' => 'images/products/liberia/alumak-sp.webp',
                'image_2' => 'images/products/liberia/cefmak-inj.webp',
                'fit' => 'cover',
                'sort_order' => 40,
                'i18n' => [
                    'fr' => ['title' => 'Élargissement du portefeuille', 'body' => 'Une gamme plus large de produits pharmaceutiques et de santé.'],
                    'es' => ['title' => 'Ampliación del portafolio', 'body' => 'Una gama más amplia de productos farmacéuticos y sanitarios.'],
                ],
            ],
            [
                'year' => '2015',
                'title' => 'Diversifying beyond pharmaceuticals',
                'body' => 'Ventured into non-pharma product (through Coral Marketing).',
                'icon' => 'faDroplet',
                'image' => 'images/about/early-dispatch.jpg',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 50,
                'i18n' => [
                    'fr' => ['title' => 'Diversification au-delà du pharma', 'body' => 'Entrée dans les produits non pharmaceutiques (via Coral Marketing).'],
                    'es' => ['title' => 'Diversificación más allá del pharma', 'body' => 'Entrada en productos no farmacéuticos (a través de Coral Marketing).'],
                ],
            ],
            [
                'year' => '2020',
                'title' => 'Acquisition of Vifor Pharma',
                'body' => 'Strengthening our pharmaceutical capabilities.',
                'icon' => 'faBuilding',
                'image' => 'images/hero/facility-aerial.webp',
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 60,
                'i18n' => [
                    'fr' => ['title' => 'Acquisition de Vifor Pharma', 'body' => 'Renforcement de nos capacités pharmaceutiques.'],
                    'es' => ['title' => 'Adquisición de Vifor Pharma', 'body' => 'Fortalecimiento de nuestras capacidades farmacéuticas.'],
                ],
            ],
            [
                'year' => '2023',
                'title' => 'Star Export House',
                'body' => 'Recognition of our growing export presence.',
                'icon' => 'faAward',
                'image' => 'images/certifications/star-export-house-certificate.webp',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 70,
                'i18n' => [
                    'fr' => ['title' => 'Star Export House', 'body' => 'Reconnaissance de notre présence export grandissante.'],
                    'es' => ['title' => 'Star Export House', 'body' => 'Reconocimiento de nuestra creciente presencia exportadora.'],
                ],
            ],
            [
                'year' => '2025',
                'title' => 'Establishing our African presence',
                'body' => 'Owned distribution operations in Sierra Leone & Liberia.',
                'icon' => 'faLocationDot',
                'image' => 'images/clients/core-africa-liberia-inc.webp',
                'image_2' => 'images/flags/sl.svg',
                'fit' => 'contain',
                'sort_order' => 80,
                'i18n' => [
                    'fr' => ['title' => 'Implantation en Afrique', 'body' => 'Opérations de distribution en propre en Sierra Leone et au Liberia.'],
                    'es' => ['title' => 'Establecimiento en África', 'body' => 'Operaciones de distribución propias en Sierra Leona y Liberia.'],
                ],
            ],
            [
                'year' => '2026',
                'title' => 'Strengthening our infrastructure',
                'body' => 'New corporate warehouse and office building.',
                'icon' => 'faWarehouse',
                'image' => null,
                'image_2' => null,
                'fit' => 'cover',
                'sort_order' => 90,
                'i18n' => [
                    'fr' => ['title' => 'Renforcement des infrastructures', 'body' => 'Nouvel entrepôt et immeuble de bureaux.'],
                    'es' => ['title' => 'Fortalecimiento de la infraestructura', 'body' => 'Nuevo almacén corporativo y edificio de oficinas.'],
                ],
            ],
            [
                'year' => '2026',
                'title' => 'Ahmedabad corporate office',
                'body' => 'Expanding our corporate capabilities.',
                'icon' => 'faBuilding',
                'image' => 'images/brand/nymak-symbol.png',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 100,
                'i18n' => [
                    'fr' => ['title' => 'Bureau corporate d’Ahmedabad', 'body' => 'Extension de nos capacités corporatives.'],
                    'es' => ['title' => 'Oficina corporativa de Ahmedabad', 'body' => 'Ampliación de nuestras capacidades corporativas.'],
                ],
            ],
            [
                'year' => '2026',
                'title' => 'Building our own brands',
                'body' => 'Ethical marketing in Burkina Faso, Chad & Cameroon.',
                'icon' => 'faTag',
                'image' => 'images/about/africa-expansion.svg',
                'image_2' => null,
                'fit' => 'contain',
                'sort_order' => 110,
                'i18n' => [
                    'fr' => ['title' => 'Construction de nos marques', 'body' => 'Marketing éthique au Burkina Faso, au Tchad et au Cameroun.'],
                    'es' => ['title' => 'Construyendo nuestras marcas', 'body' => 'Marketing ético en Burkina Faso, Chad y Camerún.'],
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
