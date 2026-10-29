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
                'Drug Manufacturing Companies in India: Mundra',
                'Among drug manufacturing companies in India, our Mundra WHO-GMP facility runs in-house QC, QA release, regulatory & warehouse teams. See the facility.'
            )->override('manufacturing')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Manufacturing', SetLocale::absolute('/manufacturing')],
            ])->toArray(),
            'content' => PageContent::for('manufacturing'),
        ]);
    }
}
