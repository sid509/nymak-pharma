<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Page body copy and headings now carry the keyword map's focus
     * keyword (plus long-tail/secondary coverage), matching what the
     * meta title/description already do. Slots are materialised via
     * firstOrCreate, so rows holding previous seeded defaults would
     * keep serving copy without the keywords. Refresh exactly those
     * rows: any value an admin actually edited stays untouched.
     */
    public function up(): void
    {
        $swaps = [
            'home' => [
                'about_title' => [
                    'A pharmaceutical company India has exported through since 1998',
                    'Pharma manufacturers in India exporting since 1998',
                ],
                'about_p3' => [
                    'A Government of India certified Star Export House shipping 200+ containers in FY 2023-24, where one team answers for the product, the paperwork, the packaging and the port.',
                    'Among Indian pharmaceutical manufacturers, Nymak is a Government of India certified Star Export House shipping 200+ containers in FY 2023-24, where one team answers for the product, the paperwork, the packaging and the port.',
                ],
                'portfolio_lead' => [
                    'A pharmaceutical export portfolio for hospitals, distributors, NGOs and public health programmes, organised into four segments: IV fluids, finished formulations, medical devices and rapid diagnostic kits.',
                    'A pharmaceutical export portfolio for hospitals, distributors, NGOs and public health programmes, organised by pharmaceutical suppliers in India into four segments: IV fluids, finished formulations, medical devices and rapid diagnostic kits.',
                ],
            ],
            'about' => [
                'hero_title' => [
                    'A pharmaceutical company in India since 1998',
                    'Among pharmaceutical companies in India since 1998',
                ],
                'overview_p3' => [
                    'Today, with over 25 years of lifecare excellence, Nymak Pharma is a pharmaceutical company based in Gujarat maintaining a presence in more than 24 countries. We exported over 200 containers in FY 2023-24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team preparing product dossiers, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams, all devoted to the highest standards of care and excellence in the pharma industry India is known for.',
                    'Today, with over 25 years of lifecare excellence, Nymak Pharma is a pharmaceutical company based in Gujarat maintaining a presence in more than 24 countries. We exported over 200 containers in FY 2023-24. As a Government of India certified Star Export House, our infrastructure includes an in-house regulatory team preparing product dossiers, a quality control laboratory, a committed warehouse and passionate QC/QA and design teams, all devoted to the highest standards of care and excellence in the pharma industry India is known for. It is the operating standard a leading pharmaceutical company in India is judged by.',
                ],
                'story_p1' => [
                    'Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani, entrepreneur and our founder, set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.',
                    'Among pharma companies in India, Nymak Pharma began at a single desk in 1998. Mr. Ranjit Advani, entrepreneur and our founder, set out with a simple conviction: dependable medicines should reach the communities that need them most, wherever they are.',
                ],
            ],
            'manufacturing' => [
                'overview_p3' => [
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. As a medicine manufacturing company in India serving 24+ countries, that audit-ready openness is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require.',
                    'Client inspections tell the story better than we can: partners visiting the plant describe modern machinery and storage, processes well controlled to GMP requirement, and a quality-conscious, supportive management. That audit-ready openness is what sets drug manufacturing companies in India that export reliably apart from those that only quote. As a medicine manufacturing company in India serving 24+ countries, it is the standard we hold every shift to. Audits are part of the working rhythm here: inspectors and partner QA teams walk the lines, review the records and leave with the documentation their own authorities require.',
                ],
            ],
            'quality' => [
                'reg_title' => [
                    'Pharmaceutical regulatory services for your market',
                    'Pharmaceutical regulatory services India importers rely on',
                ],
            ],
            'products.index' => [
                'body_title' => [
                    'Four segments, one accountable supplier',
                    'Four segments from pharmaceutical suppliers in India',
                ],
            ],
            'ahmedabad' => [
                'overview_p2' => [
                    'The office handles the work buyers feel but rarely see: product registration dossiers for destination markets, market-compliant packaging and labelling designed in-house, tender documentation for programme buyers, and the export documentation that moves a consignment from our warehouse to the ports of Mundra and Kandla. When a distributor asks what separates a pharma manufacturer in Ahmedabad from a trading desk, the answer is this team: specialists who own the file from first enquiry to final bill of lading. The office also anchors the parts of the business buyers visit for: audit scheduling, artwork approvals, sample dispatches and the contract reviews that turn a quotation into a standing supply agreement.',
                    'The office handles the work buyers feel but rarely see: product registration dossiers for destination markets, market-compliant packaging and labelling designed in-house, tender documentation for programme buyers, and the export documentation that moves a consignment from our warehouse to the ports of Mundra and Kandla. When a distributor asks what separates a pharma manufacturer in Ahmedabad from a trading desk, the answer is this team: specialists who own the file from first enquiry to final bill of lading. The office also anchors the parts of the business buyers visit for: audit scheduling, artwork approvals, sample dispatches and the contract reviews that turn a quotation into a standing supply agreement. That is the working shape of a pharma manufacturing company in Ahmedabad: commercial minds beside a WHO-GMP works.',
                ],
            ],
            'contact' => [
                'hero_lead' => [
                    'Whether you\'re a distributor, hospital, NGO or health programme, tell us your requirement and our exports team will respond.',
                    'Whether you are a distributor, hospital, NGO or health programme, share your requirement with our pharmaceutical company in India: a pharma supplier India tenders rely on and a pharmaceutical exporter India works with across 24+ markets.',
                ],
                'form_title' => [
                    'Send an enquiry',
                    'Send an enquiry to a pharmaceutical company in India',
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
