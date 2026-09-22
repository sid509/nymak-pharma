<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certifications = [
            ['WHO-GMP Certificate', 'Food & Drugs Control Administration, Gujarat',
                'Good Manufacturing Practices certification for the pharmaceutical manufacturing facility, covering quality systems, premises and processes.',
                'images/certifications/who-gmp.webp'],
            ['ISO 13485:2016', 'International Management Certification',
                'Quality management system certification covering medical devices and pharmaceutical manufacturing operations.',
                'images/certifications/iso.webp'],
            ['Star Export House', 'Government of India — DGFT',
                'Certificate of Recognition as a Star Export House, awarded for sustained export performance.',
                'images/certifications/star-export-house.webp'],
            ['Pharmexcil RCMC', 'Pharmaceuticals Export Promotion Council of India',
                'Registration-cum-Membership Certificate with India\'s pharmaceutical export promotion council.',
                'images/certifications/rx-india.webp'],
            ['Importer-Exporter Code (IEC)', 'Government of India',
                'Importer-Exporter Code registration authorising international trade operations.',
                null],
            ['GST Registration', 'Government of India',
                'Goods and Services Tax registration for Nymak Pharma Private Limited.',
                null],
        ];

        foreach ($certifications as $i => [$name, $issuer, $description, $image]) {
            Certification::create([
                'name' => $name,
                'issuer' => $issuer,
                'description' => $description,
                'image' => $image,
                'sort_order' => $i,
            ]);
        }
    }
}
