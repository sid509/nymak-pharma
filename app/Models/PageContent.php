<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Admin-editable content slots for public pages. Each page declares a SCHEMA
 * of named slots (text / textarea / richtext / image / json / toggle). Stored rows override the
 * declared default; PageContent::for() resolves the full map for controllers.
 */
class PageContent extends Model
{
    protected $fillable = ['page', 'key', 'value'];

    /**
     * page => [ [key, label, type, default, help?], ... ]
     * image values are web-relative paths under public/images/.
     * json values decode to arrays (repeating lists like timeline entries).
     * toggle values resolve to booleans ('1'/'0'); richtext is sanitised HTML.
     */
    public const SCHEMA = [
        'home' => [
            // Hero
            ['hero_badge', 'Hero badge', 'text', 'WHO-GMP Certified · Star Export House'],
            ['hero_title', 'Hero headline', 'text', '25+ years of Efficacy-Driven lifecare'],
            ['hero_subtitle', 'Hero subtitle', 'textarea', 'Your Reliable Partner in Efficacious Lifecare Solutions — trusted in 24 countries and counting. A WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices, rapid diagnostic kits and vaccines.'],
            ['hero_image', 'Hero background image', 'image', 'images/hero/facility-aerial.webp'],
            ['hero_primary_label', 'Hero: primary button label', 'text', 'Explore Our Products'],
            ['hero_primary_url', 'Hero: primary button link', 'text', '/products'],
            ['hero_secondary_label', 'Hero: secondary button label', 'text', 'Partner With Us'],
            ['hero_secondary_url', 'Hero: secondary button link', 'text', '/contact'],
            // Stats
            ['show_stats', 'Show stats band', 'toggle', '1'],
            ['stats_years_label', 'Stat label: years', 'text', 'Years of Lifecare'],
            ['stats_countries_label', 'Stat label: countries', 'text', 'Export Countries'],
            ['stats_containers_label', 'Stat label: containers', 'text', 'Containers per FY'],
            ['stats_products_label', 'Stat label: products', 'text', 'Products in Portfolio'],
            // About
            ['show_about', 'Show about section', 'toggle', '1'],
            ['about_eyebrow', 'About section eyebrow', 'text', 'About Nymak Pharma'],
            ['about_title', 'About section title', 'text', 'A pharmaceutical manufacturer India has exported through since 1998'],
            ['about_p1', 'About paragraph 1', 'textarea', 'Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP in plastic ampoules, serving the South Pacific. From those beginnings we grew into Honduras, then Nigeria in 2000 — a milestone that lifted exports by 25% and opened our expansion across Africa.'],
            ['about_p2', 'About paragraph 2', 'textarea', 'Today we operate from a WHO-GMP certified facility in Mundra, Gujarat, supported by in-house regulatory, laboratory, QC/QA and design teams — and recognised as a Government of India certified Star Export House.'],
            ['about_image', 'About section image', 'image', 'images/hero/facility-aerial.webp'],
            ['about_cta_label', 'About: primary button label', 'text', 'Our Story'],
            ['about_cta2_label', 'About: secondary button label', 'text', 'See our facility'],
            ['about_badge_caption', 'About: image badge caption', 'text', 'Mundra, Gujarat, India'],
            // Categories
            ['show_categories', 'Show product categories', 'toggle', '1'],
            ['portfolio_eyebrow', 'Categories eyebrow', 'text', 'Our Portfolio'],
            ['portfolio_title', 'Categories title', 'text', 'Five product segments, one quality standard'],
            ['portfolio_lead', 'Categories lead', 'textarea', 'A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes.'],
            ['portfolio_card_label', 'Categories: card link label', 'text', 'Explore category'],
            ['portfolio_cta_label', 'Categories: overview button label', 'text', 'All product categories'],
            // Brands (off by default — the home page is a company page, not a catalogue)
            ['show_brands', 'Show branded products grid', 'toggle', '0', 'Off by default — products belong on the inner catalogue pages.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Marketed Brands'],
            ['brands_title', 'Brands title', 'text', 'The Nymak branded range'],
            ['brands_lead', 'Brands lead', 'textarea', 'Registered brands supplied across West African markets — each manufactured under WHO-GMP conditions.'],
            // Quality
            ['show_quality', 'Show quality section', 'toggle', '1'],
            ['quality_eyebrow', 'Quality eyebrow', 'text', 'Quality & Compliance'],
            ['quality_title', 'Quality title', 'text', 'Certified for the markets that demand proof'],
            ['quality_body', 'Quality body', 'textarea', 'Every batch is analysed by our in-house QC laboratory and released through QA review. Each accolade reflects our deep-rooted commitment to quality, integrity and global healthcare excellence — standing for the trust of our partners, the safety of our products, and the lives we strive to improve.'],
            ['quality_cta_label', 'Quality: button label', 'text', 'All certifications'],
            // Global presence
            ['show_global', 'Show global presence section', 'toggle', '1'],
            ['global_eyebrow', 'Global eyebrow', 'text', 'Global Presence'],
            ['global_title', 'Global title', 'text', 'From Mundra to 24+ country markets'],
            ['global_body', 'Global body', 'textarea', 'Operating across West, Central and East Africa, Central America and the South Pacific — with offices in the UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships.'],
            ['global_cta_label', 'Global: button label', 'text', 'Explore our markets'],
            ['global_more_label', 'Global: "more markets" tile', 'text', '+ more markets'],
            // Testimonials
            ['show_testimonials', 'Show testimonials', 'toggle', '1'],
            ['testimonials_eyebrow', 'Testimonials eyebrow', 'text', 'Partner Feedback'],
            ['testimonials_title', 'Testimonials title', 'text', 'What our clients say'],
            // Clients
            ['show_clients', 'Show client logo strip', 'toggle', '1'],
            ['clients_lead', 'Client strip label', 'text', 'Trusted by pharmaceutical partners across markets'],
            // FAQs
            ['show_faqs', 'Show FAQ section', 'toggle', '1'],
            ['faq_eyebrow', 'FAQ eyebrow', 'text', 'FAQs'],
            ['faq_title', 'FAQ title', 'text', 'Questions partners ask us'],
            ['faq_lead', 'FAQ lead', 'textarea', 'Straight answers about who we are, what we make, and how we export.'],
            ['faq_cta_label', 'FAQ: button label', 'text', 'All FAQs'],
            // Journal
            ['show_journal', 'Show latest articles', 'toggle', '1'],
            ['journal_eyebrow', 'Journal eyebrow', 'text', 'Insights'],
            ['journal_title', 'Journal title', 'text', 'From the Nymak journal'],
            ['journal_cta_label', 'Journal: button label', 'text', 'All articles'],
            // Closing CTA
            ['show_cta', 'Show closing contact CTA', 'toggle', '1'],
            ['cta_title', 'CTA title', 'text', 'Have a requirement? Let\'s talk.'],
            ['cta_body', 'CTA body', 'textarea', 'Product enquiries, distribution partnerships, tenders and registration support — our exports team responds to every enquiry.'],
            ['cta_primary_label', 'CTA: primary button label', 'text', 'Contact us'],
            ['show_cta_whatsapp', 'CTA: show WhatsApp button', 'toggle', '1'],
            ['cta_whatsapp_label', 'CTA: WhatsApp button label', 'text', 'WhatsApp us'],
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
            ['show_story', 'Show founder story', 'toggle', '1'],
            ['story_eyebrow', 'Founder story eyebrow', 'text', 'Our Story'],
            ['story_title', 'Founder story title', 'text', 'It began at a single desk in 1998'],
            ['story_p1', 'Founder story paragraph 1', 'textarea', 'Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani — pharmacist, entrepreneur and our founder — set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.'],
            ['story_p2', 'Founder story paragraph 2', 'textarea', 'The first product was Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. The first clients were in the South Pacific — hospitals and medical stores thousands of kilometres from the nearest manufacturer. Every consignment carried the same principle: behind every product is a person in need.'],
            ['story_p3', 'Founder story paragraph 3', 'textarea', 'The early photographs tell it best — the first office, the first labelled cartons bound for Lae, the first containers rolling to port. Twenty-five years on, the desk has become a WHO-GMP facility serving 24+ countries. The conviction has not changed.'],
            ['story_image', 'Founder story photo', 'image', 'images/about/founder-1998.png'],
            ['story_image_caption', 'Founder photo caption', 'text', 'Mr. Ranjit Advani in the first Nymak office, c. 1998'],
            ['story_badge_number', 'Story badge number', 'text', '25+'],
            ['story_badge_label', 'Story badge label', 'text', 'Years of lifecare'],
            ['story_archive_1', 'Archive photo 1', 'image', 'images/about/early-consignment.jpg'],
            ['story_archive_1_caption', 'Archive photo 1 caption', 'text', 'Consignment bound for Lae, Papua New Guinea'],
            ['story_archive_2', 'Archive photo 2', 'image', 'images/about/early-dispatch.jpg'],
            ['story_archive_2_caption', 'Archive photo 2 caption', 'text', 'Early container dispatch to port'],
            ['story_signature_name', 'Story signature name', 'text', 'Mr. Ranjit Advani'],
            ['story_signature_role', 'Story signature role', 'text', 'Founder & Mentor'],
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
            ['cred_lead', 'Credentials lead', 'textarea', 'Each accolade and certification reflects our deep-rooted commitment to quality, integrity and global healthcare excellence — the trust of our partners, the safety of our products, and the lives we strive to improve. Certificates are available to partners for verification during registration and audits.'],
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
            ['hero_lead', 'Hero lead', 'textarea', 'Five segments, 300+ line items, one manufacturing standard. Every product ships under WHO-GMP conditions with registration support for your market.'],
            ['card_label', 'Category card link label', 'text', 'Explore category'],
            ['show_cta_card', 'Show contact card in the grid', 'toggle', '1'],
            ['cta_card_title', 'Contact card title', 'text', 'Need something specific?'],
            ['cta_card_body', 'Contact card body', 'textarea', 'Our regulatory team supports custom presentations, pack sizes and market-specific registrations. Tell us what your market needs.'],
            ['cta_card_button', 'Contact card button label', 'text', 'Contact us'],
            ['show_brands', 'Show branded products grid', 'toggle', '0', 'Off by default — keeps the overview focused on categories.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Branded Portfolio'],
            ['brands_title', 'Brands title', 'text', 'Registered Nymak brands in market'],
            ['brands_lead', 'Brands lead', 'textarea', 'Products marketed under Nymak brand names in West African markets — Alumak, Cefmak, Cipromak and more.'],
        ],
        // Shared layout copy for every category landing page (/product/{category}).
        // Per-category content lives on the category itself (admin → Categories).
        'products.category' => [
            ['eyebrow', 'Hero eyebrow', 'text', 'Product Category'],
            ['show_siblings', 'Show other categories sidebar', 'toggle', '1'],
            ['siblings_title', 'Sidebar heading', 'text', 'Categories'],
            ['siblings_all_label', 'Sidebar "all" link label', 'text', 'All Products'],
            ['range_eyebrow', 'Range summary eyebrow', 'text', 'In this category'],
            ['range_title', 'Range summary title', 'text', 'What the range covers', 'Use {category} to insert the category name.'],
            ['range_lead', 'Range summary lead', 'textarea', 'The full product list with strengths and pack sizes is one click away.'],
            ['catalogue_label', 'Product list button label', 'text', 'View all {category} products', 'Use {category} / {count} placeholders.'],
            ['show_cta', 'Show contact CTA', 'toggle', '1'],
            ['cta_title', 'Contact CTA title', 'text', 'Sourcing {category} for your market?'],
            ['cta_body', 'Contact CTA body', 'textarea', 'We support registration dossiers, market-specific packaging and container logistics. Tell us your requirement and destination market.'],
            ['cta_button', 'Contact CTA button label', 'text', 'Contact us'],
        ],
        // Product list page (/product/{category}/products).
        'products.catalogue' => [
            ['eyebrow', 'Hero eyebrow', 'text', 'Product List'],
            ['title', 'Hero title', 'text', '{category} — full product list', 'Use {category} / {count} placeholders.'],
            ['lead', 'Hero lead', 'textarea', 'Every product we manufacture or supply in this category, with strengths and pack sizes. Names with a link open a product page.'],
            ['branded_title', 'Branded range heading', 'text', 'Nymak branded range'],
            ['search_label', 'Search label', 'text', 'Search this list ({count} products)'],
            ['search_placeholder', 'Search placeholder', 'text', 'e.g. ceftriaxone, infusion, tablets…'],
            ['empty_title', 'No-results title', 'text', 'No products match “{query}”.'],
            ['empty_body', 'No-results body', 'text', 'Try a generic name or therapeutic class — or ask us directly.'],
            ['back_label', 'Back-to-category link label', 'text', 'About {category}'],
            ['show_cta', 'Show contact CTA', 'toggle', '1'],
            ['cta_title', 'Contact CTA title', 'text', 'Don\'t see what you need?'],
            ['cta_body', 'Contact CTA body', 'textarea', 'Our portfolio extends beyond this list. Send us the molecule, strength and destination market and we will confirm availability.'],
            ['cta_button', 'Contact CTA button label', 'text', 'Contact us'],
        ],
        // Product detail page (/product/{category}/{product}).
        'products.show' => [
            ['standard_label', 'Spec row: standard label', 'text', 'Standard'],
            ['standard_value', 'Spec row: standard value', 'text', 'Manufactured under WHO-GMP conditions'],
            ['show_market', 'Show "marketed in" row', 'toggle', '1'],
            ['cta_button', 'Primary button label', 'text', 'Contact us about this product'],
            ['back_label', 'Back button label', 'text', 'Back to {category}'],
            ['show_related', 'Show related products', 'toggle', '1'],
            ['related_title', 'Related products heading', 'text', 'Related products'],
            ['show_support', 'Show export support banner', 'toggle', '1'],
            ['support_title', 'Support banner title', 'text', 'Export & registration support'],
            ['support_body', 'Support banner body', 'textarea', 'Our regulatory team supports dossiers, market-specific labelling and registration requirements. Tell us your destination market.'],
            ['support_button', 'Support banner button label', 'text', 'Contact exports team'],
        ],
        'markets.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Global Presence'],
            ['hero_title', 'Hero title', 'text', 'Healthcare products to 24+ countries — and counting'],
            ['hero_lead', 'Hero lead', 'textarea', 'Operating in over 24 countries like Somalia, Kenya, D R Congo, Nigeria and Sierra Leone, we bring more than healthcare products — we bring dedication. Through every step, our commitment is clear: to improve lives by delivering quality and efficacious products and leaving a positive footprint wherever we go.'],
            ['map_eyebrow', 'Map eyebrow', 'text', 'Where We Work'],
            ['map_title', 'Map title', 'text', 'One supply line from Mundra to the world'],
            ['map_lead', 'Map lead', 'textarea', 'Every arc on the globe is a live supply route from our Mundra facility. Drag to spin, click a highlighted country — or pick from the list — to see the work, the products and the people on the ground.'],
            ['map_empty_title', 'Map panel placeholder title', 'text', 'Spin the globe — pick a country'],
            ['map_empty_body', 'Map panel placeholder body', 'textarea', 'Highlighted countries are where we export today. Select one to read what we do there and which products we supply.'],
            ['map_empty_cta', 'Map panel placeholder CTA label', 'text', 'Your market not listed? Ask us'],
            ['map_market_empty_title', 'Map panel: empty-country title', 'text', 'We serve {country} through export partners'],
            ['map_market_empty_body', 'Map panel: empty-country body', 'textarea', 'Our {country} portfolio grows with demand. If you are a distributor, hospital group or programme buyer there, ask us what we currently supply and which dossiers we can support.'],
            ['map_market_cta', 'Map panel: empty-country CTA label', 'text', 'Talk to our export team'],
            ['footprint_eyebrow', 'Footprint eyebrow', 'text', 'Export Footprint'],
            ['footprint_title', 'Footprint title', 'text', 'Every container tells a story'],
            ['footprint_body', 'Footprint body', 'textarea', 'More than 200 containers shipped in FY 2023–24 to 24+ countries across four regions — and the number keeps growing.'],
            ['footprint_stats', 'Footprint stats (JSON)', 'json', '[{"value":"24+","label":"Countries served"},{"value":"200+","label":"Containers in FY 2023–24"},{"value":"4","label":"Regions"},{"value":"3","label":"International offices"}]', 'Array of {value, label}.'],
            ['offices_eyebrow', 'Offices eyebrow', 'text', 'On the Ground'],
            ['offices_title', 'Offices title', 'text', 'International offices & partners'],
            ['cta_title', 'CTA title', 'text', 'Don\'t see your market?'],
            ['cta_body', 'CTA body', 'textarea', 'We open new markets with the right partners. If you distribute pharmaceuticals or manage public health procurement, let\'s discuss your territory.'],
            ['cta_label', 'CTA primary button label', 'text', 'Start the conversation'],
            ['cta_alt_label', 'CTA secondary button label', 'text', 'WhatsApp our export team'],
        ],
        'posts.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Blog & Resources'],
            ['hero_title', 'Hero title', 'text', 'Insights from inside pharmaceutical exports'],
            ['hero_lead', 'Hero lead', 'textarea', 'Company news, quality explainers and product knowledge from the Nymak team.'],
        ],
        'team.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Our Team'],
            ['hero_title', 'Hero title', 'text', 'The people behind the promise'],
            ['hero_lead', 'Hero lead', 'textarea', 'Behind every innovation, every product, and every promise we make — stands a team united by expertise and empathy. We combine clinical precision with heartfelt commitment to deliver quality healthcare solutions that truly make a difference.'],
            ['leadership_eyebrow', 'Leadership eyebrow', 'text', 'Leadership'],
            ['leadership_title', 'Leadership title', 'text', 'Guided by experience'],
            ['team_eyebrow', 'Team eyebrow', 'text', 'Specialists'],
            ['team_title', 'Team title', 'text', 'Every discipline, one standard'],
        ],
        'inside' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Inside Nymak'],
            ['hero_title', 'Hero title', 'text', 'From a single ampoule to 24+ countries'],
            ['hero_lead', 'Hero lead', 'textarea', 'Scroll through the story of how a 1998 startup in Mundra became an exporter trusted across four regions.'],
            ['story_eyebrow', 'Story section eyebrow', 'text', 'The Journey'],
            ['story_title', 'Story section title', 'text', 'How we got here'],
            ['journey', 'Timeline entries (JSON)', 'json', '[{"year":"1998","title":"Founded in Gujarat","text":"Mr. Ranjit Advani establishes Nymak Pharma, beginning with Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules for South Pacific markets.","icon":"Sprout"},{"year":"2000","title":"The Nigeria milestone","text":"Entry into Nigeria lifts export sales by 25% and opens wider expansion across Africa; Honduras joins the map in Central America.","icon":"Globe2"},{"year":"2002","title":"Beyond ampoules","text":"The range diversifies from water-for-injections into a broader pharmaceutical formulations portfolio for export markets.","icon":"Package"},{"year":"2004","title":"IV fluids & infusions","text":"Large-volume parenterals join the line — saline, dextrose, Ringer lactate and multi-electrolyte infusions.","icon":"Droplets"},{"year":"2006","title":"Devices & disposables","text":"IV access, infusion sets, syringes and patient-care consumables extend Nymak beyond medicines.","icon":"Syringe"},{"year":"2008","title":"Quality in-house","text":"A dedicated quality control laboratory is established — every batch analysed before release.","icon":"FlaskConical"},{"year":"2010","title":"Rapid diagnostics","text":"Rapid test kits for malaria, typhoid and HIV join the portfolio for public-health programmes.","icon":"Microscope"},{"year":"2012","title":"Regulatory under one roof","text":"Dossier preparation, market registration support and compliant packaging design brought in-house.","icon":"FileCheck2"},{"year":"2014","title":"ISO 13485 certified","text":"The quality management system is certified for medical device manufacturing.","icon":"BadgeCheck"},{"year":"2016","title":"The branded range","text":"Alumak, Cefmak, Cipromak and sister brands register across West African markets.","icon":"Tag"},{"year":"2018","title":"UK office opens","text":"A London presence brings partner-facing regulatory and commercial support closer to market.","icon":"Building2"},{"year":"2020","title":"Through the pandemic","text":"Essential medicines, IV fluids and disposables keep flowing to partner markets through global disruption.","icon":"ShieldCheck"},{"year":"2022","title":"Star Export House","text":"The Government of India certifies Nymak a Star Export House in recognition of export performance.","icon":"Award"},{"year":"2024","title":"24+ countries, 200+ containers","text":"A record year — over 200 containers shipped in FY 2023–24, with offices in Sierra Leone and Liberia serving West Africa.","icon":"Ship"}]', 'Array of {year, title, text, icon} — icon is a Lucide name.'],
            ['explorer_eyebrow', 'Market explorer eyebrow', 'text', 'Global Footprint'],
            ['explorer_title', 'Market explorer title', 'text', 'Tap a market. See what we built there.'],
            ['explorer_lead', 'Market explorer lead', 'textarea', 'Each country below is a real operating relationship — select one to see the products we supply there today.'],
            ['cta_title', 'Closing CTA title', 'text', 'Ready to write the next chapter with us?'],
            ['cta_body', 'Closing CTA body', 'textarea', 'Distributors, ministries and hospital groups — tell us what your market needs and we will scope a supply plan.'],
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
        'products.category' => 'Product category pages (layout)',
        'products.catalogue' => 'Product list pages',
        'products.show' => 'Product detail pages',
        'markets.index' => 'Global Presence',
        'posts.index' => 'Blog / Resources',
        'team.index' => 'Team',
        'inside' => 'Inside Nymak (interactive)',
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

            return [$key => match ($type) {
                'json' => json_decode($resolved, true) ?? [],
                'toggle' => filter_var($resolved, FILTER_VALIDATE_BOOLEAN),
                default => $resolved,
            }];
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
