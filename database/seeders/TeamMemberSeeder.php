<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        // Bios mirror nymakpharma.com/team — the canonical content source.
        $team = [
            ['Mr. Ranjit Advani', 'Founder & Mentor', true,
                'With over 50 years of invaluable experience in the pharmaceutical industry, Ranjit Advani serves as the visionary leader and mentor at Nymak Pharma. His extensive expertise and adept administration have been instrumental in shaping the company\'s growth and success.'],
            ['Mr. Haresh Advani', 'Director', true,
                'Haresh Advani brings over 20 years of expertise in exports and marketing to Nymak Pharma. His strategic insights and deep understanding of international markets have played a pivotal role in expanding our global footprint and driving export growth.'],
            ['Mr. Dimendra Patel', 'Technical Head', true,
                'Dimendra Patel leverages 15 years of experience in regulatory affairs and quality assurance within the pharmaceutical sector. His meticulous approach ensures that all products by Nymak Pharma adhere to stringent regulatory standards, guaranteeing safety, efficacy, and compliance.'],
            ['Mr. Murtaza Naqvi', 'Business Development Manager', true,
                'Murtaza Naqvi is an experienced Business Development Manager with a rich background in marketing and business expansion, particularly in the African market. With over a decade of living and working in Africa, he has developed a profound understanding of the region\'s business landscape, consumer behavior, and market dynamics.'],
            ['Mr. Jobe John', 'International Business Development — FWA', false,
                'Jobe John is an experienced Business Development Manager with a rich background in marketing and business expansion, particularly in French-speaking West African markets. With over a decade of living and working in Africa, Jobe has developed a profound understanding of the region\'s business landscape, consumer behavior, and market dynamics.'],
            ['Mr. Narendra Hirani', 'Logistics & Warehouse Head', false,
                'Narendra Hirani is a seasoned hand in logistics and warehousing with two decades of experience in logistics and related fields. His extensive career has equipped him with comprehensive knowledge and expertise in managing logistics operations, warehouse management, and supply chain optimization.'],
            ['Mr. Vishal Lalwani', 'Planning & Material Control Head', false,
                'Vishal Lalwani is an accomplished Planning and Material Control Head with a decade of experience in Central America and India. His expertise lies in strategic planning, material control, and supply chain management, making him a valuable asset in optimizing inventory and resource management processes.'],
            ['Mr. Shivaksh Somani', 'Accounts Head', false,
                'With a keen eye for detail and a strong command over financial strategy, Shivaksh Somani leads our accounting operations with precision and integrity. His expertise ensures smooth financial management, compliance, and transparency across the board, playing a pivotal role in driving fiscal efficiency and supporting the company\'s growth.'],
            ['Mr. Dolat Pokar', 'Accounts Compliance Head', false,
                'Dolat Pokar is a seasoned finance and accounts compliance head with 15 years of extensive experience in financial management, accounting, and regulatory compliance. His expertise ensures the financial integrity and compliance adherence of the organization.'],
            ['Mr. Mehul J. Vaghela', 'Sr. Graphic Designer', false,
                'Mehul Vaghela leverages 8 years of experience in artwork and product designing within the pharmaceutical sector. His expertise lies in product packaging development and creating promotional inputs for brand support.'],
            ['Mr. Chintan Patel', 'Head of Quality Control', false,
                'Chintan Patel brings a relentless commitment to excellence in his role as Head of Quality Control. With a sharp focus on detail and adherence to industry standards, he ensures that every product meets our strict quality benchmarks. His proactive approach and deep technical knowledge are key to maintaining consistency, reliability, and customer trust.'],
        ];

        foreach ($team as $i => [$name, $role, $leadership, $bio]) {
            TeamMember::updateOrCreate(['name' => $name], [
                'slug' => Str::slug(Str::remove(['Mr.', 'Ms.', 'Dr.'], $name)),
                'role' => $role,
                'is_leadership' => $leadership,
                'bio' => $bio,
                'sort_order' => $i,
            ]);
        }
    }
}
