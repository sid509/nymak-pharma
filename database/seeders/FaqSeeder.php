<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['General', 'Who is Nymak Pharma?',
                'Nymak Pharma Private Limited is a WHO-GMP certified pharmaceutical manufacturer and exporter founded in 1998 by Mr. Ranjit Advani. Headquartered in Mundra (Kutch), Gujarat, India, the company began with Sterilized Water for Injections BP and today supplies IV fluids, finished formulations, medical devices, rapid diagnostic kits and antisera to more than 24 countries.'],
            ['General', 'Is Nymak Pharma a pharmaceutical exporter?',
                'Yes. Nymak Pharma is a Government of India recognised Star Export House. In FY 2023–24 the company exported over 200 containers of pharmaceuticals and medical supplies, serving markets across West, Central and East Africa, Central America and the South Pacific.'],
            ['General', 'Where is Nymak Pharma located?',
                'The head office and manufacturing facility are located at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), Gujarat, India — close to the ports of Mundra and Kandla. A branch office operates in Ahmedabad, and international offices/partners operate in the United Kingdom, Sierra Leone and Liberia.'],
            ['Products', 'What products does Nymak Pharma manufacture?',
                'Nymak Pharma\'s portfolio spans five segments: IV fluids and intravenous infusions; finished formulations (tablets, capsules, syrups, suspensions and injections across antimalarial, antibiotic, antiretroviral and chronic therapies); medical devices and surgical disposables; rapid diagnostic test kits; and vaccines & antisera including snake venom antiserum and tetanus antitoxin.'],
            ['Products', 'What IV fluids does Nymak Pharma offer?',
                'The IV fluids range covers fluid and electrolyte replenishers (sodium chloride 0.9% and 0.45%, Ringer lactate), dextrose infusions (5%, 10%, 25% and combination), multiple electrolyte formulations, mannitol, peritoneal dialysis fluid, and therapeutic infusions including ciprofloxacin, metronidazole, fluconazole, paracetamol and linezolid — in pack sizes from 100 ml to 1000 ml.'],
            ['Products', 'Which rapid diagnostic kits does Nymak supply?',
                'The diagnostic portfolio includes rapid tests for malaria (Pf/Pv and Pf/Pan), HIV 1 & 2 and 4th-generation HIV Ag/Ab, HBsAg, HCV, syphilis, typhoid, dengue, chikungunya, leptospira, H. pylori, toxoplasma, troponin I, scrub typhus, leishmania, pregnancy and ovulation, plus urinalysis strips.'],
            ['Products', 'Can products be supplied under our own brand or in customised packaging?',
                'Nymak Pharma supplies both its registered brands (such as the Alumak, Cefmak and Cipromak ranges marketed in West Africa) and market-specific presentations. Branding, labelling and pack configurations are finalised per destination country\'s registration and regulatory requirements — contact the exports team to discuss your market\'s needs.'],
            ['Quality', 'What certifications does Nymak Pharma hold?',
                'Nymak Pharma\'s facility and quality systems hold WHO-GMP certification and ISO 13485:2016 certification. The company is a Government of India certified Star Export House, a member of the Pharmaceuticals Export Promotion Council of India (Pharmexcil), and holds a valid Importer-Exporter Code (IEC) and GST registration.'],
            ['Quality', 'How does Nymak assure product quality?',
                'Quality is managed by an in-house QC/QA structure: batches are analysed by the quality control laboratory and released only after quality assurance review. The company also maintains an in-house regulatory team for dossier and registration support, and an in-house design team for compliant packaging and labelling.'],
            ['Exports', 'Which countries does Nymak Pharma serve?',
                'Nymak Pharma operates in more than 24 countries. Named markets include Nigeria, Sierra Leone, Liberia, Ghana, Somalia, Kenya, DR Congo, Cameroon, Mauritania, Honduras and island markets across the South Pacific, supported by offices in the UK, Sierra Leone and Liberia.'],
            ['Exports', 'How can I become a distributor for Nymak Pharma products?',
                'Distributors, importers, NGOs and public health procurement teams can reach the exports team through the contact page, by email at info@nymakpharma.com, or via the regional offices in Sierra Leone and Liberia. The regulatory team supports product registration and dossier requirements in the destination market.'],
            ['Exports', 'Does Nymak Pharma supply to tenders and public health programmes?',
                'Yes. The portfolio — particularly IV fluids, antimalarials, antiretrovirals, rapid diagnostic kits and medical disposables — is supplied to hospitals, distributors and public health programmes across its export markets. Enquiries for institutional and tender supply are welcome through the contact page.'],
        ];

        foreach ($faqs as $i => [$category, $question, $answer]) {
            Faq::create([
                'category' => $category,
                'question' => $question,
                'answer' => $answer,
                'sort_order' => $i,
            ]);
        }
    }
}
