<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Faq;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class QualityController extends Controller
{
    public function __invoke(): Response
    {
        $qualityFaqs = Faq::where('category', 'Quality')->orderBy('sort_order')->get();

        $seo = Seo::make(
            'Quality & Certifications — WHO-GMP, ISO 13485',
            'Nymak Pharma\'s quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, Pharmexcil RCMC — with in-house QC/QA oversight.'
        )->override('quality')->breadcrumbs([
            ['Home', url('/')],
            ['Quality & Certifications', url('/quality-certifications')],
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
            'content' => \App\Models\PageContent::for('quality'),
            'seo' => $seo->toArray(),
            'certifications' => Certification::orderBy('sort_order')->get(),
            'faqs' => $qualityFaqs,
        ]);
    }
}
