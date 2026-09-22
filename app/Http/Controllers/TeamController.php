<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\TeamMember;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function index(): Response
    {
        $members = TeamMember::orderBy('sort_order')->get()
            ->map(fn ($m) => [
                'name' => $m->name,
                'slug' => $m->slug,
                'role' => $m->role,
                'photo' => $m->photo,
                'initials' => $m->initials(),
                'is_leadership' => $m->is_leadership,
                'has_page' => filled($m->bio),
                'excerpt' => $m->bio ? \Illuminate\Support\Str::limit($m->bio, 140) : null,
            ]);

        return Inertia::render('Team/Index', [
            'seo' => Seo::make(
                'Our Team — Leadership & Experts | Nymak Pharma',
                'Meet the leadership and specialists behind Nymak Pharma — exports, regulatory affairs, quality control, logistics and design.'
            )->override('team.index')->breadcrumbs([
                ['Home', url('/')],
                ['Team', url('/team')],
            ])->toArray(),
            'leadership' => $members->where('is_leadership', true)->values(),
            'members' => $members->where('is_leadership', false)->values(),
            'content' => PageContent::for('team.index'),
        ]);
    }

    public function show(TeamMember $member): Response
    {
        // Detail page exists only for members with a bio — thin profiles
        // would just duplicate the team index.
        abort_unless(filled($member->bio), 404);

        return Inertia::render('Team/Show', [
            'seo' => Seo::make(
                $member->meta_title ?? "{$member->name} — {$member->role} | Nymak Pharma",
                $member->meta_description ?? \Illuminate\Support\Str::limit($member->bio, 155)
            )->schema([
                '@type' => 'Person',
                'name' => $member->name,
                'jobTitle' => $member->role,
                'image' => $member->photo ? url($member->photo) : null,
                'worksFor' => ['@id' => url('/#organization')],
            ])->breadcrumbs([
                ['Home', url('/')],
                ['Team', url('/team')],
                [$member->name, url("/team/{$member->slug}")],
            ])->toArray(),
            'member' => [
                'name' => $member->name,
                'role' => $member->role,
                'photo' => $member->photo,
                'initials' => $member->initials(),
                'bio' => $member->bio,
            ],
            'others' => TeamMember::whereKeyNot($member->id)->whereNotNull('bio')
                ->orderBy('sort_order')->take(4)
                ->get(['name', 'slug', 'role', 'photo'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug,
                    'role' => $m->role, 'photo' => $m->photo,
                    'initials' => $m->initials(),
                ]),
            'content' => PageContent::for('team.index'),
        ]);
    }
}
