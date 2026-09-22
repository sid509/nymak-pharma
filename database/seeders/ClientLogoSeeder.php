<?php

namespace Database\Seeders;

use App\Models\ClientLogo;
use Illuminate\Database\Seeder;

class ClientLogoSeeder extends Seeder
{
    public function run(): void
    {
        $logos = [
            'davimed', 'prince-pharma', 'sam-pharma', 'satguru-group-logo',
            'syner-med-logo', 'trucare', 'unique-pharma-logo',
            'westgate-pharmaceuticals', 'xanaano-pharma-logo', 'zawadi-logo',
            'zee-pharma', 'core-africa-liberia-inc',
        ];

        foreach ($logos as $i => $slug) {
            ClientLogo::updateOrCreate(
                ['name' => ucwords(str_replace(['-logo', '-'], ['', ' '], $slug))],
                ['image' => "images/clients/{$slug}.webp", 'sort_order' => $i],
            );
        }
    }
}
