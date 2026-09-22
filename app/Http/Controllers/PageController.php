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
            'seo' => Seo::make('Privacy Policy', 'How Nymak Pharma collects, uses and protects personal data submitted through this website.')->override('privacy')
                ->toArray(),
            'heading' => 'Privacy Policy',
            'kind' => 'privacy',
        ]);
    }

    public function terms(): Response
    {
        return Inertia::render('Legal', [
            'seo' => Seo::make('Terms of Use', 'Terms governing the use of the Nymak Pharma website and its content.')->override('terms')
                ->toArray(),
            'heading' => 'Terms of Use',
            'kind' => 'terms',
        ]);
    }
}
