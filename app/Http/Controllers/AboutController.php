<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\PageContent;
use App\Models\TeamMember;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('About', [
            'seo' => Seo::make(
                'About Us — WHO-GMP Pharmaceutical Manufacturer Since 1998',
                'Founded in 1998, Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Star Export House serving 24+ countries from Mundra, Gujarat, India.'
            )->override('about')->breadcrumbs([
                ['Home', url('/')],
                ['About Us', url('/about')],
            ])->toArray(),
            'leadership' => TeamMember::where('is_leadership', true)->orderBy('sort_order')
                ->get(['name', 'slug', 'role', 'photo', 'bio'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug, 'role' => $m->role,
                    'photo' => $m->photo, 'has_page' => filled($m->bio),
                ]),
            'team' => TeamMember::where('is_leadership', false)->orderBy('sort_order')
                ->get(['name', 'slug', 'role', 'photo', 'bio'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug, 'role' => $m->role,
                    'photo' => $m->photo, 'has_page' => filled($m->bio),
                ]),
            'certifications' => Certification::orderBy('sort_order')->get(['name', 'issuer', 'image']),
            'content' => PageContent::for('about'),
        ]);
    }
}
