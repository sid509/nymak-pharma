<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MarketSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            FaqSeeder::class,
            PostSeeder::class,
            TestimonialSeeder::class,
            CertificationSeeder::class,
            TeamMemberSeeder::class,
            ClientLogoSeeder::class,
        ]);

        // Admin user for the enquiry inbox. Credentials come from the
        // environment — set NYMAK_ADMIN_EMAIL / NYMAK_ADMIN_PASSWORD.
        $email = env('NYMAK_ADMIN_EMAIL', 'admin@nymakpharma.com');
        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Nymak Admin',
                'password' => Hash::make(env('NYMAK_ADMIN_PASSWORD', 'change-me-in-production')),
            ]
        );
    }
}
