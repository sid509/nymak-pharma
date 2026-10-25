<?php

namespace Database\Seeders;

use App\Models\PageMeta;
use Illuminate\Database\Seeder;

/**
 * Seeds the content plan's SEO titles and meta descriptions into page_metas.
 *
 * Titles are stored without the "| Nymak Pharma" suffix — app.blade.php
 * appends the site name at render time. Only empty fields are filled, so
 * admin edits made through /admin/seo-pages survive reseeds.
 */
class PageMetaSeeder extends Seeder
{
    public function run(): void
    {
        $metas = [
            'home' => [
                'Pharmaceutical Manufacturer & Exporter in India',
                'Nymak Pharma — WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices and rapid test kits to 24+ countries.',
            ],
            'about' => [
                'About Us — WHO-GMP Pharmaceutical Manufacturer Since 1998',
                'Founded in 1998, Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Star Export House serving 24+ countries from Gujarat, India.',
            ],
            'manufacturing' => [
                'Pharmaceutical Manufacturing Facility — Mundra, Gujarat',
                'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat — in-house QC lab, QA systems, regulatory and warehouse teams.',
            ],
            'quality' => [
                'Quality & Certifications — WHO-GMP, ISO 13485',
                'Nymak Pharma\'s quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, Pharmexcil RCMC — with in-house QC/QA oversight.',
            ],
            'products.index' => [
                'Pharmaceutical Products — IV Fluids, Formulations & More',
                'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, rapid diagnostic kits.',
            ],
            'markets.index' => [
                'Global Presence — Pharmaceutical Exports to 24+ Countries',
                'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific.',
            ],
            'team.index' => [
                'Our Team — Leadership & Experts',
                'Meet the leadership and specialists behind Nymak Pharma — exports, regulatory affairs, quality control, logistics and design.',
            ],
            'inside' => [
                'Inside Nymak — An Interactive Story',
                'An interactive walk through Nymak Pharma — from a 1998 startup in Mundra to an exporter trusted across 24+ countries.',
            ],
            'posts.index' => [
                'Insights & Resources',
                'Company news, quality explainers and product insights from Nymak Pharma — a WHO-GMP certified pharmaceutical manufacturer and exporter.',
            ],
            'faqs' => [
                'Frequently Asked Questions',
                'Answers about Nymak Pharma\'s products, IV fluids, certifications, export markets, quality systems and how to partner with us.',
            ],
            'contact' => [
                'Contact Us — Pharmaceutical Export Enquiries',
                'Contact Nymak Pharma for pharmaceutical exports, product enquiries, distribution and partnership — offices in India, UK, Sierra Leone & Liberia.',
            ],
            'privacy' => [
                'Privacy Policy',
                'How Nymak Pharma collects, uses and protects personal data submitted through this website.',
            ],
            'terms' => [
                'Terms of Use',
                'Terms governing the use of the Nymak Pharma website and its content.',
            ],
        ];

        foreach ($metas as $key => [$title, $description]) {
            $row = PageMeta::firstOrNew(['key' => $key]);
            $row->meta_title = $row->meta_title ?: $title;
            $row->meta_description = $row->meta_description ?: $description;
            $row->save();
        }
    }
}
