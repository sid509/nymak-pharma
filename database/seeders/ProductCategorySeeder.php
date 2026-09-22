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
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
