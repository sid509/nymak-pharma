<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Seed only the defaults that must exist for the site to look right -
     * firstOrCreate so a later admin upload/override always wins.
     */
    public function run(): void
    {
        SiteSetting::firstOrCreate(
            ['key' => 'logo'],
            ['value' => 'images/brand/nymak-logo.png']
        );
    }
}
