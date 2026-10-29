<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Ahmedabad / Gujarat landing page - the corporate office and the Gujarat
 * pharma ecosystem around it. One of the keyword-mapped SEO pages in the
 * requirements doc (focus: "pharma manufacturing company in ahmedabad").
 */
class AhmedabadController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Ahmedabad', [
            'seo' => Seo::make(
                'Pharma Manufacturing Company in Ahmedabad',
                'A pharma manufacturing company in Ahmedabad, Gujarat: corporate office for regulatory, design & exports beside the WHO-GMP works at Mundra, Gujarat, India.'
            )->override('ahmedabad')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Ahmedabad, Gujarat', SetLocale::absolute('/ahmedabad')],
            ])->toArray(),
            'offices' => collect(SiteSetting::get('offices', []))
                ->where('country_code', 'IN')->values(),
            'content' => PageContent::for('ahmedabad'),
        ]);
    }
}
