<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'From Sterilized Water for Injections to 24 Countries: The Nymak Pharma Journey',
                'slug' => 'nymak-pharma-journey-1998-to-24-countries',
                'category' => 'Company',
                'excerpt' => 'How a single product — Sterilized Water for Injections BP in plastic ampoules — grew into an export operation reaching more than 24 countries across Africa, Central America and the South Pacific.',
                'body' => <<<'MD'
When Nymak Pharma was founded in 1998 by Mr. Ranjit Advani, the company began with a deliberately focused mission: producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. The first clients were in the South Pacific — island markets where reliable supply of even basic injectables made a measurable difference to healthcare delivery.

## Expanding beyond the first markets

As expertise grew, so did the map. Nymak extended its reach across several South Pacific islands before entering Honduras in Central America. Each new market brought new requirements — different registrations, different pack expectations, different clinical needs — and the portfolio grew with them, adding pharmaceuticals and medical disposables alongside the original water for injections line.

## The Nigeria milestone

A pivotal moment arrived in 2000 when Nymak entered the Nigerian market. The result was immediate: export sales grew by 25%, and the experience proved the company's model — quality manufacturing paired with committed local partnership — could transform access to essential medicines across the African continent.

## Where we stand today

Nymak Pharma now operates in more than 24 countries and exported over 200 containers in FY 2023–24. The company is recognised as a Government of India certified Star Export House and operates with in-house regulatory, laboratory, QC/QA and design teams.

The founding principle has not changed: behind every product is a person in need. The goal ahead is the same one stated in 1998 — a world where quality healthcare is not a privilege but a fundamental right.
MD,
                'meta_title' => 'Nymak Pharma Journey: 1998 to 24+ Export Countries',
                'meta_description' => 'The story of Nymak Pharma — from Sterilized Water for Injections in 1998 to a Star Export House supplying pharmaceuticals across 24+ countries.',
                'published_at' => '2026-07-15 09:00:00',
            ],
            [
                'title' => 'What WHO-GMP Certification Means for Our Partners',
                'slug' => 'who-gmp-certification-nymak-pharma',
                'category' => 'Quality',
                'excerpt' => 'WHO-GMP certification is more than a certificate on the wall. Here is what it means in practice for the partners and programmes that rely on Nymak products.',
                'body' => <<<'MD'
For distributors, procurement agencies and health ministries, a manufacturer's certifications determine whether a partnership is even possible. Nymak Pharma's facility operates under WHO-GMP — the World Health Organization's Good Manufacturing Practices standard — alongside ISO 13485:2016 certification.

## What the standard covers

GMP governs how products are made, not just how they are tested. It covers the facility environment, equipment validation, raw material controls, in-process checks, documentation, batch traceability and personnel training. In practice it means every batch follows a documented, repeatable, auditable process.

## Quality control in practice at Nymak

At the Mundra facility, an in-house QC laboratory analyses batch lots before release, and a separate QA function reviews and approves. An in-house regulatory team manages dossiers and country registrations, while the design team handles compliant labelling for each destination market.

## Why it matters for buyers

Partners evaluating Nymak Pharma consistently note the same things in facility feedback — controlled processes, modern machinery and storage, and quality-conscious management. For importers, WHO-GMP compliance is what turns a product sample into a registrable, tender-ready supply line.

Certifications held by the company include WHO-GMP, ISO 13485:2016, Star Export House recognition, Pharmexcil RCMC membership, IEC registration and GST compliance — each one verifiable, each one maintained.
MD,
                'meta_title' => 'WHO-GMP Certified Pharmaceutical Manufacturer | Nymak',
                'meta_description' => 'What WHO-GMP and ISO 13485 certification mean in practice at Nymak Pharma — and why they matter to importers, distributors and health programmes.',
                'published_at' => '2026-08-02 09:00:00',
            ],
            [
                'title' => 'Inside the IV Fluids Range: Large-Volume Parenterals for Critical Care',
                'slug' => 'iv-fluids-range-large-volume-parenterals',
                'category' => 'Products',
                'excerpt' => 'From simple saline to multi-electrolyte formulations and therapeutic infusions — a closer look at the IV fluids portfolio and where each group is used.',
                'body' => <<<'MD'
Intravenous fluids sit at the foundation of hospital care — rehydration, electrolyte correction, drug delivery and critical care all depend on them. Nymak Pharma's IV fluids range was designed as a complete offering so that a single supplier relationship can cover a hospital's or programme's core requirements.

## The core replenisher range

The portfolio starts with the essentials: Sodium Chloride 0.9% and 0.45% intravenous infusions, Ringer Lactate, and dextrose infusions at 5%, 10% and 25% concentrations, including sodium chloride–dextrose combinations. Pack sizes run from 100 ml to 1000 ml to match ward, theatre and field use.

## Multi-electrolyte and specialist fluids

For more demanding correction protocols, the range includes multiple-electrolyte formulations (the 'P', 'G', 'M' and 'E' presentations with dextrose), mannitol as an osmotic diuretic, and intraperitoneal dialysis fluid.

## Therapeutic infusions

Beyond hydration, the range carries ready-to-infuse antibacterials — ciprofloxacin, ofloxacin, levofloxacin, moxifloxacin and pefloxacin — alongside metronidazole, ornidazole, tinidazole, fluconazole, linezolid and paracetamol infusions. Ready-to-use presentations reduce preparation steps and dosing errors at the point of care.

## Built for export

All IV fluids are manufactured under WHO-GMP conditions at the Mundra facility and exported across Nymak's 24+ markets, with registration support from the in-house regulatory team.
MD,
                'meta_title' => 'IV Fluids & Large-Volume Parenterals | Nymak Pharma',
                'meta_description' => 'Inside Nymak Pharma\'s IV fluids range — saline, dextrose, RL, multi-electrolyte and therapeutic infusions manufactured under WHO-GMP for 24+ markets.',
                'published_at' => '2026-08-20 09:00:00',
            ],
            [
                'title' => 'Star Export House: What the Recognition Means',
                'slug' => 'star-export-house-recognition',
                'category' => 'Company',
                'excerpt' => 'Nymak Pharma is a Government of India certified Star Export House. Here is what that recognition represents and why it matters to our partners.',
                'body' => <<<'MD'
Among the certifications in Nymak Pharma's portfolio, one reflects not just compliance but performance: the Star Export House Certificate of Recognition issued by the Government of India.

## What the status recognises

Star Export House status is granted under India's Foreign Trade Policy to exporters who demonstrate sustained export performance. For Nymak Pharma it recognises the scale the company has built — more than 200 containers exported in FY 2023–24 across 24+ country markets.

## What it signals to partners

For importers and distributors, the recognition is a practical signal: the company has an established export track record, operates within India's official trade framework, and has the compliance infrastructure — IEC registration, Pharmexcil membership, GST — that reliable long-term supply requires.

## Part of a larger quality story

The Star Export House recognition sits alongside WHO-GMP and ISO 13485:2016 certification. Together they describe how the company operates: certified manufacturing at the facility level, and certified performance at the export level.

For a company that began in 1998 with a single product shipped to the South Pacific, the recognition marks how far disciplined, quality-first exporting can reach.
MD,
                'meta_title' => 'Star Export House Certified Pharma Exporter | Nymak',
                'meta_description' => 'Nymak Pharma is a Government of India certified Star Export House — what the recognition means for importers, distributors and partners.',
                'published_at' => '2026-09-01 09:00:00',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
