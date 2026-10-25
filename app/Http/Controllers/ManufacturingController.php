<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\PageContent;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class ManufacturingController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Manufacturing', [
            'seo' => Seo::make(
                'Pharmaceutical Manufacturing Facility in Mundra, Gujarat',
                'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat, with in-house QC lab, QA systems, regulatory and warehouse teams.'
            )->override('manufacturing')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Manufacturing', SetLocale::absolute('/manufacturing')],
            ])->toArray(),
            'content' => PageContent::for('manufacturing'),
        ]);
    }
}
