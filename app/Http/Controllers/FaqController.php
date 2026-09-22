<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function __invoke(): Response
    {
        $faqs = Faq::orderBy('sort_order')->get()->groupBy('category');

        $seo = Seo::make(
            'Frequently Asked Questions — Nymak Pharma',
            'Answers about Nymak Pharma\'s products, IV fluids, certifications, export markets, quality systems and how to partner with us.'
        )->schema([
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->flatten()->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f->question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
            ]),
        ])->breadcrumbs([
            ['Home', url('/')],
            ['FAQs', url('/faqs')],
        ]);

        return Inertia::render('Faqs', [
            'seo' => $seo->toArray(),
            'groups' => $faqs->map(fn ($items, $category) => [
                'category' => $category,
                'faqs' => $items->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->values(),
            ])->values(),
        ]);
    }
}
