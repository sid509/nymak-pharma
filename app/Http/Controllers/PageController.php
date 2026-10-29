<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function privacy(): Response
    {
        return Inertia::render('Legal', [
            'seo' => Seo::make('Privacy Policy, Data Use & Your Rights', 'How Nymak Pharma collects, uses and protects the personal data submitted through this website, and how to reach our data team with privacy questions today.')->override('privacy')
                ->toArray(),
            'heading' => 'Privacy Policy',
            'kind' => 'privacy',
        ]);
    }

    public function terms(): Response
    {
        return Inertia::render('Legal', [
            'seo' => Seo::make('Terms of Use & Conditions of This Site', 'Terms governing the use of the Nymak Pharma website, its content, and the information provided about our products, services and export terms of use here.')->override('terms')
                ->toArray(),
            'heading' => 'Terms of Use',
            'kind' => 'terms',
        ]);
    }
}
