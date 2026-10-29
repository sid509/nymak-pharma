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
 * appends the 15-char site-name suffix at render time, so titles run
 * 35-45 chars here to keep the rendered <title> inside the 50-60 spec. Only empty fields are filled, so
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
                'Pharma Manufacturers in India: WHO-GMP',
                'Among pharma manufacturers in India, Nymak Pharma is a WHO-GMP certified exporter supplying IV fluids, medicines & medical devices to 24+ countries today.',
                'pharma manufacturers in india',
                'pharma manufacturing companies in India; Indian pharmaceutical manufacturers; pharmaceutical exporter India',
                'pharmaceutical suppliers in India; drug manufacturing companies in India; pharma companies in India',
            ],
            'about' => [
                'Pharmaceutical Companies in India Since 1998',
                'Among pharmaceutical companies in India, Nymak Pharma stands apart: founded 1998 in Gujarat, a WHO-GMP certified Star Export House serving 24+ countries.',
                'pharmaceutical companies in india',
                'leading pharmaceutical company in India; Indian pharma manufacturing company; pharmaceutical company based in Gujarat',
                'pharma companies in India; Indian pharmaceutical manufacturers; pharma industry India',
            ],
            'manufacturing' => [
                'Drug Manufacturing Companies in India: Mundra',
                'Among drug manufacturing companies in India, our Mundra WHO-GMP facility runs in-house QC, QA release, regulatory & warehouse teams. See the facility.',
                'drug manufacturing companies in india',
                'pharmaceutical manufacturing company in India; medicine manufacturing company in India; pharma manufacturing facility in India',
                'drug manufacturers India; pharma manufacturers; pharmaceutical manufacturing',
            ],
            'quality' => [
                'Pharmaceutical Regulatory Services India',
                'Pharmaceutical regulatory services India exporters rely on: WHO-GMP & ISO 13485 certified, dossier preparation & registration support per destination market.',
                'pharmaceutical regulatory services india',
                'pharmaceutical registration support India; pharma regulatory documentation; pharmaceutical dossier preparation',
                'regulatory affairs pharma; pharma dossiers; drug registration',
            ],
            'products.index' => [
                'Pharmaceutical Suppliers in India: 300+ Items',
                'Pharmaceutical suppliers in India exporting IV fluids, finished formulations, medical devices & rapid test kits to 24+ global markets. Request the range.',
                'pharmaceutical suppliers in india',
                'pharmaceutical product suppliers in India; pharma products supplier India; pharmaceutical medicine supplier',
                'pharmaceutical products; medicines supplier; pharma products India',
            ],
            'markets.index' => [
                'Pharmaceutical Exporter India: 24+ Markets',
                'A pharmaceutical exporter India relies on across 24+ countries in Africa, the Middle East, Asia & the South Pacific. Explore our global market map today.',
                'pharmaceutical exporter india',
                'Indian pharmaceutical exporter; pharmaceutical export company in India; pharma exporters from India',
                'pharma export India; pharmaceutical suppliers India; Indian pharma companies',
            ],
            'ahmedabad' => [
                'Pharma Manufacturing Company in Ahmedabad',
                'A pharma manufacturing company in Ahmedabad, Gujarat: corporate office for regulatory, design & exports beside the WHO-GMP works at Mundra, Gujarat, India.',
                'pharma manufacturing company in ahmedabad',
                'pharma manufacturer in Ahmedabad; pharmaceutical companies in Ahmedabad; pharmaceutical companies in Gujarat',
                'pharma companies Ahmedabad; pharma companies Gujarat; pharmaceutical manufacturers Gujarat',
            ],
            'team.index' => [
                'Nymak Pharma Team: Leaders & Specialists',
                'Meet the team behind Nymak Pharma: leadership and specialists in exports, regulatory affairs, quality control, logistics & design in Gujarat, India today.',
                null, null, null,
            ],
            'inside' => [
                'Inside Nymak Pharma: Our Interactive Story',
                'An interactive walk through Nymak Pharma: from a 1998 startup in Mundra to a pharmaceutical export company trusted across 24+ export countries worldwide.',
                null, null, null,
            ],
            'posts.index' => [
                'Pharmaceutical Export Insights & News',
                'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified exporter in Gujarat, India. Read the journal.',
                null, null, null,
            ],
            'faqs' => [
                'Pharmaceutical Export FAQs: India Exporter',
                'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership enquiries from Nymak Pharma, a pharmaceutical exporter in India today.',
                null, null, null,
            ],
            'contact' => [
                'Pharmaceutical Company in India: Contact',
                'Contact a pharmaceutical company in India for export enquiries, distribution & tenders: offices in Gujarat, the UK, Sierra Leone & Liberia, West Africa.',
                'pharmaceutical company in india',
                'contact pharmaceutical manufacturer India; pharma supplier India; pharmaceutical exporter India',
                'pharma manufacturer; pharma supplier; medicine manufacturer',
            ],
            'privacy' => [
                'Privacy Policy, Data Use & Your Rights',
                'How Nymak Pharma collects, uses and protects the personal data submitted through this website, and how to reach our data team with privacy questions today.',
                null, null, null,
            ],
            'terms' => [
                'Terms of Use & Conditions of This Site',
                'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products, services and export terms of use here.',
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
