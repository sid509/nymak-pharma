<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The requirements doc fixes meta descriptions at a strict 150-160
     * chars with the focus keyword inside, and assigns keywords only to
     * the 11 mapped pages. Earlier seeds ran 122-150 chars and carried
     * invented keywords on unmapped pages. Swap exact stale values and
     * null the off-map keyword fields so admin edits survive.
     */
    public function up(): void
    {
        $swaps = [
            'home' => [
                'A WHO-GMP certified pharmaceutical exporter in India, Nymak Pharma supplies IV fluids, medicines & devices to 24+ countries. Talk to our export team.',
                'Among pharma manufacturers in India, Nymak Pharma is a WHO-GMP certified exporter supplying IV fluids, medicines & medical devices to 24+ countries today.',
            ],
            'about' => [
                'Founded in 1998, Nymak Pharma is a pharmaceutical company based in Gujarat, India: a WHO-GMP certified Star Export House serving 24+ countries.',
                'Among pharmaceutical companies in India, Nymak Pharma stands apart: founded 1998 in Gujarat, a WHO-GMP certified Star Export House serving 24+ countries.',
            ],
            'manufacturing' => [
                'Inside our pharma manufacturing facility in Mundra: WHO-GMP production, in-house QC lab, QA release, regulatory and warehouse teams. See the facility.',
                'Among drug manufacturing companies in India, our Mundra WHO-GMP facility runs in-house QC, QA release, regulatory & warehouse teams. See the facility.',
            ],
            'quality' => [
                'WHO-GMP, ISO 13485 & Star Export House certified, with pharmaceutical registration support & dossier preparation for every destination market.',
                'Pharmaceutical regulatory services India exporters rely on: WHO-GMP & ISO 13485 certified, dossier preparation & registration support per destination market.',
            ],
            'products.index' => [
                'A pharmaceutical product supplier in India exporting IV fluids, finished formulations, medical devices & rapid test kits to 24+ markets.',
                'Pharmaceutical suppliers in India exporting IV fluids, finished formulations, medical devices & rapid test kits to 24+ global markets. Request the range.',
            ],
            'markets.index' => [
                'Nymak Pharma is a pharmaceutical exporter India trusts across 24+ countries: Africa, the Middle East, Asia & the South Pacific. Explore our markets.',
                'A pharmaceutical exporter India relies on across 24+ countries in Africa, the Middle East, Asia & the South Pacific. Explore our global market map today.',
            ],
            'ahmedabad' => [
                'A pharma manufacturing company in Ahmedabad: our corporate office runs regulatory, design & exports beside the WHO-GMP works at Mundra, Gujarat.',
                'A pharma manufacturing company in Ahmedabad, Gujarat: corporate office for regulatory, design & exports beside the WHO-GMP works at Mundra, Gujarat, India.',
            ],
            'team.index' => [
                'Meet the team behind Nymak Pharma: leadership and specialists in exports, regulatory affairs, quality control, logistics & design in Gujarat, India.',
                'Meet the team behind Nymak Pharma: leadership and specialists in exports, regulatory affairs, quality control, logistics & design in Gujarat, India today.',
            ],
            'inside' => [
                'An interactive walk through Nymak Pharma, from a 1998 startup in Mundra to a pharmaceutical export company trusted across 24+ countries.',
                'An interactive walk through Nymak Pharma: from a 1998 startup in Mundra to a pharmaceutical export company trusted across 24+ export countries worldwide.',
            ],
            'posts.index' => [
                'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified exporter in Gujarat, India.',
                'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified exporter in Gujarat, India. Read the journal.',
            ],
            'faqs' => [
                'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership from Nymak Pharma, a pharmaceutical exporter in India.',
                'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership enquiries from Nymak Pharma, a pharmaceutical exporter in India today.',
            ],
            'contact' => [
                'Contact our pharmaceutical company in India for export enquiries, distribution & tenders: offices in Gujarat, the UK, Sierra Leone & Liberia.',
                'Contact a pharmaceutical company in India for export enquiries, distribution & tenders: offices in Gujarat, the UK, Sierra Leone & Liberia, West Africa.',
            ],
            'privacy' => [
                'How Nymak Pharma collects, uses and protects personal data submitted through this website, and how to reach our data team.',
                'How Nymak Pharma collects, uses and protects the personal data submitted through this website, and how to reach our data team with privacy questions today.',
            ],
            'terms' => [
                'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products and services.',
                'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products, services and export terms of use here.',
            ],
        ];

        foreach ($swaps as $key => [$old, $new]) {
            DB::table('page_metas')->where('key', $key)->where('meta_description', $old)
                ->update(['meta_description' => $new]);
        }

        // posts.index reached "…certified company…" via the earlier refresh
        // migration rather than the seeder value, so match that chain too.
        DB::table('page_metas')->where('key', 'posts.index')
            ->where('meta_description', 'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified company in Gujarat, India.')
            ->update(['meta_description' => 'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified exporter in Gujarat, India. Read the journal.']);

        // Legal pages render under 50 chars; extend titles into the band.
        DB::table('page_metas')->where('key', 'privacy')
            ->where('meta_title', 'Privacy Policy & Data Use')
            ->update(['meta_title' => 'Privacy Policy, Data Use & Your Rights']);
        DB::table('page_metas')->where('key', 'terms')
            ->where('meta_title', 'Terms of Use & Conditions')
            ->update(['meta_title' => 'Terms of Use & Conditions of This Site']);

        // Keyword map covers only 11 pages; clear invented values on the rest.
        $invented = [
            'team.index' => [
                'nymak pharma team',
                'pharmaceutical export team India; pharma company leadership Gujarat',
                'regulatory affairs team; quality control team; export managers',
            ],
            'inside' => [
                'inside nymak pharma',
                'nymak pharma company story; pharmaceutical export journey India',
                'pharma company history; indian pharmaceutical exporters',
            ],
            'posts.index' => [
                'pharmaceutical export insights',
                'pharma export company blog India; pharmaceutical quality explainers',
                'pharmaceutical industry news; export compliance resources',
            ],
            'faqs' => [
                'pharmaceutical export faqs',
                'iv fluids supplier India faq; pharmaceutical exporter questions',
                'who-gmp certification; pharma partnership; product registration',
            ],
        ];

        foreach ($invented as $key => [$focus, $longTail, $secondary]) {
            DB::table('page_metas')->where('key', $key)->where('focus_keyword', $focus)
                ->update(['focus_keyword' => null]);
            DB::table('page_metas')->where('key', $key)->where('long_tail_keywords', $longTail)
                ->update(['long_tail_keywords' => null]);
            DB::table('page_metas')->where('key', $key)->where('secondary_keywords', $secondary)
                ->update(['secondary_keywords' => null]);
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
