<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Certification;
use App\Models\JourneyItem;
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
                'Pharmaceutical Companies in India: Our Story Since 1998',
                'Founded in 1998, Nymak Pharma is a pharmaceutical company based in Gujarat, India: a WHO-GMP certified Star Export House serving 24+ countries.'
            )->override('about')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['About Us', SetLocale::absolute('/about')],
            ])->toArray(),
            'leadership' => TeamMember::where('is_leadership', true)->orderBy('sort_order')
                ->get(['name', 'slug', 'role', 'photo', 'bio', 'i18n'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug, 'role' => $m->role,
                    'photo' => $m->photo, 'has_page' => filled($m->bio),
                ]),
            'team' => TeamMember::where('is_leadership', false)->orderBy('sort_order')
                ->get(['name', 'slug', 'role', 'photo', 'bio', 'i18n'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug, 'role' => $m->role,
                    'photo' => $m->photo, 'has_page' => filled($m->bio),
                ]),
            'certifications' => Certification::orderBy('sort_order')->get(['name', 'issuer', 'image']),
            'journey' => JourneyItem::orderBy('sort_order')->orderBy('id')
                ->get(['year', 'title', 'body', 'icon', 'image', 'image_2', 'fit', 'i18n'])
                ->map(fn ($j) => [
                    'year' => $j->year, 'title' => $j->title, 'body' => $j->body,
                    'icon' => $j->icon, 'image' => $j->image, 'image_2' => $j->image_2,
                    'fit' => $j->fit,
                ]),
            'content' => PageContent::for('about'),
        ]);
    }
}
