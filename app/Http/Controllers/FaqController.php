<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Faq;
use App\Models\PageContent;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function __invoke(): Response
    {
        $faqs = Faq::orderBy('sort_order')->get()->groupBy('category');

        $seo = Seo::make(
            'Pharmaceutical Export FAQs: India Exporter',
            'Answers on products, IV fluids, WHO-GMP certifications, export markets & partnership enquiries from Nymak Pharma, a pharmaceutical exporter in India today.'
        )->override('faqs')->schema([
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->flatten()->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f->question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
            ]),
        ])->breadcrumbs([
            ['Home', SetLocale::absolute('/')],
            ['FAQs', SetLocale::absolute('/faqs')],
        ]);

        return Inertia::render('Faqs', [
            'seo' => $seo->toArray(),
            'content' => PageContent::for('faqs'),
            'groups' => $faqs->map(fn ($items, $category) => [
                'category' => $category,
                'faqs' => $items->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->values(),
            ])->values(),
        ]);
    }
}
