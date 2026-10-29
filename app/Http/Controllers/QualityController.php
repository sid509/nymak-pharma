<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Certification;
use App\Models\Faq;
use App\Models\PageContent;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class QualityController extends Controller
{
    public function __invoke(): Response
    {
        $qualityFaqs = Faq::where('category', 'Quality')->orderBy('sort_order')->get();

        $seo = Seo::make(
            'Pharmaceutical Regulatory Services India',
            'Pharmaceutical regulatory services India exporters rely on: WHO-GMP & ISO 13485 certified, dossier preparation & registration support per destination market.'
        )->override('quality')->breadcrumbs([
            ['Home', SetLocale::absolute('/')],
            ['Quality & Certifications', SetLocale::absolute('/quality-certifications')],
        ]);

        if ($qualityFaqs->isNotEmpty()) {
            $seo->schema([
                '@type' => 'FAQPage',
                'mainEntity' => $qualityFaqs->map(fn ($f) => [
                    '@type' => 'Question',
                    'name' => $f->question,
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
                ]),
            ]);
        }

        return Inertia::render('Quality', [
            'content' => PageContent::for('quality'),
            'seo' => $seo->toArray(),
            'certifications' => Certification::orderBy('sort_order')->get(),
            'faqs' => $qualityFaqs,
        ]);
    }
}
