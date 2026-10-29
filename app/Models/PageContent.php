<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

/**
 * Admin-editable content slots for public pages. Each page declares a SCHEMA
 * of named slots (text / textarea / richtext / image / json / toggle). Stored rows override the
 * declared default; PageContent::for() resolves the full map for controllers.
 */
class PageContent extends Model
{
    use HasTranslations;

    protected $fillable = ['page', 'key', 'value', 'i18n'];

    protected $translatable = ['value'];

    protected $casts = ['i18n' => 'array'];

    /** Slot types whose `value` holds visitor-facing copy. */
    public const TRANSLATABLE_TYPES = ['text', 'textarea', 'richtext'];

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
            ['hero_title', 'Hero headline', 'text', '25+ years of efficacy-driven lifecare from a pharmaceutical exporter India trusts'],
            ['hero_subtitle', 'Hero subtitle', 'textarea', 'Trusted in 24 countries and counting. Among pharma manufacturers in India, Nymak Pharma stands apart: a WHO-GMP certified Star Export House supplying IV fluids, formulations, devices and diagnostics.'],
            ['hero_image', 'Hero background image', 'image', 'images/hero/facility-aerial.webp'],
            ['hero_primary_label', 'Hero: primary button label', 'text', 'Explore Our Products'],
            ['hero_primary_url', 'Hero: primary button link', 'text', '/products'],
            ['hero_secondary_label', 'Hero: secondary button label', 'text', 'Contact Us'],
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
            ['about_title', 'About section title', 'text', 'Pharma manufacturers in India exporting since 1998'],
            ['about_p1', 'About paragraph 1', 'textarea', 'Founded in 1998 by Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for Injections BP supplied to hospitals across the South Pacific. Today the journey spans 24+ countries on four continents.'],
            ['about_p2', 'About paragraph 2', 'textarea', 'What sets us apart among pharma companies in India is how much sits under one roof: a WHO-GMP facility in Mundra, Gujarat with in-house regulatory, QC laboratory, QA and design teams producing compliant, market-ready packaging.'],
            ['about_p3', 'About paragraph 3', 'textarea', 'Among Indian pharmaceutical manufacturers, Nymak is a Government of India certified Star Export House shipping 200+ containers in FY 2023-24, where one team answers for the product, the paperwork, the packaging and the port.'],
            ['about_image', 'About section image', 'image', 'images/hero/facility-aerial.webp'],
            ['about_cta_label', 'About: primary button label', 'text', 'Our Story'],
            ['about_cta2_label', 'About: secondary button label', 'text', 'See our facility'],
            ['about_badge_caption', 'About: image badge caption', 'text', 'Mundra, Gujarat, India'],
            // Categories
            ['show_categories', 'Show product categories', 'toggle', '1'],
            ['portfolio_eyebrow', 'Categories eyebrow', 'text', 'Our Portfolio'],
            ['portfolio_title', 'Categories title', 'text', 'Four product segments, one quality standard'],
            ['portfolio_lead', 'Categories lead', 'textarea', 'A pharmaceutical export portfolio for hospitals, distributors, NGOs and public health programmes, organised by pharmaceutical suppliers in India into four segments: IV fluids, finished formulations, medical devices and rapid diagnostic kits.'],
            ['portfolio_card_label', 'Categories: card link label', 'text', 'Explore category'],
            ['portfolio_cta_label', 'Categories: overview button label', 'text', 'All product categories'],
            // Branded range strip (approved homepage section per the content plan)
            ['show_brands', 'Show branded products grid', 'toggle', '1', 'Toggle to hide the branded range on the live page.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Marketed Brands'],
            ['brands_title', 'Brands title', 'text', 'The Nymak branded range'],
            ['brands_lead', 'Brands lead', 'textarea', 'Registered Nymak brands supplied across West Africa under WHO-GMP conditions: Alumak, Cefmak, Cipromak, Zincomak and more.'],
            // Quality
            ['show_quality', 'Show quality section', 'toggle', '1'],
            ['quality_eyebrow', 'Quality eyebrow', 'text', 'Quality & Compliance'],
            ['quality_title', 'Quality title', 'text', 'Certified for the markets that demand proof'],
            ['quality_body', 'Quality body', 'textarea', 'Every batch is analysed by our in-house QC laboratory and released only after QA review. WHO-GMP, ISO 13485:2016, Star Export House and Pharmexcil systems are maintained as living, audited processes.'],
            ['quality_cta_label', 'Quality: button label', 'text', 'All certifications'],
            // Global presence
            ['show_global', 'Show global presence section', 'toggle', '1'],
            ['global_eyebrow', 'Global eyebrow', 'text', 'Global Presence'],
            ['global_title', 'Global title', 'text', 'From India to 24+ countries'],
            ['global_body', 'Global body', 'textarea', 'A pharmaceutical exporter India dispatches from to 24+ countries across Africa, the Middle East, Asia and the Pacific, with offices in the UK, Sierra Leone and Liberia.'],
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
            ['faq_lead', 'FAQ lead', 'textarea', 'Straight answers about who we are, what we make and how we export.'],
            ['faq_cta_label', 'FAQ: button label', 'text', 'All FAQs'],
            // Journal
            ['show_journal', 'Show latest articles', 'toggle', '1'],
            ['journal_eyebrow', 'Journal eyebrow', 'text', 'Insights'],
            ['journal_title', 'Journal title', 'text', 'From the Nymak journal'],
            ['journal_cta_label', 'Journal: button label', 'text', 'All articles'],
            // Closing CTA
            ['show_cta', 'Show closing contact CTA', 'toggle', '1'],
            ['cta_title', 'CTA title', 'text', 'Have a requirement? Let\'s talk.'],
            ['cta_body', 'CTA body', 'textarea', 'Product enquiries, distribution partnerships, tenders and registration support: our exports team responds to every enquiry.'],
            ['cta_primary_label', 'CTA: primary button label', 'text', 'Contact us'],
            ['show_cta_whatsapp', 'CTA: show WhatsApp button', 'toggle', '1'],
            ['cta_whatsapp_label', 'CTA: WhatsApp button label', 'text', 'WhatsApp us'],
        ],
        'about' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'About Us'],
            ['hero_title', 'Hero title', 'text', 'Among pharmaceutical companies in India since 1998'],
            ['hero_lead', 'Hero lead', 'textarea', 'From a single injectable for the South Pacific to a Star Export House supplying 24+ countries. The story of Nymak Pharma is a story of quality compounding.'],
            ['overview_title', 'Overview heading', 'text', 'Company overview'],
            ['overview_p1', 'Overview paragraph 1', 'textarea', 'Among pharmaceutical companies in India, Nymak Pharma began small and stayed deliberate. Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, the company embarked on its journey producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. Our beginnings were humble. Our first clients were in the South Pacific, where we established our dedication to quality, service and efficacy, always remembering that behind every product is a person in need.'],
            ['overview_p2', 'Overview paragraph 2', 'textarea', 'As our expertise flourished, so did our reach: several island markets across the South Pacific, then Central America, and a milestone entry into Nigeria in 2000 that lifted exports by 25%. Anticipating evolving needs, this Indian pharma manufacturing company diversified into a wide array of pharmaceuticals and medical devices built for the healthcare challenges faced by the communities we serve: IV fluids and infusions, finished formulations, medical devices and disposables, and rapid diagnostic kits.'],
            ['overview_p3', 'Overview paragraph 3', 'textarea', 'Today, with over 25 years of lifecare excellence, Nymak Pharma is a pharmaceutical company based in Gujarat maintaining a presence in more than 24 countries. We exported over 200 containers in FY 2023-24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team preparing product dossiers, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams, all devoted to the highest standards of care and excellence in the pharma industry India is known for. It is the operating standard a leading pharmaceutical company in India is judged by.'],
            ['overview_image', 'Overview image', 'image', 'images/hero/facility-aerial.webp'],
            ['capabilities', 'Capability cards (JSON)', 'json', '[{"icon":"faFlask","title":"In-house QC laboratory","text":"Batch lots are analysed by quality control before release."},{"icon":"faBoxesStacked","title":"QA oversight","text":"A dedicated quality assurance function reviews and approves every release."},{"icon":"faAward","title":"Regulatory team","text":"Dossier preparation and product registration support for destination markets."}]', 'Array of {icon, title, text}: icon is a Font Awesome name (e.g. faFlask).'],
            ['show_story', 'Show founder story', 'toggle', '1'],
            ['story_eyebrow', 'Founder story eyebrow', 'text', 'Our Story'],
            ['story_title', 'Founder story title', 'text', 'It began at a single desk in 1998'],
            ['story_p1', 'Founder story paragraph 1', 'textarea', 'Among pharma companies in India, Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani, entrepreneur and our founder, set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.'],
            ['story_p2', 'Founder story paragraph 2', 'textarea', 'The first product was Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. The first clients were in the South Pacific: hospitals and medical stores thousands of kilometres from dependable supply. Every consignment carried the same principle: behind every product is a person in need.'],
            ['story_p3', 'Founder story paragraph 3', 'textarea', 'The early photographs tell it best: the first office, the first labelled cartons bound for Lae, the first containers rolling to port. Twenty-five years on, the desk has become a WHO-GMP facility serving 24+ countries. The conviction has not changed.'],
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
            ['journey_eyebrow', 'Journey eyebrow', 'text', 'Since 1998'],
            ['journey_title', 'Journey title', 'text', 'Our Journey'],
            ['journey_partners', 'Affiliate companies (JSON)', 'json', '[{"name":"Coral Marketing"},{"name":"Core Africa Liberia Inc.","image":"images/clients/core-africa-liberia-inc.webp"},{"name":"Core Africa (SL) Ltd","image":"images/clients/core-africa-liberia-inc.webp"}]', 'Array of {name, image?}: logos row shown above the journey timeline.'],
            ['values_eyebrow', 'Values eyebrow', 'text', 'What guides us'],
            ['values_title', 'Values title', 'text', 'Values behind the products'],
            ['values', 'Value cards (JSON)', 'json', '[{"icon":"faShieldHalved","title":"Efficacy","text":"Every product must work as promised. Efficacy is the standard by which we formulate, manufacture and release."},{"icon":"faHandHoldingHeart","title":"Customer-first","text":"Behind every product is a person in need. We build for the patient at the end of the supply chain and the partner who places the order."},{"icon":"faCircleCheck","title":"Sincerity","text":"Transparent dealings, honest documentation, certifications that can be verified. Trust is the real export."}]', 'Array of {icon, title, text}: icon is a Font Awesome name (e.g. faFlask).'],
            ['credentials_eyebrow', 'Credentials eyebrow', 'text', 'Credentials'],
            ['credentials_title', 'Credentials title', 'text', 'Verified, not just claimed'],
            ['credentials_body', 'Credentials body', 'textarea', 'WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House recognition and Pharmexcil membership: credentials that regulators and partners can verify.'],
        ],
        'manufacturing' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Manufacturing'],
            ['hero_title', 'Hero title', 'text', 'Inside a pharma manufacturing facility built for export'],
            ['hero_lead', 'Hero lead', 'textarea', 'Nymak Pharma consolidates its operations at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat, minutes from two of India\'s busiest export ports. Production, quality control, regulatory affairs, design and warehousing all run from this single WHO-GMP certified site.'],
            ['overview_title', 'Overview heading', 'text', 'Head Office & Works, Mundra'],
            ['overview_p1', 'Overview paragraph 1', 'textarea', 'Among drug manufacturing companies in India, location is strategy. Our head office and works sit within the Port Biz Industrial Park on the Kandla-Mundra highway in Gujarat, a location chosen deliberately for its direct access to the ports of Mundra and Kandla, the gateways through which over 200 containers of Nymak products shipped in FY 2023-24. From filling line to vessel, the supply line is measured in kilometres, not days. For a drug manufacturing company in India competing on landed cost and lead time, that geography is a structural advantage competitors inland cannot copy.'],
            ['overview_p2', 'Overview paragraph 2', 'textarea', 'The facility operates under WHO-GMP certification with ISO 13485:2016 quality management systems, the standard partners expect of a pharmaceutical manufacturing company in India supplying regulated markets. Production is supported by a structure that keeps the critical functions in-house: a quality control laboratory analysing every batch lot, a quality assurance team approving each release, a regulatory affairs team handling dossiers and registrations, a design team producing market-compliant packaging, and a logistics function managing warehousing and dispatch. Documented processes cover the full production cycle, from raw-material control and compounding through filling, labelling and final inspection, with batch records tracing every consignment back to its source.'],
            ['overview_p3', 'Overview paragraph 3', 'textarea', 'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. That audit-ready openness is what sets drug manufacturing companies in India that export reliably apart from those that only quote. As a medicine manufacturing company in India serving 24+ countries, it is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require.'],
            ['facility_image', 'Facility image', 'image', 'images/hero/facility-aerial.webp'],
            ['capabilities_eyebrow', 'Capabilities eyebrow', 'text', 'Capability'],
            ['capabilities_title', 'Capabilities title', 'text', 'What runs inside the facility'],
            ['capabilities_lead', 'Capabilities lead', 'textarea', 'Quality, regulatory, design and logistics under one roof, so partners deal with one accountable team from batch to bill of lading. Each function below exists because a medicine manufacturing company in India exporting to 24+ markets cannot afford to subcontract the things buyers audit.'],
            ['capabilities', 'Capability cards (JSON)', 'json', '[{"icon":"faFlask","title":"In-house QC laboratory","text":"A dedicated quality control laboratory analyses batch lots before release. Partners reviewing the facility consistently note well-controlled processes and modern storage."},{"icon":"faClipboardCheck","title":"Quality assurance oversight","text":"A separate QA function reviews and approves every batch before it leaves the facility, ensuring each consignment matches specification and documentation."},{"icon":"faFileCircleCheck","title":"Regulatory & dossier support","text":"An in-house regulatory team prepares and manages product dossiers, supporting registration requirements in destination markets across Africa, Central America and the Pacific."},{"icon":"faBox","title":"Design & packaging","text":"An in-house design team produces compliant, market-ready packaging and labelling, including the branded ranges supplied to West African markets."},{"icon":"faWarehouse","title":"Warehousing & logistics","text":"Committed warehouse infrastructure with controlled storage, managed by a dedicated logistics head. Over 200 containers shipped in FY 2023-24."},{"icon":"faMicroscope","title":"Continuous up-gradation","text":"The facility operates with a documented focus on upgrading existing facilities, verified through client inspections and audits."}]', 'Array of {icon, title, text}: icon is a Font Awesome name (e.g. faFlask).'],
            ['dosage_eyebrow', 'Dosage eyebrow', 'text', 'What we make'],
            ['dosage_title', 'Dosage title', 'text', 'Dosage forms & product lines'],
            ['dosage_forms', 'Dosage cards (JSON)', 'json', '[{"title":"IV fluids & infusions","text":"Large-volume parenterals: saline, dextrose, Ringer lactate, multi-electrolyte, therapeutic infusions (100 ml-1000 ml)."},{"title":"Tablets & capsules","text":"Including dispersible, sublingual, sustained-release and combination presentations."},{"title":"Oral liquids","text":"Syrups, suspensions and drops: paediatric and adult formulations."},{"title":"Injections","text":"Ampoules and vials: liquid and dry powder for reconstitution."},{"title":"Medical devices","text":"IV access, infusion sets, syringes, needles and patient-care consumables."},{"title":"Diagnostics","text":"Rapid diagnostic test kits for priority infections and point-of-care screening."}]', 'Array of {title, text}.'],
        ],
        'quality' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Quality & Certifications'],
            ['hero_title', 'Hero title', 'text', 'Certified quality, verifiable compliance'],
            ['hero_lead', 'Hero lead', 'textarea', 'Every accolade reflects our commitment to quality, integrity and the partners who rely on our products: WHO-GMP, ISO 13485:2016, Star Export House and more.'],
            ['cred_eyebrow', 'Credentials eyebrow', 'text', 'Credentials'],
            ['cred_title', 'Credentials title', 'text', 'Awards & certifications'],
            ['cred_lead', 'Credentials lead', 'textarea', 'Each accolade and certification reflects our deep-rooted commitment to quality, integrity and global healthcare excellence: the trust of our partners, the safety of our products, and the lives we strive to improve. Certificates are available to partners for verification during registration and audits.'],
            ['cert_iso_image', 'ISO certificate scan', 'image', 'images/certifications/iso-13485-certificate.webp'],
            ['cert_star_image', 'Star Export House scan', 'image', 'images/certifications/star-export-house-certificate.webp'],
            ['system_title', 'System heading', 'text', 'How quality works here'],
            ['system_p1', 'System paragraph 1', 'textarea', 'Quality at Nymak is not a department. It is the sequence every product passes through. Raw materials are controlled on entry, production follows documented GMP processes, batch lots are analysed by the in-house QC laboratory, and a separate QA function reviews each release before dispatch.'],
            ['system_p2', 'System paragraph 2', 'textarea', 'Around production sits the supporting structure: a regulatory team preparing dossiers for destination-market registration, a design team producing compliant labelling, and warehouse teams maintaining controlled storage through to shipment.'],
            ['system_p3', 'System paragraph 3', 'textarea', 'This is what partners verify when they audit us, and what the WHO-GMP, ISO 13485 and Star Export House credentials certify from the outside.'],
            ['reg_eyebrow', 'Regulatory eyebrow', 'text', 'Regulatory & Dossiers'],
            ['reg_title', 'Regulatory title', 'text', 'Pharmaceutical regulatory services India importers rely on'],
            ['reg_p1', 'Regulatory paragraph 1', 'textarea', 'Pharmaceutical regulatory services India exporters vary widely on: ours are in-house. Our regulatory affairs team handles pharmaceutical dossier preparation, compiles pharma regulatory documentation and supports drug registration in destination markets across Africa, the Middle East, Asia and the South Pacific.'],
            ['reg_p2', 'Regulatory paragraph 2', 'textarea', 'Every consignment travels with the paperwork your authority expects: product dossiers, certificates of analysis, WHO-GMP and ISO evidence, and market-compliant labelling produced by our design team. Pharmaceutical registration support India partners receive from us covers new registrations, renewals and variations, so a product that enters your market stays registered.'],
            ['faq_title', 'FAQ sidebar heading', 'text', 'Quality questions'],
        ],
        'contact' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Contact Us'],
            ['hero_title', 'Hero title', 'text', 'Let\'s talk about your market'],
            ['hero_lead', 'Hero lead', 'textarea', 'Whether you are a distributor, hospital, NGO or health programme, share your requirement with our pharmaceutical company in India: a pharma supplier India tenders rely on and a pharmaceutical exporter India works with across 24+ markets.'],
            ['form_title', 'Form heading', 'text', 'Send an enquiry to a pharmaceutical company in India'],
            ['form_lead', 'Form subheading', 'text', 'Fields marked * are required.'],
        ],
        'products.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Our Products'],
            ['hero_title', 'Hero title', 'text', 'A pharmaceutical export portfolio built for real-world need'],
            ['hero_lead', 'Hero lead', 'textarea', 'Four segments, 300+ line items, one quality standard. Every product ships under WHO-GMP conditions with registration support for your market.'],
            ['card_label', 'Category card link label', 'text', 'Explore category'],
            ['show_cta_card', 'Show contact card in the grid', 'toggle', '1'],
            ['cta_card_title', 'Contact card title', 'text', 'Need something specific?'],
            ['cta_card_body', 'Contact card body', 'textarea', 'Our regulatory team supports custom presentations, pack sizes and market-specific registrations. Tell us what your market needs.'],
            ['cta_card_button', 'Contact card button label', 'text', 'Contact us'],
            ['show_brands', 'Show branded products grid', 'toggle', '1', 'Toggle to hide the branded range on the live page.'],
            ['brands_eyebrow', 'Brands eyebrow', 'text', 'Branded Portfolio'],
            ['brands_title', 'Brands title', 'text', 'Registered Nymak brands in market'],
            ['brands_lead', 'Brands lead', 'textarea', 'Products marketed under Nymak brand names in West African markets: Alumak, Cefmak, Cipromak and more.'],
            ['body_eyebrow', 'Body section eyebrow', 'text', 'The Portfolio'],
            ['body_title', 'Body section title', 'text', 'Four segments from pharmaceutical suppliers in India'],
            ['body_intro', 'Body section lead', 'textarea', 'Every product in this catalogue ships from our WHO-GMP facility in Mundra, Gujarat, with the registration support, batch documentation and consolidated logistics that pharmaceutical suppliers in India are judged by.'],
            ['body_p1', 'Body paragraph 1', 'textarea', 'Nymak Pharma is a pharmaceutical product supplier in India whose catalogue is built around how our buyers actually procure. Hospital groups, importers, NGOs and public health programmes rarely want single-line orders: they want IV fluids beside the devices that deliver them, formulations beside the diagnostics that guide them, and one dossier set behind it all. Our four-segment portfolio answers exactly that, with more than 300 line items held to one manufacturing standard and one documentation trail. For a pharmaceutical medicine supplier working across 24+ export markets, breadth and consistency are what buyers audit first: the range has to cover the formulary, and every line has to carry the same evidence file.'],
            ['body_p2', 'Body paragraph 2', 'textarea', 'The IV fluids range covers large-volume parenterals and therapeutic infusions from 100 ml to 1000 ml: the fluid, electrolyte and nutrient staples of ward and theatre care, plus antibacterial, antifungal, antiamoebic and analgesic infusions. Finished formulations span tablets, capsules, syrups, suspensions, drops and injections across antimalarial, antibacterial, antiretroviral, analgesic, cardiovascular and supplement therapy groups, including dispersible, sublingual and sustained-release presentations. Many of these products carry Nymak brand registrations in destination markets, so a distributor can market an established name rather than build one from scratch. Across segments the pattern repeats: molecules chosen for the burden of disease our markets actually report, presentations matched to procurement norms, and pack formats built for tropical distribution.'],
            ['body_p3', 'Body paragraph 3', 'textarea', 'The medical devices and disposables segment carries IV access, injection consumables, catheters and surgical disposables under our ISO 13485:2016 quality system, while the rapid diagnostic kits range covers the tests programme buyers reach for most: malaria, HIV, hepatitis B and C, syphilis, typhoid, dengue, pregnancy and more. As a pharma products supplier India tenders source from repeatedly, we hold each segment to the same WHO-GMP conditions and the same registration support, so a mixed consignment never means mixed standards. Registration follows the same consolidated model: our in-house regulatory affairs team holds dossiers market by market, tracking renewals and variations so a listed product stays listed.'],
            ['body_p4', 'Body paragraph 4', 'textarea', 'Every segment page lists the full product table with strengths and pack sizes, and our exports team confirms availability, registration status and lead time for your market on request. For buyers weighing pharmaceutical suppliers in India, the practical offer is simple: one supplier, one quality system, one consignment. Because regulatory affairs, artwork and logistics sit in-house, we can also support custom presentations and market-specific pack sizes where volumes justify them. Tell us your product list and destination market and we will map it to the range.'],
            ['body_p5', 'Body paragraph 5', 'textarea', 'Documentation is part of the product. Our in-house regulatory affairs team prepares and maintains product dossiers for destination-market registration, our design team produces compliant labelling and artwork in the languages your market requires, and our quality team supplies batch certificates of analysis with every consignment. For many pharmaceutical products buyers, that paperwork is what turns a quotation into an approved supplier listing, and it is handled by the same company that fills the containers.'],
            ['body_p6', 'Body paragraph 6', 'textarea', 'As a medicines supplier working from a single WHO-GMP facility minutes from Mundra and Kandla ports, we consolidate mixed orders efficiently: IV fluids, formulations, devices and diagnostics can ship together on one bill of lading, with one point of accountability from purchase order to delivery. That is how pharma products India programmes procure at scale, and it is the supply model our partners across 24+ countries have built their plans on for over two decades. New markets follow the same path: registration scoping first, commercial terms second, then a consignment plan that fits the buyer\'s warehousing and distribution reality.'],
            ['body_p7', 'Body paragraph 7', 'textarea', 'The brands programme deserves a note of its own. In West African markets our registered Nymak names, including Alumak, Cefmak, Cipromak, Amoximak, Clavmak and Zincomak, give distributors a marketed identity from day one: registered trademarks, established packaging, and product literature the local teams already know. For a medicines supplier entering a new territory, that brand equity shortens the distance between registration and first sales.'],
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
            ['title', 'Hero title', 'text', '{category}: full product list', 'Use {category} / {count} placeholders.'],
            ['lead', 'Hero lead', 'textarea', 'Every product we supply in this category, with strengths and pack sizes. Names with a link open a product page.'],
            ['branded_title', 'Branded range heading', 'text', 'Nymak branded range'],
            ['search_label', 'Search label', 'text', 'Search this list ({count} products)'],
            ['search_placeholder', 'Search placeholder', 'text', 'e.g. ceftriaxone, infusion, tablets…'],
            ['empty_title', 'No-results title', 'text', 'No products match “{query}”.'],
            ['empty_body', 'No-results body', 'text', 'Try a generic name or therapeutic class, or ask us directly.'],
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
            ['hero_title', 'Hero title', 'text', 'A pharmaceutical exporter India sends to 24+ countries, and counting'],
            ['hero_lead', 'Hero lead', 'textarea', 'Operating in over 24 countries like Somalia, Kenya, D R Congo, Nigeria and Sierra Leone, we bring more than healthcare products. We bring dedication. As a pharmaceutical export company in India working across West, Central, East and Southern Africa, the Middle East, Asia and the South Pacific, our commitment is clear at every step: to improve lives by delivering quality and efficacious products and leaving a positive footprint wherever we go.'],
            ['map_eyebrow', 'Map eyebrow', 'text', 'Where We Work'],
            ['map_title', 'Map title', 'text', 'One supply line from India to the world'],
            ['map_lead', 'Map lead', 'textarea', 'Each pin marks a market we supply today: gold for our own offices, blue for ethical markets, green for partner markets. Click a pin, or pick from the list, to see the work, the products and the people on the ground.'],
            ['map_empty_title', 'Map panel placeholder title', 'text', 'Pick a pin, explore a market'],
            ['map_empty_body', 'Map panel placeholder body', 'textarea', 'The pins mark where we export today. Select one to read what we do there and which products we supply.'],
            ['map_empty_cta', 'Map panel placeholder CTA label', 'text', 'Your market not listed? Ask us'],
            ['map_market_empty_title', 'Map panel: empty-country title', 'text', 'We serve {country} through export partners'],
            ['map_market_empty_body', 'Map panel: empty-country body', 'textarea', 'Our {country} portfolio grows with demand. If you are a distributor, hospital group or programme buyer there, ask us what we currently supply and which dossiers we can support.'],
            ['map_market_cta', 'Map panel: empty-country CTA label', 'text', 'Talk to our export team'],
            ['presence_eyebrow', 'Presence section eyebrow', 'text', 'How We Reach Markets'],
            ['presence_title', 'Presence section title', 'text', 'Three kinds of market, one supply line'],
            ['presence_p1', 'Presence paragraph 1', 'textarea', 'As a pharmaceutical export company in India, Nymak Pharma reaches 24+ countries through three distinct channels, and the pin colours on the map above mark the difference. Gold pins are our own presence: the head office and works at Mundra, the corporate office in Ahmedabad, and group companies in Freetown (Sierra Leone), Monrovia (Liberia) and London (United Kingdom), where our teams handle distribution, tenders and pharmacovigilance on the ground. These are the markets where a partner can meet us face to face: our people carry the products, the paperwork and the responsibility in the same place the buyers are.'],
            ['presence_p2', 'Presence paragraph 2', 'textarea', 'Blue pins are ethical markets: Cameroon, Tchad and Burkina Faso, where prescription-led promotion and registered products serve doctors, pharmacies and hospitals directly. Green pins are partner markets: Nigeria, Senegal, Mauritania, Angola, DR Congo, Kenya, Somalia, Burundi, Malawi, South Africa, Iraq, Azerbaijan, the Philippines, and our founding region across the South Pacific: Papua New Guinea, Solomon Islands, Vanuatu, Tonga, Fiji and Western Samoa, where appointed distributors carry our registered ranges under local partnerships. In partner markets our role runs deeper than dispatching cartons: we prepare the registration dossiers, produce the market-compliant artwork, and stand behind every batch with the certificates authorities ask for, while our partners run the commercial territory they know best.'],
            ['presence_p3', 'Presence paragraph 3', 'textarea', 'The model matters less than the standard behind it. Whichever colour a market wears, the products ship from the same WHO-GMP facility in Gujarat, supported by the same in-house regulatory team preparing dossiers for destination-market registration, the same QC laboratory releasing each batch, and the same design team producing compliant packaging and labelling in the market\'s language. It is how pharma exporters from India keep a 24-country map consistent: the supply line does not change with the pin colour. From WHO-GMP production in Mundra to the port paperwork handled by our Ahmedabad office, one sequence governs every market: register, release, label, ship, document.'],
            ['presence_p4', 'Presence paragraph 4', 'textarea', 'For buyers weighing an Indian pharmaceutical exporter against regional alternatives, this is the practical difference: presence markets get an accountable local office, ethical markets get a promotion-compliant field presence, and partner markets get a supplier whose regulatory file arrives complete. If your country is not yet on the board, the conversation starts the same way: tell us your product list and your market, and our exports team will map the route. Because dossier work sits in-house, new-market scoping is part of the normal enquiry: we tell you what registration your authority expects before we quote, not after the first order stalls.'],
            ['presence_p5', 'Presence paragraph 5', 'textarea', 'The map keeps growing. New registrations are in progress across additional African and Asian markets, and partners evaluating pharmaceutical suppliers India offers for long-term programmes are welcome to ask about upcoming territory plans. Wherever a pin lands next, it joins a network that has been compounding since a single consignment left for the South Pacific in 1998. Each year the board gains pins; the standard behind them does not move.'],
            ['presence_p6', 'Presence paragraph 6', 'textarea', 'Choosing between channels is rarely the buyer\'s problem to solve alone. A ministry running a national tender needs a supplier whose file survives scrutiny; a private distributor needs margin and marketing support; an NGO needs delivery dates that hold. Our exports team works through that calculus market by market, which is why the same catalogue reaches a London trading desk, a Freetown pharmacy wholesaler and a Pacific Island health programme under three different arrangements with one shared standard of evidence. That is the kind of pharmaceutical exporter India built its reputation on: present where it matters, documented everywhere.'],
            ['footprint_eyebrow', 'Footprint eyebrow', 'text', 'Export Footprint'],
            ['footprint_title', 'Footprint title', 'text', 'Every container tells a story'],
            ['footprint_body', 'Footprint body', 'textarea', 'More than 200 containers shipped in FY 2023-24 to 24+ countries across four regions, and the number keeps growing. Each container is documented end to end: dossier registration, batch certificates, compliant labelling and port logistics handled by the same in-house teams. Few pharma export India operations run this volume through a single audited site, and fewer still can show the paperwork line by line.'],
            ['footprint_stats', 'Footprint stats (JSON)', 'json', '[{"value":"24+","label":"Countries served"},{"value":"200+","label":"Containers in FY 2023-24"},{"value":"4","label":"Regions"},{"value":"5","label":"Group companies & offices"}]', 'Array of {value, label}.'],
            ['offices_eyebrow', 'Offices eyebrow', 'text', 'On the Ground'],
            ['offices_title', 'Offices title', 'text', 'Group Companies'],
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
        // Ahmedabad / Gujarat landing page - the corporate office and the
        // Gujarat pharma ecosystem around it (requirements keyword map).
        'ahmedabad' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Ahmedabad · Gujarat'],
            ['hero_title', 'Hero title', 'text', 'A pharma manufacturing company in Ahmedabad, Gujarat'],
            ['hero_lead', 'Hero lead', 'textarea', 'Nymak Pharma\'s corporate office in Ahmedabad runs regulatory, design and export operations beside our WHO-GMP works at Mundra, serving 24+ countries from Gujarat, India.'],
            ['overview_title', 'Overview heading', 'text', 'Corporate office, Ahmedabad'],
            ['overview_p1', 'Overview paragraph 1', 'textarea', 'Among pharmaceutical companies in Ahmedabad, Nymak Pharma runs its corporate office at Money Plant High Street, SG Highway: the commercial hub where our exports, regulatory affairs, design and accounts teams coordinate every consignment leaving our works at Mundra, around 90 kilometres to the south-west on the Kutch coast. It is the address partners write to, the team that answers, and the point where export orders become registered, documented shipments. Choosing Ahmedabad for the corporate office was deliberate: it places Nymak among the pharmaceutical companies in Gujarat closest to the state\'s export infrastructure, industry bodies and commercial talent, while the works stay minutes from the quayside.'],
            ['overview_p2', 'Overview paragraph 2', 'textarea', 'The office handles the work buyers feel but rarely see: product registration dossiers for destination markets, market-compliant packaging and labelling designed in-house, tender documentation for programme buyers, and the export documentation that moves a consignment from our warehouse to the ports of Mundra and Kandla. When a distributor asks what separates a pharma manufacturer in Ahmedabad from a trading desk, the answer is this team: specialists who own the file from first enquiry to final bill of lading. The office also anchors the parts of the business buyers visit for: audit scheduling, artwork approvals, sample dispatches and the contract reviews that turn a quotation into a standing supply agreement. That is the working shape of a pharma manufacturing company in Ahmedabad: commercial minds beside a WHO-GMP works.'],
            ['why_title', 'Why Gujarat heading', 'text', 'Why Gujarat, why it matters to buyers'],
            ['why_p1', 'Why paragraph 1', 'textarea', 'Gujarat is one of the pharma industry India\'s deepest manufacturing belts, and our position in it is deliberate. The works at Mundra sit minutes from two of India\'s busiest export ports, while the Ahmedabad office places our commercial team inside the state\'s business capital: near Pharmexcil and export bodies, courier and banking hubs, and the talent pool pharma companies in Gujarat draw on. Pharmaceutical companies in Gujarat supply a large share of the formulations the world buys; being inside that ecosystem means suppliers, packagers, freight partners and regulators are all within reach. Raw material sourcing, packaging components and specialist services sit inside the same state, so lead times compress and problems get solved with a phone call rather than a supply chain enquiry.'],
            ['why_p2', 'Why paragraph 2', 'textarea', 'For partners comparing pharma companies Ahmedabad hosts, the practical result is response time: a regulatory question, a dossier request or a packaging revision reaches the people who own it in hours, not through a chain of intermediaries. Decisions happen where management sits, and management sits here. For a pharma company Ahmedabad buyers shortlist, that proximity shows up in the details: faster dossier turnaround, same-day answers on stock, and packaging revisions that close in days rather than weeks.'],
            ['works_title', 'Works connection heading', 'text', 'One company, two addresses'],
            ['works_p1', 'Works paragraph 1', 'textarea', 'Head Office & Works sits at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), Gujarat, housing production, the QC laboratory, QA release and warehousing. The Ahmedabad corporate office runs the commercial functions around it. Together they make Nymak a pharmaceutical company Gujarat can offer the world: audited works at the port, accountable management in the city. Visiting partners typically see both: the manufacturing floor in the morning, the regulatory and design teams in the afternoon. The two addresses share one reporting line, so what a partner is promised in the Ahmedabad boardroom is what the Mundra works dispatches.'],
            ['works_p2', 'Works paragraph 2', 'textarea', 'Group companies extend that structure overseas: offices in London, Freetown and Monrovia support distribution, tenders and pharmacovigilance in the UK and West Africa. From Ahmedabad, the chain runs city to port to market without a hand-off to third parties.'],
            ['office_title', 'Office details heading', 'text', 'Reach the Ahmedabad office'],
            ['cta_title', 'CTA title', 'text', 'Working with pharmaceutical companies in Gujarat?'],
            ['cta_body', 'CTA body', 'textarea', 'Tell us your product list and destination market. The Ahmedabad team responds with availability, registration status and lead times. Whether you are evaluating pharmaceutical manufacturers Gujarat offers for a national tender or a private-label programme, the enquiry lands on the desk that can answer it.'],
        ],
        'team.index' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'Our Team'],
            ['hero_title', 'Hero title', 'text', 'The people behind the promise'],
            ['hero_lead', 'Hero lead', 'textarea', 'Behind every product and every promise we make stands a team united by expertise and empathy. We combine clinical precision with heartfelt commitment to deliver quality healthcare solutions that truly make a difference.'],
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
            ['explorer_eyebrow', 'Market explorer eyebrow', 'text', 'Global Footprint'],
            ['explorer_title', 'Market explorer title', 'text', 'Tap a market. See what we built there.'],
            ['explorer_lead', 'Market explorer lead', 'textarea', 'Each country below is a real operating relationship. Select one to see the products we supply there today.'],
            ['cta_title', 'Closing CTA title', 'text', 'Ready to write the next chapter with us?'],
            ['cta_body', 'Closing CTA body', 'textarea', 'Distributors, ministries and hospital groups: tell us what your market needs and we will scope a supply plan.'],
        ],
        'faqs' => [
            ['hero_eyebrow', 'Hero eyebrow', 'text', 'FAQs'],
            ['hero_title', 'Hero title', 'text', 'Frequently asked questions'],
            ['hero_lead', 'Hero lead', 'textarea', 'Direct answers about who we are, what we manufacture, where we export and how to work with us.'],
            ['cta_title', 'CTA title', 'text', 'Still have a question?'],
            ['cta_body', 'CTA body', 'textarea', 'Our exports and regulatory teams respond to every enquiry: products, pricing, registration, packaging and logistics.'],
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
        'ahmedabad' => 'Ahmedabad / Gujarat',
        'posts.index' => 'Blog / Resources',
        'team.index' => 'Team',
        'inside' => 'Inside Nymak (interactive)',
        'faqs' => 'FAQs',
    ];

    /**
     * Resolved slot map for a page: DB overrides merged over defaults.
     * `value` is translatable, so on non-English requests the trait resolves
     * localized text/textarea/richtext slots automatically (EN fallback).
     */
    public static function for(string $page, ?string $locale = null): array
    {
        $rows = static::where('page', $page)->get(['key', 'value', 'i18n'])->keyBy('key');

        return collect(static::SCHEMA[$page] ?? [])->mapWithKeys(function ($f) use ($rows) {
            [$key, , $type, $default] = $f;
            $value = $rows->get($key)?->value;
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
