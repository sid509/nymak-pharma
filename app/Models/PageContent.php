<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Admin-editable content slots for public pages. Each page declares a SCHEMA
 * of named slots (text / textarea / image / json). Stored rows override the
 * declared default; PageContent::for() resolves the full map for controllers.
 */
class PageContent extends Model
{
    protected $fillable = ['page', 'key', 'value'];

    /**
     * page => [ [key, label, type, default, help?], ... ]
     * image values are web-relative paths under public/images/.
     * json values decode to arrays (repeating lists like timeline entries).
     */
    public const SCHEMA = [
        'home' => [
            ['hero_badge', 'Hero badge', 'text', 'WHO-GMP Certified · Star Export House'],
            ['hero_title', 'Hero headline', 'text', 'Efficacy-Driven Lifecare, Exported Worldwide'],
            ['hero_subtitle', 'Hero subtitle', 'textarea', 'Nymak Pharma is a pharmaceutical manufacturer and exporter in India supplying IV fluids, finished formulations, medical devices, rapid diagnostic kits and vaccines to partners in more than 24 countries.'],
            ['hero_image', 'Hero background image', 'image', 'images/hero/facility-aerial.webp'],
            ['about_eyebrow', 'About section eyebrow', 'text', 'About Nymak Pharma'],
            ['about_title', 'About section title', 'text', 'A pharmaceutical manufacturer India has exported through since 1998'],
            ['about_p1', 'About paragraph 1', 'textarea', 'Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP in plastic ampoules, serving the South Pacific. From those beginnings we grew into Honduras, then Nigeria in 2000 — a milestone that lifted exports by 25% and opened our expansion across Africa.'],
            ['about_p2', 'About paragraph 2', 'textarea', 'Today we operate from a WHO-GMP certified facility in Mundra, Gujarat, supported by in-house regulatory, laboratory, QC/QA and design teams — and recognised as a Government of India certified Star Export House.'],
            ['about_image', 'About section image', 'image', 'images/hero/facility-aerial.webp'],
            ['portfolio_eyebrow', 'Portfolio eyebrow', 'text', 'Our Portfolio'],
            ['portfolio_title', 'Portfolio title', 'text', 'Five product segments, one quality standard'],
            ['portfolio_lead', 'Portfolio lead', 'textarea', 'A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Marketed Brands'],
            ['brands_title', 'Brands title', 'text', 'The Nymak branded range'],
            ['brands_lead', 'Brands lead', 'textarea', 'Registered brands supplied across West African markets — each manufactured under WHO-GMP conditions.'],
            ['quality_eyebrow', 'Quality eyebrow', 'text', 'Quality & Compliance'],
            ['quality_title', 'Quality title', 'text', 'Certified for the markets that demand proof'],
            ['quality_body', 'Quality body', 'textarea', 'Every batch is analysed by our in-house QC laboratory and released through QA review. Our regulatory team supports dossiers and registrations in destination markets.'],
            ['global_eyebrow', 'Global eyebrow', 'text', 'Global Presence'],
            ['global_title', 'Global title', 'text', 'From Mundra to 24+ country markets'],
            ['global_body', 'Global body', 'textarea', 'Operating across West, Central and East Africa, Central America and the South Pacific — with offices in the UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships.'],
            ['testimonials_eyebrow', 'Testimonials eyebrow', 'text', 'Partner Feedback'],
            ['testimonials_title', 'Testimonials title', 'text', 'What our clients say'],
            ['clients_lead', 'Client strip label', 'text', 'Trusted by pharmaceutical partners across markets'],
            ['faq_eyebrow', 'FAQ eyebrow', 'text', 'FAQs'],
            ['faq_title', 'FAQ title', 'text', 'Questions partners ask us'],
            ['faq_lead', 'FAQ lead', 'textarea', 'Straight answers about who we are, what we make, and how we export.'],
            ['journal_eyebrow', 'Journal eyebrow', 'text', 'Insights'],
            ['journal_title', 'Journal title', 'text', 'From the Nymak journal'],
            ['cta_title', 'CTA title', 'text', 'Have a requirement? Let\'s talk.'],
            ['cta_body', 'CTA body', 'textarea', 'Product enquiries, distribution partnerships, tenders and registration support — our exports team responds to every enquiry.'],
        ],
        'about' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'About Us'],
            ['hero_title', 'Hero title', 'text', '25+ years of efficacy-driven lifecare'],
            ['hero_lead', 'Hero lead', 'textarea', 'From a single injectable for the South Pacific to a Star Export House supplying 24+ countries — the story of Nymak Pharma is a story of quality compounding.'],
            ['overview_title', 'Overview heading', 'text', 'Company overview'],
            ['overview_p1', 'Overview paragraph 1', 'textarea', 'Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, Nymak Pharma embarked on its journey producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. Our beginnings were humble — our first clients were in the South Pacific, where we established our dedication to quality, service and efficacy, always remembering that behind every product is a person in need.'],
            ['overview_p2', 'Overview paragraph 2', 'textarea', 'As our expertise flourished, so did our reach — several island markets across the South Pacific, then Honduras in Central America. Anticipating evolving needs, we diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve.'],
            ['overview_p3', 'Overview paragraph 3', 'textarea', 'Today, with over 25 years of lifecare excellence, Nymak Pharma maintains a presence in more than 24 countries and exported over 200 containers in FY 2023–24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams — all devoted to the highest standards of care and excellence.'],
            ['overview_image', 'Overview image', 'image', 'images/hero/facility-aerial.webp'],
            ['capabilities', 'Capability cards (JSON)', 'json', '[{"icon":"FlaskConical","title":"In-house QC laboratory","text":"Batch lots are analysed by quality control before release."},{"icon":"PackageCheck","title":"QA oversight","text":"A dedicated quality assurance function reviews and approves every release."},{"icon":"Award","title":"Regulatory team","text":"Dossier preparation and product registration support for destination markets."}]', 'Array of {icon, title, text} — icon is a Lucide name.'],
            ['journey_eyebrow', 'Journey eyebrow', 'text', 'Our Journey'],
            ['journey_title', 'Journey title', 'text', 'Milestones that shaped Nymak'],
            ['timeline', 'Timeline entries (JSON)', 'json', '[{"year":"1998","title":"Founded in Gujarat","text":"Mr. Ranjit Advani establishes Nymak Pharma, beginning with Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules for South Pacific markets."},{"year":"2000","title":"The Nigeria milestone","text":"Entry into the Nigerian market lifts export sales by 25% and opens wider expansion across the African continent."},{"year":"2000s","title":"Portfolio diversification","text":"From water for injections, the range grows into pharmaceuticals, IV fluids, medical devices and disposables for export markets."},{"year":"Today","title":"24+ countries, 200+ containers","text":"A Government of India certified Star Export House operating from a WHO-GMP facility in Mundra, with offices in the UK, Sierra Leone and Liberia."}]', 'Array of {year, title, text}.'],
            ['values_eyebrow', 'Values eyebrow', 'text', 'What guides us'],
            ['values_title', 'Values title', 'text', 'Values behind the products'],
            ['values', 'Value cards (JSON)', 'json', '[{"icon":"ShieldCheck","title":"Efficacy","text":"Every product must work as promised. Efficacy is the standard by which we formulate, manufacture and release."},{"icon":"HeartHandshake","title":"Customer-first","text":"Behind every product is a person in need. We build for the patient at the end of the supply chain and the partner who places the order."},{"icon":"BadgeCheck","title":"Sincerity","text":"Transparent dealings, honest documentation, certifications that can be verified. Trust is the real export."}]', 'Array of {icon, title, text} — icon is a Lucide name.'],
            ['credentials_eyebrow', 'Credentials eyebrow', 'text', 'Credentials'],
            ['credentials_title', 'Credentials title', 'text', 'Verified, not just claimed'],
            ['credentials_body', 'Credentials body', 'textarea', 'WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House recognition and Pharmexcil membership — credentials that regulators and partners can verify.'],
        ],
        'manufacturing' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Manufacturing'],
            ['hero_title', 'Hero title', 'text', 'A WHO-GMP facility built for export'],
            ['hero_lead', 'Hero lead', 'textarea', 'Nymak Pharma manufactures at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat — minutes from two of India\'s busiest export ports.'],
            ['overview_title', 'Overview heading', 'text', 'Manufacturing at Mundra'],
            ['overview_p1', 'Overview paragraph 1', 'textarea', 'Our head office and works sit within the Port Biz Industrial Park on the Kandla–Mundra highway in Gujarat — a location chosen deliberately for its direct access to the ports of Mundra and Kandla, the gateways through which over 200 containers of Nymak products shipped in FY 2023–24.'],
            ['overview_p2', 'Overview paragraph 2', 'textarea', 'The facility operates under WHO-GMP certification with ISO 13485:2016 quality management systems. Production is supported by a structure that keeps the critical functions in-house: a quality control laboratory, a quality assurance team, a regulatory affairs team handling dossiers and registrations, a design team for market-compliant packaging, and a logistics function managing warehousing and dispatch.'],
            ['overview_p3', 'Overview paragraph 3', 'textarea', 'Client inspections tell the story better than we can — partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management.'],
            ['facility_image', 'Facility image', 'image', 'images/hero/facility-aerial.webp'],
            ['capabilities_eyebrow', 'Capabilities eyebrow', 'text', 'Capability'],
            ['capabilities_title', 'Capabilities title', 'text', 'What runs inside the facility'],
            ['capabilities_lead', 'Capabilities lead', 'textarea', 'Quality, regulatory, design and logistics under one roof — so partners deal with one accountable team.'],
            ['capabilities', 'Capability cards (JSON)', 'json', '[{"icon":"FlaskConical","title":"In-house QC laboratory","text":"A dedicated quality control laboratory analyses batch lots before release — partners reviewing the facility consistently note well-controlled processes and modern storage."},{"icon":"ClipboardCheck","title":"Quality assurance oversight","text":"A separate QA function reviews and approves every batch before it leaves the facility, ensuring each consignment matches specification and documentation."},{"icon":"FileCheck2","title":"Regulatory & dossier support","text":"An in-house regulatory team prepares and manages product dossiers, supporting registration requirements in destination markets across Africa, Central America and the Pacific."},{"icon":"Package","title":"Design & packaging","text":"An in-house design team produces compliant, market-ready packaging and labelling — including the branded ranges supplied to West African markets."},{"icon":"Warehouse","title":"Warehousing & logistics","text":"Committed warehouse infrastructure with controlled storage, managed by a dedicated logistics head — over 200 containers shipped in FY 2023–24."},{"icon":"Microscope","title":"Continuous up-gradation","text":"The facility operates with a documented focus on innovation and up-gradation of existing facilities, verified through client inspections and audits."}]', 'Array of {icon, title, text} — icon is a Lucide name.'],
            ['dosage_eyebrow', 'Dosage eyebrow', 'text', 'What we make'],
            ['dosage_title', 'Dosage title', 'text', 'Dosage forms & product lines'],
            ['dosage_forms', 'Dosage cards (JSON)', 'json', '[{"title":"IV fluids & infusions","text":"Large-volume parenterals — saline, dextrose, Ringer lactate, multi-electrolyte, therapeutic infusions (100 ml–1000 ml)."},{"title":"Tablets & capsules","text":"Including dispersible, sublingual, sustained-release and combination presentations."},{"title":"Oral liquids","text":"Syrups, suspensions and drops — paediatric and adult formulations."},{"title":"Injections","text":"Ampoules and vials — liquid and dry powder for reconstitution."},{"title":"Medical devices","text":"IV access, infusion sets, syringes, needles and patient-care consumables."},{"title":"Diagnostics & antisera","text":"Rapid test kits, snake venom antiserum and tetanus antitoxin."}]', 'Array of {title, text}.'],
        ],
        'quality' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Quality & Certifications'],
            ['hero_title', 'Hero title', 'text', 'Certified quality, verifiable compliance'],
            ['hero_lead', 'Hero lead', 'textarea', 'Every accolade reflects our commitment to quality, integrity and the partners who rely on our products — WHO-GMP, ISO 13485:2016, Star Export House and more.'],
            ['cred_eyebrow', 'Credentials eyebrow', 'text', 'Credentials'],
            ['cred_title', 'Credentials title', 'text', 'Awards & certifications'],
            ['cred_lead', 'Credentials lead', 'textarea', 'Certificates are available to partners for verification during registration and audits.'],
            ['cert_iso_image', 'ISO certificate scan', 'image', 'images/certifications/iso-13485-certificate.webp'],
            ['cert_star_image', 'Star Export House scan', 'image', 'images/certifications/star-export-house-certificate.webp'],
            ['system_title', 'System heading', 'text', 'How quality works here'],
            ['system_p1', 'System paragraph 1', 'textarea', 'Quality at Nymak is not a department — it is the sequence every product passes through. Raw materials are controlled on entry, production follows documented GMP processes, batch lots are analysed by the in-house QC laboratory, and a separate QA function reviews each release before dispatch.'],
            ['system_p2', 'System paragraph 2', 'textarea', 'Around production sits the supporting structure: a regulatory team preparing dossiers for destination-market registration, a design team producing compliant labelling, and warehouse teams maintaining controlled storage through to shipment.'],
            ['system_p3', 'System paragraph 3', 'textarea', 'This is what partners verify when they audit us — and what the WHO-GMP, ISO 13485 and Star Export House credentials certify from the outside.'],
            ['faq_title', 'FAQ sidebar heading', 'text', 'Quality questions'],
        ],
        'contact' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Contact Us'],
            ['hero_title', 'Hero title', 'text', 'Let\'s talk about your market'],
            ['hero_lead', 'Hero lead', 'textarea', 'Whether you\'re a distributor, hospital, NGO or health programme — tell us your requirement and our exports team will respond.'],
            ['form_title', 'Form heading', 'text', 'Send an enquiry'],
            ['form_lead', 'Form subheading', 'text', 'Fields marked * are required.'],
        ],
        'products.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Our Products'],
            ['hero_title', 'Hero title', 'text', 'A pharmaceutical export portfolio built for real-world need'],
            ['hero_lead', 'Hero lead', 'textarea', 'Five segments, 300+ line items, one manufacturing standard. Every product below ships under WHO-GMP conditions with registration support for your market.'],
            ['cta_card_title', 'Enquiry card title', 'text', 'Need something specific?'],
            ['cta_card_body', 'Enquiry card body', 'textarea', 'Our regulatory team supports custom presentations, pack sizes and market-specific registrations. Tell us what your market needs.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Branded Portfolio'],
            ['brands_title', 'Brands title', 'text', 'Registered Nymak brands in market'],
            ['brands_lead', 'Brands lead', 'textarea', 'Products marketed under Nymak brand names in West African markets — Alumak, Cefmak, Cipromak, Clavmak and more.'],
        ],
        'markets.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Global Presence'],
            ['hero_title', 'Hero title', 'text', 'Healthcare products to 24+ countries — and counting'],
            ['hero_lead', 'Hero lead', 'textarea', 'From the South Pacific to West Africa to Central America: through every step, our commitment is to deliver quality, efficacious products and leave a positive footprint wherever we go.'],
            ['markets_eyebrow', 'Markets eyebrow', 'text', 'Key Markets'],
            ['markets_title', 'Markets title', 'text', 'Where we operate directly'],
            ['footprint_eyebrow', 'Footprint eyebrow', 'text', 'Export Footprint'],
            ['footprint_title', 'Footprint title', 'text', 'Every container tells a story'],
            ['footprint_body', 'Footprint body', 'textarea', 'More than 200 containers shipped in FY 2023–24. Below are the markets we serve — and the number keeps growing.'],
            ['offices_eyebrow', 'Offices eyebrow', 'text', 'On the Ground'],
            ['offices_title', 'Offices title', 'text', 'International offices & partners'],
            ['cta_title', 'CTA title', 'text', 'Don\'t see your market?'],
            ['cta_body', 'CTA body', 'textarea', 'We open new markets with the right partners. If you distribute pharmaceuticals or manage public health procurement, let\'s discuss your territory.'],
        ],
        'posts.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Blog & Resources'],
            ['hero_title', 'Hero title', 'text', 'Insights from inside pharmaceutical exports'],
            ['hero_lead', 'Hero lead', 'textarea', 'Company news, quality explainers and product knowledge from the Nymak team.'],
        ],
        'faqs' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'FAQs'],
            ['hero_title', 'Hero title', 'text', 'Frequently asked questions'],
            ['hero_lead', 'Hero lead', 'textarea', 'Direct answers about who we are, what we manufacture, where we export and how to work with us.'],
            ['cta_title', 'CTA title', 'text', 'Still have a question?'],
            ['cta_body', 'CTA body', 'textarea', 'Our exports and regulatory teams respond to every enquiry — products, pricing, registration, packaging and logistics.'],
        ],
    ];

    public const PAGE_LABELS = [
        'home' => 'Home',
        'about' => 'About Us',
        'manufacturing' => 'Manufacturing',
        'quality' => 'Quality & Certifications',
        'contact' => 'Contact Us',
        'products.index' => 'Products (overview)',
        'markets.index' => 'Global Presence',
        'posts.index' => 'Blog / Resources',
        'faqs' => 'FAQs',
    ];

    /** Resolved slot map for a page — DB overrides merged over defaults. */
    public static function for(string $page): array
    {
        $stored = static::where('page', $page)->pluck('value', 'key');

        return collect(static::SCHEMA[$page] ?? [])->mapWithKeys(function ($f) use ($stored) {
            [$key, , $type, $default] = $f;
            $value = $stored->get($key);
            $resolved = ($value !== null && $value !== '') ? $value : $default;

            return [$key => $type === 'json' ? (json_decode($resolved, true) ?? []) : $resolved];
        })->all();
    }

    /** Field definitions for the admin editor. */
    public static function fieldsFor(string $page): array
    {
        return collect(static::SCHEMA[$page] ?? [])->map(fn ($f) => [
            'name' => $f[0], 'label' => $f[1], 'type' => $f[2],
            'default' => $f[3], 'help' => $f[4] ?? null,
        ])->all();
    }
}
