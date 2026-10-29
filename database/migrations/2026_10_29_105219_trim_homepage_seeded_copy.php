<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Homepage copy is capped at 800-1000 rendered words, so the long
     * seeded paragraphs were trimmed. Slots are materialised via
     * firstOrCreate, meaning rows holding the previous seeded defaults
     * would keep serving stale copy forever. Refresh exactly those
     * rows: any value an admin actually edited stays untouched.
     */
    public function up(): void
    {
        $swaps = [
            'hero_subtitle' => [
                'Your Reliable Partner in Efficacious Lifecare Solutions, trusted in 24 countries and counting. Among pharma manufacturers in India, Nymak Pharma stands apart: a WHO-GMP certified pharmaceutical company and Government of India recognised Star Export House supplying IV fluids, finished formulations, medical devices and rapid diagnostic kits.',
                'Trusted in 24 countries and counting. Among pharma manufacturers in India, Nymak Pharma stands apart: a WHO-GMP certified Star Export House supplying IV fluids, formulations, devices and diagnostics.',
            ],
            'about_p1' => [
                'Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with a single product: Sterilized Water for Injections BP in plastic ampoules, supplied to hospitals and medical stores across the South Pacific. From those beginnings we grew into Central America, then Nigeria in 2000, a milestone that lifted exports by 25% and opened our wider expansion across the African continent. Today that journey stands at more than 24 countries on four continents.',
                'Founded in 1998 by Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP supplied to hospitals across the South Pacific. Today the journey spans 24+ countries on four continents.',
            ],
            'about_p2' => [
                'What sets us apart among pharma companies in India is how much sits under one roof. Our WHO-GMP certified facility in Mundra, Gujarat is supported by an in-house regulatory team preparing product dossiers, a quality control laboratory analysing every batch, a separate QA function approving each release, and a design team producing compliant, market-ready packaging for each destination market. That structure is why partners describe us as a pharmaceutical company based in Gujarat they can actually audit, not just a name on a proforma invoice.',
                'What sets us apart among pharma companies in India is how much sits under one roof: a WHO-GMP facility in Mundra, Gujarat with in-house regulatory, QC laboratory, QA and design teams producing compliant, market-ready packaging.',
            ],
            'about_p3' => [
                'As a Government of India certified Star Export House, we shipped over 200 containers in FY 2023-24. For distributors comparing pharmaceutical suppliers in India, the difference is accountability: one team answers for the product, the paperwork, the packaging and the port. Whether the requirement is a tender for IV fluids, a branded range for a West African market, or registration support for a new territory, the same team that manufactures the product manages its documentation, labelling and dispatch.',
                'A Government of India certified Star Export House shipping 200+ containers in FY 2023-24, where one team answers for the product, the paperwork, the packaging and the port.',
            ],
            'portfolio_lead' => [
                'A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes, organised into four segments: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits. As pharmaceutical suppliers in India serving regulated and semi-regulated markets, every line item ships with the documentation its destination requires.',
                'A pharmaceutical export portfolio for hospitals, distributors, NGOs and public health programmes, organised into four segments: IV fluids, finished formulations, medical devices and rapid diagnostic kits.',
            ],
            'brands_lead' => [
                'Registered Nymak brands supplied across West African markets, each produced under WHO-GMP conditions and supported by our in-house regulatory and design teams: Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak and more.',
                'Registered Nymak brands supplied across West Africa under WHO-GMP conditions: Alumak, Cefmak, Cipromak, Zincomak and more.',
            ],
            'quality_body' => [
                'Every batch is analysed by our in-house QC laboratory and released only after QA review. Our regulatory team supports dossiers and product registrations in destination markets, which is what separates a verified pharmaceutical manufacturing company in India from a paper one. Each accolade reflects our deep-rooted commitment to quality, integrity and global healthcare excellence: the trust of our partners, the safety of our products, and the lives we strive to improve. WHO-GMP certification, ISO 13485:2016 quality systems, Star Export House status and Pharmexcil membership are maintained as living systems, audited regularly and verified by the partners and inspectors who visit the facility.',
                'Every batch is analysed by our in-house QC laboratory and released only after QA review. WHO-GMP, ISO 13485:2016, Star Export House and Pharmexcil systems are maintained as living, audited processes.',
            ],
            'faq_lead' => [
                'Straight answers about who we are, the products we supply, our WHO-GMP certifications and how we export to 24+ markets.',
                'Straight answers about who we are, what we make and how we export.',
            ],
            'cta_body' => [
                'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry. If you are comparing pharma manufacturers in India for your market, start the conversation here. Tell us your target market and product category, and we will come back with availability, documentation status and a realistic timeline.',
                'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry.',
            ],
            'global_body' => [
                'A pharmaceutical exporter India dispatches from to 24+ countries: operating across West, Central, East and Southern Africa, the Middle East, Asia and the South Pacific, with group companies and offices in the UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships. Our presence is structured in three ways: our own group companies, ethical markets where Nymak products are registered and promoted to prescribers, and partner markets supplied through appointed distributors who share our quality expectations.',
                'A pharmaceutical exporter India dispatches from to 24+ countries across Africa, the Middle East, Asia and the Pacific, with offices in the UK, Sierra Leone and Liberia.',
            ],
        ];

        foreach ($swaps as $key => [$old, $new]) {
            DB::table('page_contents')
                ->where('page', 'home')->where('key', $key)->where('value', $old)
                ->update(['value' => $new]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
