<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The layout renders "{meta_title} | Nymak Pharma", so the stored title
     * must sit near 35-45 chars for the full <title> to stay inside the 50-60
     * char SEO band. Earlier seeded titles ran 50-62 and rendered 65-77.
     * Swap only exact stale values so admin edits survive.
     */
    public function up(): void
    {
        $swaps = [
            'home' => ['Pharma Manufacturers in India: WHO-GMP Certified Exporter', 'Pharma Manufacturers in India: WHO-GMP'],
            'about' => ['Pharmaceutical Companies in India: Our Story Since 1998', 'Pharmaceutical Companies in India Since 1998'],
            'manufacturing' => ['Drug Manufacturing Companies in India: Mundra Facility', 'Drug Manufacturing Companies in India: Mundra'],
            'quality' => ['Pharmaceutical Regulatory Services India: WHO-GMP & ISO', 'Pharmaceutical Regulatory Services India'],
            'products.index' => ['Pharmaceutical Suppliers in India: Export Product Range', 'Pharmaceutical Suppliers in India: 300+ Items'],
            'markets.index' => ['Pharmaceutical Exporter India: 24+ Countries Served', 'Pharmaceutical Exporter India: 24+ Markets'],
            'ahmedabad' => ['Pharma Manufacturing Company in Ahmedabad, Gujarat', 'Pharma Manufacturing Company in Ahmedabad'],
            'team.index' => ['The Team Behind Our Pharmaceutical Exports', 'Nymak Pharma Team: Leaders & Specialists'],
            'inside' => ['Inside Nymak Pharma: An Interactive Story', 'Inside Nymak Pharma: Our Interactive Story'],
            'posts.index' => ['Pharmaceutical Export Insights & Resources', 'Pharmaceutical Export Insights & News'],
            'faqs' => ['Pharmaceutical Export FAQs: Products & Certifications', 'Pharmaceutical Export FAQs: India Exporter'],
            'contact' => ['Pharmaceutical Company in India: Contact & Enquiries', 'Pharmaceutical Company in India: Contact'],
            'privacy' => ['Privacy Policy', 'Privacy Policy & Data Use'],
            'terms' => ['Terms of Use', 'Terms of Use & Conditions'],
        ];

        foreach ($swaps as $key => [$old, $new]) {
            DB::table('page_metas')->where('key', $key)->where('meta_title', $old)->update(['meta_title' => $new]);
        }

        DB::table('product_categories')->where('slug', 'iv-fluids')->where('meta_title', 'IV Fluid Manufacturer in India: Large-Volume Parenterals')->update(['meta_title' => 'IV Fluid Manufacturer in India: WHO-GMP']);
        DB::table('product_categories')->where('slug', 'finished-formulations')->where('meta_title', 'Finished Formulations Manufacturer & Exporter India')->update(['meta_title' => 'Pharmaceutical Finished Formulations']);
        DB::table('product_categories')->where('slug', 'medical-devices-and-disposables')->where('meta_title', 'Medical Device Manufacturers in India: IV Access & Consumables')->update(['meta_title' => 'Medical Device Manufacturers in India']);
        DB::table('product_categories')->where('slug', 'rapid-diagnostic-kits')->where('meta_title', 'Diagnostic Products Manufacturer in India: Rapid Test Kits')->update(['meta_title' => 'Diagnostic Products Manufacturer in India']);
        DB::table('posts')->where('meta_title', 'Nymak Pharma Journey: 1998 to 24+ Export Countries')->update(['meta_title' => 'Nymak Pharma Journey: 24+ Export Countries']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
