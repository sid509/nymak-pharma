<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class ManufacturingController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Manufacturing', [
            'seo' => Seo::make(
                'Pharmaceutical Manufacturing Facility — Mundra, Gujarat',
                'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat — in-house QC lab, QA systems, regulatory and warehouse teams.'
            )->override('manufacturing')->breadcrumbs([
                ['Home', url('/')],
                ['Manufacturing', url('/manufacturing')],
            ])->toArray(),
        ]);
    }
}
