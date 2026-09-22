<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['Mr. Bija Joel', 'D R Congo',
                'Good plant, having modern machinery and storage. Processes are well controlled as per GMP requirement. Batch lots are analyzed by QC and fully assured by QA.'],
            ['Mr. Alexis Kenne', 'Cameroon',
                'Good and neatly maintained manufacturing plant. Supportive management, diversified fields, wishing all the best in future endeavor.'],
            ['Dr. Hassan Ould Keboud', 'Mauritania',
                'Manufacturing facility is good. Focused on innovation and up-gradation of existing facilities, quality conscious.'],
        ];

        foreach ($testimonials as $i => [$name, $country, $quote]) {
            Testimonial::create(compact('name', 'country', 'quote') + ['sort_order' => $i]);
        }
    }
}
