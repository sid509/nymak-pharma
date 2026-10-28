<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        // Client review (content plan, change log): Ghana is not a verified
        // active market: keep it out of the seeded list and the live DB.
        Market::where('slug', 'ghana')->delete();

        // 26.10 comments: Honduras is not in the shared country list, and the
        // grouped South Pacific entry is replaced by the named island markets.
        Market::whereIn('slug', ['honduras', 'south-pacific'])->delete();

        // Categories from the client-provided map list (26.10.2026):
        //   presence - our own offices/works (pinned at the office city)
        //   ethical  - ethical markets
        //   partner  - partner markets
        $markets = [
            // Our presence: pinned on the office city, not the country centre.
            ['name' => 'Sierra Leone', 'slug' => 'sierra-leone', 'iso_code' => 'SL', 'region' => 'West Africa', 'pin_type' => 'presence',
                'latitude' => 8.49, 'longitude' => -13.23,
                'description' => 'Authorised office in Freetown supplying a registered branded portfolio to hospitals, pharmacies and public health programmes.',
                'content' => '<p>Nymak Pharma serves Sierra Leone through its authorised office in Freetown, supplying a registered portfolio of branded formulations to hospitals, pharmacies and public health programmes.</p><h3>What we do here</h3><ul><li>Registered Nymak brands: the <strong>Alumak</strong>, <strong>Amoximak</strong>, <strong>Clavmak</strong> and <strong>Zincomak</strong> ranges</li><li>Local office handling tenders, regulatory follow-up and distributor support</li><li>IV fluids, antibiotics and nutritional formulations for public health programmes</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 1],
            ['name' => 'Liberia', 'slug' => 'liberia', 'iso_code' => 'LR', 'region' => 'West Africa', 'pin_type' => 'presence',
                'latitude' => 6.40, 'longitude' => -10.62,
                'description' => 'Supplied through Core Africa Liberia Inc. in Paynesville: antimalarials, antibiotics, nutritionals and injectables.',
                'content' => '<p>Through <strong>Core Africa Liberia Inc.</strong> in Paynesville, Nymak Pharma supplies the Liberian market with antimalarials, antibiotics, nutritional formulations and injectables under the Nymak branded range.</p><h3>What we do here</h3><ul><li>Branded antimalarial and antibiotic ranges registered with the LMHRA</li><li>Injectables and IV fluids for hospital supply</li><li>On-the-ground partner office for distribution and pharmacovigilance</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 2],

            // Ethical markets.
            ['name' => 'Cameroon', 'slug' => 'cameroon', 'iso_code' => 'CM', 'region' => 'Central Africa', 'pin_type' => 'ethical', 'sort_order' => 3],
            ['name' => 'Chad', 'slug' => 'chad', 'iso_code' => 'TD', 'region' => 'Central Africa', 'pin_type' => 'ethical', 'sort_order' => 4],
            ['name' => 'Burkina Faso', 'slug' => 'burkina-faso', 'iso_code' => 'BF', 'region' => 'West Africa', 'pin_type' => 'ethical', 'sort_order' => 5],

            // Partner markets.
            ['name' => 'Nigeria', 'slug' => 'nigeria', 'iso_code' => 'NG', 'region' => 'West Africa', 'pin_type' => 'partner',
                'description' => 'Our 2000 entry into Nigeria lifted exports by 25% and opened wider expansion across Africa.',
                'content' => '<p>Nymak Pharma entered the Nigerian market in 2000, a milestone that lifted export volumes by 25% and opened the company\'s wider expansion across the African continent.</p><h3>What we do here</h3><ul><li>Finished formulations and IV fluids supplied through established distributors</li><li>NAFDAC registration support from our in-house regulatory team</li><li>Long-standing relationships with hospital groups and procurement agencies</li></ul>',
                'show_in_portfolio' => true, 'sort_order' => 6],
            ['name' => 'Senegal', 'slug' => 'senegal', 'iso_code' => 'SN', 'region' => 'West Africa', 'pin_type' => 'partner', 'sort_order' => 7],
            ['name' => 'Mauritania', 'slug' => 'mauritania', 'iso_code' => 'MR', 'region' => 'West Africa', 'pin_type' => 'partner', 'sort_order' => 8],
            ['name' => 'Angola', 'slug' => 'angola', 'iso_code' => 'AO', 'region' => 'Central Africa', 'pin_type' => 'partner', 'sort_order' => 9],
            ['name' => 'DR Congo', 'slug' => 'dr-congo', 'iso_code' => 'CD', 'region' => 'Central Africa', 'pin_type' => 'partner', 'sort_order' => 10],
            ['name' => 'Kenya', 'slug' => 'kenya', 'iso_code' => 'KE', 'region' => 'East Africa', 'pin_type' => 'partner', 'sort_order' => 11],
            ['name' => 'Somalia', 'slug' => 'somalia', 'iso_code' => 'SO', 'region' => 'East Africa', 'pin_type' => 'partner', 'sort_order' => 12],
            ['name' => 'Burundi', 'slug' => 'burundi', 'iso_code' => 'BI', 'region' => 'East Africa', 'pin_type' => 'partner', 'sort_order' => 13],
            ['name' => 'Malawi', 'slug' => 'malawi', 'iso_code' => 'MW', 'region' => 'Southern Africa', 'pin_type' => 'partner', 'sort_order' => 14],
            ['name' => 'South Africa', 'slug' => 'south-africa', 'iso_code' => 'ZA', 'region' => 'Southern Africa', 'pin_type' => 'partner', 'sort_order' => 15],
            ['name' => 'Iraq', 'slug' => 'iraq', 'iso_code' => 'IQ', 'region' => 'Middle East', 'pin_type' => 'partner', 'sort_order' => 16],
            ['name' => 'Azerbaijan', 'slug' => 'azerbaijan', 'iso_code' => 'AZ', 'region' => 'Central Asia', 'pin_type' => 'partner', 'sort_order' => 17],
            ['name' => 'Philippines', 'slug' => 'philippines', 'iso_code' => 'PH', 'region' => 'Southeast Asia', 'pin_type' => 'partner', 'sort_order' => 18],
            ['name' => 'Papua New Guinea', 'slug' => 'papua-new-guinea', 'iso_code' => 'PG', 'region' => 'Oceania', 'pin_type' => 'partner',
                'description' => 'Nymak Pharma\'s first export region: the company began by supplying Sterilized Water for Injections BP to South Pacific island markets in 1998.',
                'sort_order' => 19],
            ['name' => 'Solomon Islands', 'slug' => 'solomon-islands', 'iso_code' => 'SB', 'region' => 'Oceania', 'pin_type' => 'partner', 'sort_order' => 20],
            ['name' => 'Vanuatu', 'slug' => 'vanuatu', 'iso_code' => 'VU', 'region' => 'Oceania', 'pin_type' => 'partner', 'sort_order' => 21],
            ['name' => 'Tonga', 'slug' => 'tonga', 'iso_code' => 'TO', 'region' => 'Oceania', 'pin_type' => 'partner', 'sort_order' => 22],
            ['name' => 'Fiji', 'slug' => 'fiji', 'iso_code' => 'FJ', 'region' => 'Oceania', 'pin_type' => 'partner', 'sort_order' => 23],
            ['name' => 'Western Samoa', 'slug' => 'western-samoa', 'iso_code' => 'WS', 'region' => 'Oceania', 'pin_type' => 'partner', 'sort_order' => 24],
        ];

        // Keyed on slug so re-seeding (deploy runs `migrate --force --seed`)
        // updates rows instead of duplicating them.
        foreach ($markets as $market) {
            Market::updateOrCreate(['slug' => $market['slug']], $market);
        }
    }
}
