<?php

namespace Database\Seeders;

use App\Models\PageMeta;
use Illuminate\Database\Seeder;

/**
 * Seeds the content plan's SEO metadata into page_metas: unique titles,
 * 120-160 character descriptions and the keyword map from the requirements
 * doc (focus + 2-4 long-tail + 2-4 secondary keywords per indexable page).
 *
 * Titles are stored without the "| Nymak Pharma" suffix; app.blade.php
 * appends the site name at render time. Only empty fields are filled, so
 * admin edits made through /admin/seo-pages survive reseeds.
 */
class PageMetaSeeder extends Seeder
{
    public function run(): void
    {
        // key => [title, description, focus, long-tail (semicolon-separated),
        //         secondary (semicolon-separated)]
        $metas = [
            'home' => [
                'Pharma Manufacturers in India: WHO-GMP Certified Exporter',
                'A WHO-GMP certified pharmaceutical exporter in India, Nymak Pharma supplies IV fluids, medicines & devices to 24+ countries. Talk to our export team.',
                'pharma manufacturers in india',
                'pharma manufacturing companies in India; Indian pharmaceutical manufacturers; pharmaceutical exporter India',
                'pharmaceutical suppliers in India; drug manufacturing companies in India; pharma companies in India',
            ],
            'about' => [
                'Pharmaceutical Companies in India: Our Story Since 1998',
                'Founded in 1998, Nymak Pharma is a pharmaceutical company based in Gujarat, India: a WHO-GMP certified Star Export House serving 24+ countries.',
                'pharmaceutical companies in india',
                'leading pharmaceutical company in India; Indian pharma manufacturing company; pharmaceutical company based in Gujarat',
                'pharma companies in India; Indian pharmaceutical manufacturers; pharma industry India',
            ],
            'manufacturing' => [
                'Drug Manufacturing Companies in India: Mundra Facility',
                'Inside our pharma manufacturing facility in Mundra: WHO-GMP production, in-house QC lab, QA release, regulatory and warehouse teams. See the facility.',
                'drug manufacturing companies in india',
                'pharmaceutical manufacturing company in India; medicine manufacturing company in India; pharma manufacturing facility in India',
                'drug manufacturers India; pharma manufacturers; pharmaceutical manufacturing',
            ],
            'quality' => [
                'Pharmaceutical Regulatory Services India: WHO-GMP & ISO',
                'WHO-GMP, ISO 13485 & Star Export House certified, with pharmaceutical registration support & dossier preparation for every destination market.',
                'pharmaceutical regulatory services india',
                'pharmaceutical registration support India; pharma regulatory documentation; pharmaceutical dossier preparation',
                'regulatory affairs pharma; pharma dossiers; drug registration',
            ],
            'products.index' => [
                'Pharmaceutical Suppliers in India: Export Product Range',
                'A pharmaceutical product supplier in India exporting IV fluids, finished formulations, medical devices & rapid test kits to 24+ markets.',
                'pharmaceutical suppliers in india',
                'pharmaceutical product suppliers in India; pharma products supplier India; pharmaceutical medicine supplier',
                'pharmaceutical products; medicines supplier; pharma products India',
            ],
            'markets.index' => [
                'Pharmaceutical Exporter India: 24+ Countries Served',
                'Nymak Pharma is a pharmaceutical exporter India trusts across 24+ countries: Africa, the Middle East, Asia & the South Pacific. Explore our markets.',
                'pharmaceutical exporter india',
                'Indian pharmaceutical exporter; pharmaceutical export company in India; pharma exporters from India',
                'pharma export India; pharmaceutical suppliers India; Indian pharma companies',
            ],
            'ahmedabad' => [
                'Pharma Manufacturing Company in Ahmedabad, Gujarat',
                'A pharma manufacturing company in Ahmedabad: our corporate office runs regulatory, design & exports beside the WHO-GMP works at Mundra, Gujarat.',
                'pharma manufacturing company in ahmedabad',
                'pharma manufacturer in Ahmedabad; pharmaceutical companies in Ahmedabad; pharmaceutical companies in Gujarat',
                'pharma companies Ahmedabad; pharma companies Gujarat; pharmaceutical manufacturers Gujarat',
            ],
            'team.index' => [
                'The Team Behind Our Pharmaceutical Exports',
                'Meet the team behind Nymak Pharma: leadership and specialists in exports, regulatory affairs, quality control, logistics & design in Gujarat, India.',
                'nymak pharma team',
                'pharmaceutical export team India; pharma company leadership Gujarat',
                'regulatory affairs team; quality control team; export managers',
            ],
            'inside' => [
                'Inside Nymak Pharma: An Interactive Story',
                'An interactive walk through Nymak Pharma, from a 1998 startup in Mundra to a pharmaceutical export company trusted across 24+ countries.',
                'inside nymak pharma',
                'nymak pharma company story; pharmaceutical export journey India',
                'pharma company history; indian pharmaceutical exporters',
            ],
            'posts.index' => [
                'Pharmaceutical Export Insights & Resources',
                'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified company in Gujarat, India.',
                'pharmaceutical export insights',
                'pharma export company blog India; pharmaceutical quality explainers',
                'pharmaceutical industry news; export compliance resources',
            ],
            'faqs' => [
                'Pharmaceutical Export FAQs: Products & Certifications',
                'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership from Nymak Pharma, a pharmaceutical exporter in India.',
                'pharmaceutical export faqs',
                'iv fluids supplier India faq; pharmaceutical exporter questions',
                'who-gmp certification; pharma partnership; product registration',
            ],
            'contact' => [
                'Pharmaceutical Company in India: Contact & Enquiries',
                'Contact our pharmaceutical company in India for export enquiries, distribution & tenders: offices in Gujarat, the UK, Sierra Leone & Liberia.',
                'pharmaceutical company in india',
                'contact pharmaceutical manufacturer India; pharma supplier India; pharmaceutical exporter India',
                'pharma manufacturer; pharma supplier; medicine manufacturer',
            ],
            'privacy' => [
                'Privacy Policy',
                'How Nymak Pharma collects, uses and protects personal data submitted through this website, and how to reach our data team.',
                null, null, null,
            ],
            'terms' => [
                'Terms of Use',
                'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products and services.',
                null, null, null,
            ],
        ];

        foreach ($metas as $key => [$title, $description, $focus, $longTail, $secondary]) {
            $row = PageMeta::firstOrNew(['key' => $key]);
            $row->meta_title = $row->meta_title ?: $title;
            $row->meta_description = $row->meta_description ?: $description;
            $row->focus_keyword = $row->focus_keyword ?: $focus;
            $row->long_tail_keywords = $row->long_tail_keywords ?: $longTail;
            $row->secondary_keywords = $row->secondary_keywords ?: $secondary;
            $row->og_image = $row->og_image ?: 'images/hero/facility-aerial.webp';
            $row->save();
        }
    }
}
