<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Client review: focus keywords were present but thin (single body
     * mention, absent from H1s on most mapped pages, no image alt text,
     * some long-tail/secondary phrases missing entirely). This pass puts
     * the focus keyword into the hero title where it was missing, lifts
     * it into a heading on manufacturing, and inserts the missing
     * long-tail and secondary phrases into body copy. Slots are
     * materialised via firstOrCreate, so rows holding previous seeded
     * defaults would keep serving the lower-density copy. Refresh exactly
     * those rows: any value an admin actually edited stays untouched.
     */
    public function up(): void
    {
        $swaps = [
            'home' => [
                'hero_title' => [
                    '25+ years of efficacy-driven lifecare from a pharmaceutical exporter India trusts',
                    'Pharma manufacturers in India: 25+ years of efficacy-driven lifecare, exported worldwide',
                ],
                'about_p1' => [
                    'Founded in 1998 by Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP supplied to hospitals across the South Pacific. Today the journey spans 24+ countries on four continents.',
                    'Founded in 1998 by Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP supplied to hospitals across the South Pacific. Today the journey spans 24+ countries on four continents. What began as a single export line now stands among the established pharma manufacturing companies in India.',
                ],
                'quality_body' => [
                    'Every batch is analysed by our in-house QC laboratory and released only after QA review. WHO-GMP, ISO 13485:2016, Star Export House and Pharmexcil systems are maintained as living, audited processes.',
                    'Every batch is analysed by our in-house QC laboratory and released only after QA review. WHO-GMP, ISO 13485:2016, Star Export House and Pharmexcil systems are maintained as living, audited processes. It is the discipline drug manufacturing companies in India are expected to show when products travel on documentation alone.',
                ],
                'cta_body' => [
                    'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry.',
                    'Product enquiries, distribution partnerships, tenders and registration support: as pharma manufacturers in India, our exports team responds to every enquiry.',
                ],
            ],
            'about' => [
                'credentials_body' => [
                    'WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House recognition and Pharmexcil membership: credentials that regulators and partners can verify.',
                    'WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House recognition and Pharmexcil membership: credentials that regulators and partners can verify, the standard Indian pharmaceutical manufacturers supplying regulated markets are held to.',
                ],
                'overview_p2' => [
                    'As our expertise flourished, so did our reach: several island markets across the South Pacific, then Central America, and a milestone entry into Nigeria in 2000 that lifted exports by 25%. Anticipating evolving needs, this Indian pharma manufacturing company diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits.',
                    'As our expertise flourished, so did our reach: several island markets across the South Pacific, then Central America, and a milestone entry into Nigeria in 2000 that lifted exports by 25%. Anticipating evolving needs, this Indian pharma manufacturing company diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits. That breadth keeps us among the pharmaceutical companies in India importers shortlist for multi-segment supply.',
                ],
            ],
            'manufacturing' => [
                'hero_title' => [
                    'Inside a pharma manufacturing facility built for export',
                    'Inside a pharma manufacturing facility in India built for export',
                ],
                'capabilities_title' => [
                    'What runs inside the facility',
                    'The capabilities drug manufacturing companies in India are judged on',
                ],
                'overview_p3' => [
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. That audit-ready openness is what sets drug manufacturing companies in India that export reliably apart from those that only quote. As a medicine manufacturing company in India serving 24+ countries, it is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require.',
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. That audit-ready openness is what sets drug manufacturing companies in India that export reliably apart from those that only quote. As a medicine manufacturing company in India serving 24+ countries, it is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require. Partners comparing drug manufacturers India-wide and pharma manufacturers abroad tend to place the first order after that visit.',
                ],
            ],
            'products.index' => [
                'hero_title' => [
                    'A pharmaceutical export portfolio built for real-world need',
                    'Pharmaceutical suppliers in India with a portfolio built for real-world need',
                ],
                'body_p1' => [
                    'Nymak Pharma is a pharmaceutical product supplier in India whose catalogue is built around how our buyers actually procure. Hospital groups, importers, NGOs and public health programmes rarely want single-line orders: they want IV fluids beside the devices that deliver them, formulations beside the diagnostics that guide them, and one dossier set behind it all. Our four-segment portfolio answers exactly that, with more than 300 line items held to one manufacturing standard and one documentation trail. For a pharmaceutical medicine supplier working across 24+ export markets, breadth and consistency are what buyers audit first: the range has to cover the formulary, and every line has to carry the same evidence file.',
                    'Nymak Pharma stands among the pharmaceutical product suppliers in India whose catalogue is built around how our buyers actually procure. Hospital groups, importers, NGOs and public health programmes rarely want single-line orders: they want IV fluids beside the devices that deliver them, formulations beside the diagnostics that guide them, and one dossier set behind it all. Our four-segment portfolio answers exactly that, with more than 300 line items held to one manufacturing standard and one documentation trail. For a pharmaceutical medicine supplier working across 24+ export markets, breadth and consistency are what buyers audit first: the range has to cover the formulary, and every line has to carry the same evidence file.',
                ],
            ],
            'markets.index' => [
                'footprint_body' => [
                    'More than 200 containers shipped in FY 2023-24 to 24+ countries across four regions, and the number keeps growing. Each container is documented end to end: dossier registration, batch certificates, compliant labelling and port logistics handled by the same in-house teams. Few pharma export India operations run this volume through a single audited site, and fewer still can show the paperwork line by line.',
                    'More than 200 containers shipped in FY 2023-24 to 24+ countries across four regions, and the number keeps growing. Each container is documented end to end: dossier registration, batch certificates, compliant labelling and port logistics handled by the same in-house teams. Few pharma export India operations run this volume through a single audited site, and fewer still can show the paperwork line by line. It is the operating record a pharmaceutical exporter India can stand behind.',
                ],
                'presence_p6' => [
                    'Choosing between channels is rarely the buyer\'s problem to solve alone. A ministry running a national tender needs a supplier whose file survives scrutiny; a private distributor needs margin and marketing support; an NGO needs delivery dates that hold. Our exports team works through that calculus market by market, which is why the same catalogue reaches a London trading desk, a Freetown pharmacy wholesaler and a Pacific Island health programme under three different arrangements with one shared standard of evidence. That is the kind of pharmaceutical exporter India built its reputation on: present where it matters, documented everywhere.',
                    'Choosing between channels is rarely the buyer\'s problem to solve alone. A ministry running a national tender needs a supplier whose file survives scrutiny; a private distributor needs margin and marketing support; an NGO needs delivery dates that hold. Our exports team works through that calculus market by market, which is why the same catalogue reaches a London trading desk, a Freetown pharmacy wholesaler and a Pacific Island health programme under three different arrangements with one shared standard of evidence. That is the kind of pharmaceutical exporter India built its reputation on: present where it matters, documented everywhere. Among Indian pharma companies exporting to regulated markets, that combination of presence and paperwork is still rare.',
                ],
            ],
            'ahmedabad' => [
                'why_p1' => [
                    'Gujarat is one of the pharma industry India\'s deepest manufacturing belts, and our position in it is deliberate. The works at Mundra sit minutes from two of India\'s busiest export ports, while the Ahmedabad office places our commercial team inside the state\'s business capital: near Pharmexcil and export bodies, courier and banking hubs, and the talent pool pharma companies in Gujarat draw on. Pharmaceutical companies in Gujarat supply a large share of the formulations the world buys; being inside that ecosystem means suppliers, packagers, freight partners and regulators are all within reach. Raw material sourcing, packaging components and specialist services sit inside the same state, so lead times compress and problems get solved with a phone call rather than a supply chain enquiry.',
                    'Gujarat is one of the pharma industry India\'s deepest manufacturing belts, and our position in it is deliberate. The works at Mundra sit minutes from two of India\'s busiest export ports, while the Ahmedabad office places our commercial team inside the state\'s business capital: near Pharmexcil and export bodies, courier and banking hubs, and the talent pool pharma companies in Gujarat draw on. Pharmaceutical companies in Gujarat supply a large share of the formulations the world buys; being inside that ecosystem means suppliers, packagers, freight partners and regulators are all within reach. Raw material sourcing, packaging components and specialist services sit inside the same state, so lead times compress and problems get solved with a phone call rather than a supply chain enquiry. For buyers shortlisting pharma companies Gujarat produces, that proximity shows up as lead time.',
                ],
                'works_p2' => [
                    'Group companies extend that structure overseas: offices in London, Freetown and Monrovia support distribution, tenders and pharmacovigilance in the UK and West Africa. From Ahmedabad, the chain runs city to port to market without a hand-off to third parties.',
                    'Group companies extend that structure overseas: offices in London, Freetown and Monrovia support distribution, tenders and pharmacovigilance in the UK and West Africa. From Ahmedabad, the chain runs city to port to market without a hand-off to third parties. It is how a pharma manufacturing company in Ahmedabad and a WHO-GMP works in Mundra operate as one accountable unit.',
                ],
            ],
            'quality' => [
                'hero_lead' => [
                    'Every accolade reflects our commitment to quality, integrity and the partners who rely on our products: WHO-GMP, ISO 13485:2016, Star Export House and more.',
                    'Pharmaceutical regulatory services India importers trust, backed by verifiable compliance: WHO-GMP, ISO 13485:2016, Star Export House recognition and more.',
                ],
                'reg_p2' => [
                    'Every consignment travels with the paperwork your authority expects: product dossiers, certificates of analysis, WHO-GMP and ISO evidence, and market-compliant labelling produced by our design team. Pharmaceutical registration support India partners receive from us covers new registrations, renewals and variations, so a product that enters your market stays registered.',
                    'Every consignment travels with the paperwork your authority expects: product dossiers, certificates of analysis, WHO-GMP and ISO evidence, and market-compliant labelling produced by our design team. Pharmaceutical registration support India partners receive from us covers new registrations, renewals and variations, so a product that enters your market stays registered. It is the depth regulatory affairs pharma teams and pharma dossiers reviewers expect before a tender is awarded.',
                ],
            ],
            'contact' => [
                'hero_title' => [
                    'Let\'s talk about your market',
                    'Talk to a pharmaceutical company in India',
                ],
                'hero_lead' => [
                    'Whether you are a distributor, hospital, NGO or health programme, share your requirement with our pharmaceutical company in India: a pharma supplier India tenders rely on and a pharmaceutical exporter India works with across 24+ markets.',
                    'Whether you are a distributor, hospital, NGO or health programme, share your requirement with our pharmaceutical company in India: a pharma supplier India tenders rely on and a pharmaceutical exporter India works with across 24+ markets. The fastest way to contact pharmaceutical manufacturer India offices like ours is the enquiry form below.',
                ],
                'form_lead' => [
                    'Fields marked * are required.',
                    'Fields marked * are required. Your enquiry reaches a pharma manufacturer, pharma supplier and medicine manufacturer under one roof.',
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
