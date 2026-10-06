<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        // Only markets with verified presence are seeded. The brochure cites
        // 24+ countries overall; named markets are listed here rather than
        // fabricating the remainder.
        $markets = [
            // Markets with dedicated pages — real content exists (offices + branded portfolio).
            ['name' => 'Sierra Leone', 'slug' => 'sierra-leone', 'iso_code' => 'SL', 'region' => 'West Africa',
                'description' => 'Authorised office in Freetown supplying a registered branded portfolio to hospitals, pharmacies and public health programmes.',
                'content' => '<p>Nymak Pharma serves Sierra Leone through its authorised office in Freetown, supplying a registered portfolio of branded formulations to hospitals, pharmacies and public health programmes.</p><h3>What we do here</h3><ul><li>Registered Nymak brands — the <strong>Alumak</strong>, <strong>Amoximak</strong>, <strong>Clavmak</strong> and <strong>Zincomak</strong> ranges</li><li>Local office handling tenders, regulatory follow-up and distributor support</li><li>IV fluids, antibiotics and nutritional formulations for public health programmes</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 1],
            ['name' => 'Liberia', 'slug' => 'liberia', 'iso_code' => 'LR', 'region' => 'West Africa',
                'description' => 'Supplied through Core Africa Liberia Inc. in Paynesville — antimalarials, antibiotics, nutritionals and injectables.',
                'content' => '<p>Through <strong>Core Africa Liberia Inc.</strong> in Paynesville, Nymak Pharma supplies the Liberian market with antimalarials, antibiotics, nutritional formulations and injectables under the Nymak branded range.</p><h3>What we do here</h3><ul><li>Branded antimalarial and antibiotic ranges registered with the LMHRA</li><li>Injectables and IV fluids for hospital supply</li><li>On-the-ground partner office for distribution and pharmacovigilance</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 2],
            ['name' => 'Nigeria', 'slug' => 'nigeria', 'iso_code' => 'NG', 'region' => 'West Africa',
                'description' => 'Our 2000 entry into Nigeria lifted exports by 25% and opened wider expansion across Africa.',
                'content' => '<p>Nymak Pharma entered the Nigerian market in 2000 — a milestone that lifted export volumes by 25% and opened the company\'s wider expansion across the African continent.</p><h3>What we do here</h3><ul><li>Finished formulations and IV fluids supplied through established distributors</li><li>NAFDAC registration support from our in-house regulatory team</li><li>Long-standing relationships with hospital groups and procurement agencies</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 3],

            // Named markets without dedicated pages (requirement #9 — no thin duplicates).
            ['name' => 'Ghana', 'slug' => 'ghana', 'iso_code' => 'GH', 'region' => 'West Africa', 'sort_order' => 4],
            ['name' => 'Somalia', 'slug' => 'somalia', 'iso_code' => 'SO', 'region' => 'East Africa', 'sort_order' => 5],
            ['name' => 'Kenya', 'slug' => 'kenya', 'iso_code' => 'KE', 'region' => 'East Africa', 'sort_order' => 6],
            ['name' => 'DR Congo', 'slug' => 'dr-congo', 'iso_code' => 'CD', 'region' => 'Central Africa', 'sort_order' => 7],
            ['name' => 'Cameroon', 'slug' => 'cameroon', 'iso_code' => 'CM', 'region' => 'Central Africa', 'sort_order' => 8],
            ['name' => 'Mauritania', 'slug' => 'mauritania', 'iso_code' => 'MR', 'region' => 'West Africa', 'sort_order' => 9],
            ['name' => 'Honduras', 'slug' => 'honduras', 'iso_code' => 'HN', 'region' => 'Central America', 'sort_order' => 10],
            // Multi-country region: no single ISO code, so it is pinned on the map by coordinates.
            ['name' => 'South Pacific Islands', 'slug' => 'south-pacific', 'iso_code' => null, 'region' => 'Oceania',
                'latitude' => -17.7, 'longitude' => 178.0,
                'description' => 'Nymak Pharma\'s first export region — the company began by supplying Sterilized Water for Injections BP to island markets across the South Pacific in 1998.',
                'sort_order' => 11],
        ];

        foreach ($markets as $market) {
            Market::create($market);
        }
    }
}
