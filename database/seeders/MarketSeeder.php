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
                'description' => 'Nymak Pharma serves Sierra Leone through its authorised office in Freetown, supplying a registered portfolio of branded formulations — including the Alumak, Amoximak, Clavmak and Zincomak ranges — to hospitals, pharmacies and public health programmes.',
                'show_in_portfolio' => true, 'sort_order' => 1],
            ['name' => 'Liberia', 'slug' => 'liberia', 'iso_code' => 'LR', 'region' => 'West Africa',
                'description' => 'Through Core Africa Liberia Inc. in Paynesville, Nymak Pharma supplies the Liberian market with antimalarials, antibiotics, nutritional formulations and injectables under the Nymak branded range.',
                'show_in_portfolio' => true, 'sort_order' => 2],
            ['name' => 'Nigeria', 'slug' => 'nigeria', 'iso_code' => 'NG', 'region' => 'West Africa',
                'description' => 'Nymak Pharma entered the Nigerian market in 2000 — a milestone that lifted export volumes by 25% and opened the company\'s wider expansion across the African continent.',
                'show_in_portfolio' => true, 'sort_order' => 3],

            // Named markets without dedicated pages (requirement #9 — no thin duplicates).
            ['name' => 'Ghana', 'slug' => 'ghana', 'iso_code' => 'GH', 'region' => 'West Africa', 'sort_order' => 4],
            ['name' => 'Somalia', 'slug' => 'somalia', 'iso_code' => 'SO', 'region' => 'East Africa', 'sort_order' => 5],
            ['name' => 'Kenya', 'slug' => 'kenya', 'iso_code' => 'KE', 'region' => 'East Africa', 'sort_order' => 6],
            ['name' => 'DR Congo', 'slug' => 'dr-congo', 'iso_code' => 'CD', 'region' => 'Central Africa', 'sort_order' => 7],
            ['name' => 'Cameroon', 'slug' => 'cameroon', 'iso_code' => 'CM', 'region' => 'Central Africa', 'sort_order' => 8],
            ['name' => 'Mauritania', 'slug' => 'mauritania', 'iso_code' => 'MR', 'region' => 'West Africa', 'sort_order' => 9],
            ['name' => 'Honduras', 'slug' => 'honduras', 'iso_code' => 'HN', 'region' => 'Central America', 'sort_order' => 10],
            ['name' => 'South Pacific Islands', 'slug' => 'south-pacific', 'iso_code' => null, 'region' => 'Oceania',
                'description' => 'Nymak Pharma\'s first export region — the company began by supplying Sterilized Water for Injections BP to island markets across the South Pacific in 1998.',
                'sort_order' => 11],
        ];

        foreach ($markets as $market) {
            Market::create($market);
        }
    }
}
