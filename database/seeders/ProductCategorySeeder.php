<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'IV Fluids',
                'slug' => 'iv-fluids',
                'icon' => 'droplets',
                'intro' => 'Sterile intravenous (IV) solutions formulated for swift rehydration and vital electrolyte restoration, trusted for consistent performance across a range of clinical applications.',
                'description' => 'Nymak Pharma manufactures a comprehensive range of large-volume parenteral (LVP) IV fluids including dextrose, sodium chloride, ringer lactate, mannitol and multiple electrolyte formulations, alongside antibacterial, antifungal and analgesic intravenous infusions.',
                'meta_title' => 'IV Fluids Manufacturer & Exporter in India',
                'meta_description' => 'WHO-GMP certified IV fluids manufacturer in India supplying intravenous infusions — dextrose, saline, RL, mannitol & antibiotic infusions — to 24+ countries.',
                'content' => '<p>Nymak Pharma began with injectable sterile water and grew into a large-volume parenteral (LVP) programme: dextrose, sodium chloride, Ringer lactate, mannitol and multiple electrolyte formulations, alongside antibacterial, antifungal and analgesic intravenous infusions in 100 ml to 1000 ml presentations.</p><p>Every infusion is produced at our WHO-GMP certified facility in Mundra, Gujarat, where an in-house quality control laboratory analyses each batch before release and a separate QA function approves dispatch. The range is built for hospitals, distributors, NGOs and public health programmes that need dependable sterile supply.</p><p>Presentations cover the staples of fluid therapy as well as therapeutic infusions, and our regulatory team supports product registration dossiers in destination markets. The complete list — strengths and pack sizes — is on the product list page linked below.</p>',
                'sort_order' => 1,
            ],
            [
                'name' => 'Finished Formulations',
                'slug' => 'finished-formulations',
                'icon' => 'pill',
                'intro' => 'Finished dosage forms designed to meet diverse healthcare needs — each formulation rigorously tested for quality, efficacy and stability.',
                'description' => 'From antimalarials and antibiotics to antiretrovirals, supplements and cardiovascular care, Nymak Pharma\'s finished formulations span tablets, capsules, syrups, suspensions and injections manufactured under WHO-GMP conditions.',
                'meta_title' => 'Finished Formulations Manufacturer India',
                'meta_description' => 'Pharmaceutical finished formulations manufacturer & exporter: tablets, capsules, syrups, injectables across antimalarial, antibiotic, ARV & chronic therapies.',
                'content' => '<p>The finished formulations range is the broadest part of the Nymak portfolio — tablets, capsules, syrups, suspensions, drops and injections organised by therapeutic group: antimalarials, antibacterials, antiretrovirals, analgesics, cardiovascular care, supplements and more.</p><p>Presentations include dispersible, sublingual, sustained-release and combination dosage forms, developed for the realities of our export markets — field conditions, programme procurement and patient adherence. In West African markets, part of the range is supplied under registered Nymak brand names including Alumak, Cefmak and Cipromak.</p><p>All formulations are manufactured under WHO-GMP conditions with QC analysis and QA release on every batch, and our in-house regulatory team prepares registration dossiers for destination markets. Browse the full list grouped by therapeutic area below.</p>',
                'sort_order' => 2,
            ],
            [
                'name' => 'Medical Devices & Disposables',
                'slug' => 'medical-devices-and-disposables',
                'icon' => 'syringe',
                'intro' => 'Precision medical devices and disposables engineered for safe, accurate drug delivery — elevating everyday patient care.',
                'description' => 'Nymak Pharma supplies IV cannulas, syringes, needles, infusion sets, catheters and surgical disposables including gauze, cotton wool, bandages and examination gloves to hospitals and health programmes worldwide.',
                'meta_title' => 'Medical Devices & Disposables Supplier India',
                'meta_description' => 'Exporter of medical devices & surgical disposables from India: IV cannulas, syringes, infusion sets, catheters, gauze & gloves for hospitals & tenders.',
                'content' => '<p>Beyond medicines, Nymak supplies the devices and consumables that deliver them — IV cannulas, syringes, needles, infusion sets and catheters, plus surgical disposables such as gauze, cotton wool, bandages and examination gloves.</p><p>The device programme runs under our ISO 13485:2016 certified quality management system, and our in-house design team produces compliant, market-ready packaging and labelling for each destination market.</p><p>Hospitals, distributors and public health tenders source these lines alongside our pharmaceutical range — a single supplier relationship covering infusion therapy end to end. The complete list is linked below.</p>',
                'sort_order' => 3,
            ],
            [
                'name' => 'Rapid Diagnostic Kits',
                'slug' => 'rapid-diagnostic-kits',
                'icon' => 'scan-search',
                'intro' => 'Rapid diagnostic solutions that prioritise speed and sensitivity, empowering healthcare professionals with timely, reliable results.',
                'description' => 'A focused portfolio of rapid test kits covering malaria, HIV 1 & 2, hepatitis B & C, syphilis, typhoid, dengue, pregnancy and H. pylori — built for field conditions and public health programmes.',
                'meta_title' => 'Rapid Diagnostic Test Kits Manufacturer India',
                'meta_description' => 'Rapid diagnostic kits exporter from India: malaria, HIV, HBsAg, HCV, syphilis, typhoid & pregnancy test kits for labs, NGOs & health ministries.',
                'content' => '<p>Our rapid diagnostic portfolio covers the tests public health programmes reach for most: malaria, HIV 1 &amp; 2, hepatitis B (HBsAg) and C (HCV), syphilis, typhoid, dengue, pregnancy and H. pylori.</p><p>These kits are selected for the conditions they will actually face — field clinics, district laboratories and screening campaigns where speed and sensitivity decide outcomes. Each product lists its intended specimen so programme teams can plan supply correctly.</p><p>Laboratories, NGOs and health ministries across our 24+ export markets source diagnostics from Nymak alongside our medicines and devices. The full list, with specimen types, is linked below.</p>',
                'sort_order' => 4,
            ],
            [
                'name' => 'Vaccines & Antisera',
                'slug' => 'vaccines',
                'icon' => 'shield-plus',
                'intro' => 'Immunization and antiserum solutions formulated for stability and safety, supporting public health missions worldwide.',
                'description' => 'Nymak Pharma supplies snake venom antiserum and tetanus antitoxin in liquid and lyophilised presentations, supporting immunisation and emergency care programmes across its export markets.',
                'meta_title' => 'Vaccines & Antisera Exporter India',
                'meta_description' => 'Pharmaceutical vaccines & antisera supplier: snake venom antiserum and tetanus antitoxin exported from India to Africa, Asia & Central America.',
                'content' => '<p>Nymak supplies immunization and emergency-care biologicals — snake venom antiserum and tetanus antitoxin — in liquid and lyophilised presentations for stability through tropical supply chains.</p><p>These products support immunisation programmes and emergency medicine across our export markets, where antiserum availability can be the difference between a treatable emergency and a fatal one.</p><p>Cold-chain and documentation requirements are managed by our export logistics team as part of the consignment. The current product list is linked below.</p>',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            // Keyed on slug so re-seeding backfills new fields (e.g. landing
            // content) without duplicating categories.
            ProductCategory::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
