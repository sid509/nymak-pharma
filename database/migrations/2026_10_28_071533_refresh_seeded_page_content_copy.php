<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The content-change pass rewrote many SCHEMA defaults (four segments,
     * no vaccines/antisera, keyword-mapped copy, new market list). Slots are
     * materialised via firstOrCreate, so rows holding the previous seeded
     * defaults would keep serving stale copy forever. Refresh exactly those
     * rows: any value an admin actually edited stays untouched.
     */
    public function up(): void
    {
        $swaps = [
            'home' => [
                'hero_title' => [
                    '25+ years of Efficacy-Driven lifecare',
                    '25+ years of efficacy-driven lifecare from a pharmaceutical exporter India trusts',
                ],
                'hero_subtitle' => [
                    'Your Reliable Partner in Efficacious Lifecare Solutions, trusted in 24 countries and counting. A WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices, rapid diagnostic kits and vaccines.',
                    'Your Reliable Partner in Efficacious Lifecare Solutions, trusted in 24 countries and counting. Among pharma manufacturers in India, Nymak Pharma stands apart: a WHO-GMP certified pharmaceutical company and Government of India recognised Star Export House supplying IV fluids, finished formulations, medical devices and rapid diagnostic kits.',
                ],
                'about_title' => [
                    'A pharmaceutical manufacturer India has exported through since 1998',
                    'A pharmaceutical company India has exported through since 1998',
                ],
                'about_p1' => [
                    'Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP in plastic ampoules, serving the South Pacific. From those beginnings we grew into Honduras, then Nigeria in 2000, a milestone that lifted exports by 25% and opened our expansion across Africa.',
                    'Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with a single product: Sterilized Water for Injections BP in plastic ampoules, supplied to hospitals and medical stores across the South Pacific. From those beginnings we grew into Central America, then Nigeria in 2000, a milestone that lifted exports by 25% and opened our wider expansion across the African continent. Today that journey stands at more than 24 countries on four continents.',
                ],
                'about_p2' => [
                    'Today we operate from a WHO-GMP certified facility in Mundra, Gujarat, supported by in-house regulatory, laboratory, QC/QA and design teams, and recognised as a Government of India certified Star Export House.',
                    'What sets us apart among pharma companies in India is how much sits under one roof. Our WHO-GMP certified facility in Mundra, Gujarat is supported by an in-house regulatory team preparing product dossiers, a quality control laboratory analysing every batch, a separate QA function approving each release, and a design team producing compliant, market-ready packaging for each destination market. That structure is why partners describe us as a pharmaceutical company based in Gujarat they can actually audit, not just a name on a proforma invoice.',
                ],
                'portfolio_title' => [
                    'Five product segments, one quality standard',
                    'Four product segments, one quality standard',
                ],
                'portfolio_lead' => [
                    'A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes.',
                    'A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes, organised into four segments: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits. As pharmaceutical suppliers in India serving regulated and semi-regulated markets, every line item ships with the documentation its destination requires.',
                ],
                'brands_lead' => [
                    'Registered brands supplied across West African markets, each manufactured under WHO-GMP conditions.',
                    'Registered Nymak brands supplied across West African markets, each produced under WHO-GMP conditions and supported by our in-house regulatory and design teams: Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak and more.',
                ],
                'quality_body' => [
                    'Every batch is analysed by our in-house QC laboratory and released through QA review. Each accolade reflects our deep-rooted commitment to quality, integrity and global healthcare excellence, standing for the trust of our partners, the safety of our products, and the lives we strive to improve.',
                    'Every batch is analysed by our in-house QC laboratory and released only after QA review. Our regulatory team supports dossiers and product registrations in destination markets, which is what separates a verified pharmaceutical manufacturing company in India from a paper one. Each accolade reflects our deep-rooted commitment to quality, integrity and global healthcare excellence: the trust of our partners, the safety of our products, and the lives we strive to improve. WHO-GMP certification, ISO 13485:2016 quality systems, Star Export House status and Pharmexcil membership are maintained as living systems, audited regularly and verified by the partners and inspectors who visit the facility.',
                ],
                'global_title' => [
                    'From Mundra to 24+ country markets',
                    'From India to 24+ countries',
                ],
                'global_body' => [
                    'Operating across West, Central and East Africa, Central America and the South Pacific, with offices in the UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships.',
                    'A pharmaceutical exporter India dispatches from to 24+ countries: operating across West, Central, East and Southern Africa, the Middle East, Asia and the South Pacific, with group companies and offices in the UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships. Our presence is structured in three ways: our own group companies, ethical markets where Nymak products are registered and promoted to prescribers, and partner markets supplied through appointed distributors who share our quality expectations.',
                ],
                'faq_lead' => [
                    'Straight answers about who we are, what we make, and how we export.',
                    'Straight answers about who we are, the products we supply, our WHO-GMP certifications and how we export to 24+ markets.',
                ],
                'cta_body' => [
                    'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry.',
                    'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry. If you are comparing pharma manufacturers in India for your market, start the conversation here. Tell us your target market and product category, and we will come back with availability, documentation status and a realistic timeline.',
                ],
            ],
            'about' => [
                'hero_title' => [
                    '25+ years of efficacy-driven lifecare',
                    'A pharmaceutical company in India since 1998',
                ],
                'overview_p1' => [
                    'Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, Nymak Pharma embarked on its journey producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. Our beginnings were humble. Our first clients were in the South Pacific, where we established our dedication to quality, service and efficacy, always remembering that behind every product is a person in need.',
                    'Among pharmaceutical companies in India, Nymak Pharma began small and stayed deliberate. Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, the company embarked on its journey producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. Our beginnings were humble. Our first clients were in the South Pacific, where we established our dedication to quality, service and efficacy, always remembering that behind every product is a person in need.',
                ],
                'overview_p2' => [
                    'As our expertise flourished, so did our reach: several island markets across the South Pacific, then Honduras in Central America. Anticipating evolving needs, we diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve.',
                    'As our expertise flourished, so did our reach: several island markets across the South Pacific, then Central America, and a milestone entry into Nigeria in 2000 that lifted exports by 25%. Anticipating evolving needs, this Indian pharma manufacturing company diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits.',
                ],
                'overview_p3' => [
                    'Today, with over 25 years of lifecare excellence, Nymak Pharma maintains a presence in more than 24 countries and exported over 200 containers in FY 2023–24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams, all devoted to the highest standards of care and excellence.',
                    'Today, with over 25 years of lifecare excellence, Nymak Pharma is a pharmaceutical company based in Gujarat maintaining a presence in more than 24 countries. We exported over 200 containers in FY 2023-24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team preparing product dossiers, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams, all devoted to the highest standards of care and excellence in the pharma industry India is known for.',
                ],
                'story_p1' => [
                    'Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani, pharmacist, entrepreneur and our founder, set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.',
                    'Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani, entrepreneur and our founder, set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.',
                ],
                'story_p2' => [
                    'The first product was Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. The first clients were in the South Pacific: hospitals and medical stores thousands of kilometres from the nearest manufacturer. Every consignment carried the same principle: behind every product is a person in need.',
                    'The first product was Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. The first clients were in the South Pacific: hospitals and medical stores thousands of kilometres from dependable supply. Every consignment carried the same principle: behind every product is a person in need.',
                ],
            ],
            'manufacturing' => [
                'hero_title' => [
                    'A WHO-GMP facility built for export',
                    'Inside a pharma manufacturing facility built for export',
                ],
                'hero_lead' => [
                    'Nymak Pharma manufactures at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat, minutes from two of India\'s busiest export ports.',
                    'Nymak Pharma consolidates its operations at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat, minutes from two of India\'s busiest export ports. Production, quality control, regulatory affairs, design and warehousing all run from this single WHO-GMP certified site.',
                ],
                'overview_title' => [
                    'Manufacturing at Mundra',
                    'Head Office & Works, Mundra',
                ],
                'overview_p1' => [
                    'Our head office and works sit within the Port Biz Industrial Park on the Kandla–Mundra highway in Gujarat, a location chosen deliberately for its direct access to the ports of Mundra and Kandla, the gateways through which over 200 containers of Nymak products shipped in FY 2023–24.',
                    'Among drug manufacturing companies in India, location is strategy. Our head office and works sit within the Port Biz Industrial Park on the Kandla-Mundra highway in Gujarat, a location chosen deliberately for its direct access to the ports of Mundra and Kandla, the gateways through which over 200 containers of Nymak products shipped in FY 2023-24. From filling line to vessel, the supply line is measured in kilometres, not days. For a drug manufacturing company in India competing on landed cost and lead time, that geography is a structural advantage competitors inland cannot copy.',
                ],
                'overview_p2' => [
                    'The facility operates under WHO-GMP certification with ISO 13485:2016 quality management systems. Production is supported by a structure that keeps the critical functions in-house: a quality control laboratory, a quality assurance team, a regulatory affairs team handling dossiers and registrations, a design team for market-compliant packaging, and a logistics function managing warehousing and dispatch.',
                    'The facility operates under WHO-GMP certification with ISO 13485:2016 quality management systems, the standard partners expect of a pharmaceutical manufacturing company in India supplying regulated markets. Production is supported by a structure that keeps the critical functions in-house: a quality control laboratory analysing every batch lot, a quality assurance team approving each release, a regulatory affairs team handling dossiers and registrations, a design team producing market-compliant packaging, and a logistics function managing warehousing and dispatch. Documented processes cover the full production cycle, from raw-material control and compounding through filling, labelling and final inspection, with batch records tracing every consignment back to its source.',
                ],
                'overview_p3' => [
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management.',
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. As a medicine manufacturing company in India serving 24+ countries, that audit-ready openness is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require.',
                ],
                'capabilities_lead' => [
                    'Quality, regulatory, design and logistics under one roof, so partners deal with one accountable team.',
                    'Quality, regulatory, design and logistics under one roof, so partners deal with one accountable team from batch to bill of lading. Each function below exists because a medicine manufacturing company in India exporting to 24+ markets cannot afford to subcontract the things buyers audit.',
                ],
            ],
            'products.index' => [
                'hero_lead' => [
                    'Five segments, 300+ line items, one manufacturing standard. Every product ships under WHO-GMP conditions with registration support for your market.',
                    'Four segments, 300+ line items, one quality standard. Every product ships under WHO-GMP conditions with registration support for your market.',
                ],
            ],
            'products.catalogue' => [
                'lead' => [
                    'Every product we manufacture or supply in this category, with strengths and pack sizes. Names with a link open a product page.',
                    'Every product we supply in this category, with strengths and pack sizes. Names with a link open a product page.',
                ],
            ],
            'markets.index' => [
                'hero_title' => [
                    'Healthcare products to 24+ countries, and counting',
                    'A pharmaceutical exporter India sends to 24+ countries, and counting',
                ],
                'map_title' => [
                    'Every pin on the board is a working market',
                    'One supply line from India to the world',
                ],
                'offices_title' => [
                    'International offices & partners',
                    'Group Companies',
                ],
                'footprint_body' => [
                    'More than 200 containers shipped in FY 2023–24 to 24+ countries across four regions, and the number keeps growing.',
                    'More than 200 containers shipped in FY 2023-24 to 24+ countries across four regions, and the number keeps growing. Each container is documented end to end: dossier registration, batch certificates, compliant labelling and port logistics handled by the same in-house teams. Few pharma export India operations run this volume through a single audited site, and fewer still can show the paperwork line by line.',
                ],
            ],
            'team.index' => [
                'hero_lead' => [
                    'Behind every innovation, every product, and every promise we make stands a team united by expertise and empathy. We combine clinical precision with heartfelt commitment to deliver quality healthcare solutions that truly make a difference.',
                    'Behind every product and every promise we make stands a team united by expertise and empathy. We combine clinical precision with heartfelt commitment to deliver quality healthcare solutions that truly make a difference.',
                ],
            ],
        ];

        foreach ($swaps as $page => $keys) {
            foreach ($keys as $key => [$old, $new]) {
                DB::table('page_contents')
                    ->where('page', $page)->where('key', $key)->where('value', $old)
                    ->update(['value' => $new]);
            }
        }

        // JSON slots: match stale fragments rather than the full payload.
        DB::table('page_contents')
            ->where('page', 'manufacturing')->where('key', 'dosage_forms')
            ->where('value', 'like', '%Antisera%')
            ->update(['value' => '[{"title":"IV fluids & infusions","text":"Large-volume parenterals: saline, dextrose, Ringer lactate, multi-electrolyte, therapeutic infusions (100 ml-1000 ml)."},{"title":"Tablets & capsules","text":"Including dispersible, sublingual, sustained-release and combination presentations."},{"title":"Oral liquids","text":"Syrups, suspensions and drops: paediatric and adult formulations."},{"title":"Injections","text":"Ampoules and vials: liquid and dry powder for reconstitution."},{"title":"Medical devices","text":"IV access, infusion sets, syringes, needles and patient-care consumables."},{"title":"Diagnostics","text":"Rapid diagnostic test kits for priority infections and point-of-care screening."}]']);

        DB::table('page_contents')
            ->where('page', 'manufacturing')->where('key', 'capabilities')
            ->where('value', 'like', '%innovation%')
            ->update(['value' => '[{"icon":"faFlask","title":"In-house QC laboratory","text":"A dedicated quality control laboratory analyses batch lots before release. Partners reviewing the facility consistently note well-controlled processes and modern storage."},{"icon":"faClipboardCheck","title":"Quality assurance oversight","text":"A separate QA function reviews and approves every batch before it leaves the facility, ensuring each consignment matches specification and documentation."},{"icon":"faFileCircleCheck","title":"Regulatory & dossier support","text":"An in-house regulatory team prepares and manages product dossiers, supporting registration requirements in destination markets across Africa, Central America and the Pacific."},{"icon":"faBox","title":"Design & packaging","text":"An in-house design team produces compliant, market-ready packaging and labelling, including the branded ranges supplied to West African markets."},{"icon":"faWarehouse","title":"Warehousing & logistics","text":"Committed warehouse infrastructure with controlled storage, managed by a dedicated logistics head. Over 200 containers shipped in FY 2023-24."},{"icon":"faMicroscope","title":"Continuous up-gradation","text":"The facility operates with a documented focus on upgrading existing facilities, verified through client inspections and audits."}]']);

        DB::table('page_contents')
            ->where('page', 'markets.index')->where('key', 'footprint_stats')
            ->where('value', 'like', '%International offices%')
            ->update(['value' => '[{"value":"24+","label":"Countries served"},{"value":"200+","label":"Containers in FY 2023-24"},{"value":"4","label":"Regions"},{"value":"5","label":"Group companies & offices"}]']);

        // page_metas: same deal - rows hold the pre-keyword-map titles and
        // descriptions. Swap only rows that still equal the old seeded text.
        $metaSwaps = [
            'home' => [
                'Pharmaceutical Manufacturer & Exporter in India',
                'Nymak Pharma: WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices and rapid test kits to 24+ countries.',
                'Pharma Manufacturers in India: WHO-GMP Certified Exporter',
                'A WHO-GMP certified pharmaceutical exporter in India, Nymak Pharma supplies IV fluids, medicines & devices to 24+ countries. Talk to our export team.',
            ],
            'about' => [
                'About Us: WHO-GMP Pharmaceutical Manufacturer Since 1998',
                'Founded in 1998, Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Star Export House serving 24+ countries from Gujarat, India.',
                'Pharmaceutical Companies in India: Our Story Since 1998',
                'Founded in 1998, Nymak Pharma is a pharmaceutical company based in Gujarat, India: a WHO-GMP certified Star Export House serving 24+ countries.',
            ],
            'manufacturing' => [
                'Pharmaceutical Manufacturing Facility in Mundra, Gujarat',
                'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat, with in-house QC lab, QA systems, regulatory and warehouse teams.',
                'Drug Manufacturing Companies in India: Mundra Facility',
                'Inside our pharma manufacturing facility in Mundra: WHO-GMP production, in-house QC lab, QA release, regulatory and warehouse teams. See the facility.',
            ],
            'quality' => [
                'Quality & Certifications: WHO-GMP, ISO 13485',
                'Nymak Pharma\'s quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, Pharmexcil RCMC, with in-house QC/QA oversight.',
                'Pharmaceutical Regulatory Services India: WHO-GMP & ISO',
                'WHO-GMP, ISO 13485 & Star Export House certified, with pharmaceutical registration support & dossier preparation for every destination market.',
            ],
            'products.index' => [
                'Pharmaceutical Products: IV Fluids, Formulations & More',
                'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, rapid diagnostic kits.',
                'Pharmaceutical Suppliers in India: Export Product Range',
                'A pharmaceutical product supplier in India exporting IV fluids, finished formulations, medical devices & rapid test kits to 24+ markets.',
            ],
            'markets.index' => [
                'Global Presence: Pharmaceutical Exports to 24+ Countries',
                'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific.',
                'Pharmaceutical Exporter India: 24+ Countries Served',
                'Nymak Pharma is a pharmaceutical exporter India trusts across 24+ countries: Africa, the Middle East, Asia & the South Pacific. Explore our markets.',
            ],
            'team.index' => [
                'Our Team: Leadership & Experts',
                'Meet the leadership and specialists behind Nymak Pharma: exports, regulatory affairs, quality control, logistics and design.',
                'The Team Behind Our Pharmaceutical Exports',
                'Meet the team behind Nymak Pharma: leadership and specialists in exports, regulatory affairs, quality control, logistics & design in Gujarat, India.',
            ],
            'inside' => [
                'Inside Nymak: An Interactive Story',
                'An interactive walk through Nymak Pharma, from a 1998 startup in Mundra to an exporter trusted across 24+ countries.',
                'Inside Nymak Pharma: An Interactive Story',
                'An interactive walk through Nymak Pharma, from a 1998 startup in Mundra to a pharmaceutical export company trusted across 24+ countries.',
            ],
            'posts.index' => [
                'Insights & Resources',
                'Company news, quality explainers and product insights from Nymak Pharma, a WHO-GMP certified pharmaceutical manufacturer and exporter.',
                'Pharmaceutical Export Insights & Resources',
                'Insights on pharmaceutical exports, quality systems and product ranges from Nymak Pharma, a WHO-GMP certified company in Gujarat, India.',
            ],
            'faqs' => [
                'Frequently Asked Questions',
                'Answers about Nymak Pharma\'s products, IV fluids, certifications, export markets, quality systems and how to partner with us.',
                'Pharmaceutical Export FAQs: Products & Certifications',
                'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership from Nymak Pharma, a pharmaceutical exporter in India.',
            ],
            'contact' => [
                'Contact Us: Pharmaceutical Export Enquiries',
                'Contact Nymak Pharma for pharmaceutical exports, product enquiries, distribution and partnership. Offices in India, UK, Sierra Leone & Liberia.',
                'Pharmaceutical Company in India: Contact & Enquiries',
                'Contact our pharmaceutical company in India for export enquiries, distribution & tenders: offices in Gujarat, the UK, Sierra Leone & Liberia.',
            ],
            'privacy' => [
                null,
                'How Nymak Pharma collects, uses and protects personal data submitted through this website.',
                null,
                'How Nymak Pharma collects, uses and protects personal data submitted through this website, and how to reach our data team.',
            ],
            'terms' => [
                null,
                'Terms governing the use of the Nymak Pharma website and its content.',
                null,
                'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products and services.',
            ],
        ];

        foreach ($metaSwaps as $key => [$oldTitle, $oldDesc, $newTitle, $newDesc]) {
            $q = DB::table('page_metas')->where('key', $key);
            if ($oldTitle !== null) {
                (clone $q)->where('meta_title', $oldTitle)->update(['meta_title' => $newTitle]);
            }
            (clone $q)->where('meta_description', $oldDesc)->update(['meta_description' => $newDesc]);
        }
    }

    public function down(): void
    {
        //
    }
};
