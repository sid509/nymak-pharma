<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $team = [
            ['Mr. Ranjit Advani', 'Founder & Mentor', true],
            ['Mr. Haresh Advani', 'Director', true],
            ['Mr. Dimendra Patel', 'Technical Head', true],
            ['Mr. Murtaza Naqvi', 'Business Development Manager', true],
            ['Mr. Jobe John', 'International Business Development — FWA', false],
            ['Mr. Narendra Hirani', 'Logistics & Warehouse Head', false],
            ['Mr. Vishal Lalwani', 'Planning & Material Control Head', false],
            ['Mr. Shivaksh Somani', 'Accounts Head', false],
            ['Mr. Dolat Pokar', 'Financial Compliance Head', false],
            ['Mr. Mehul Vaghela', 'Sr. Graphic Designer', false],
            ['Mr. Chintan Patel', 'Head of Quality Control', false],
        ];

        foreach ($team as $i => [$name, $role, $leadership]) {
            TeamMember::create([
                'name' => $name,
                'role' => $role,
                'is_leadership' => $leadership,
                'sort_order' => $i,
            ]);
        }
    }
}
