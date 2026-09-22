<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'seo' => Seo::make(
                'Insights & Resources — Nymak Pharma',
                'Company news, quality explainers and product insights from Nymak Pharma — a WHO-GMP certified pharmaceutical manufacturer and exporter.'
            )->breadcrumbs([
                ['Home', url('/')],
                ['Blog & Resources', url('/blog')],
            ])->toArray(),
            'posts' => Post::published()->latest('published_at')
                ->paginate(9, ['title', 'slug', 'category', 'excerpt', 'cover_image', 'published_at']),
        ]);
    }

    public function show(Post $post): Response
    {
        abort_unless($post->published_at && $post->published_at->isPast(), 404);

        return Inertia::render('Blog/Show', [
            'seo' => Seo::make(
                $post->meta_title ?? $post->title,
                $post->meta_description ?? $post->excerpt ?? ''
            )->type('article')->image($post->cover_image)
            ->schema([
                '@type' => 'Article',
                'headline' => $post->title,
                'description' => $post->excerpt,
                'datePublished' => $post->published_at->toIso8601String(),
                'dateModified' => $post->updated_at->toIso8601String(),
                'author' => ['@id' => url('/#organization')],
                'publisher' => ['@id' => url('/#organization')],
                'mainEntityOfPage' => url("/blog/{$post->slug}"),
            ])->breadcrumbs([
                ['Home', url('/')],
                ['Blog', url('/blog')],
                [$post->title, url("/blog/{$post->slug}")],
            ])->toArray(),
            'post' => $post->only('title', 'category', 'excerpt', 'body', 'cover_image', 'published_at'),
            'related' => Post::published()->where('id', '!=', $post->id)
                ->latest('published_at')->limit(3)
                ->get(['title', 'slug', 'category', 'excerpt', 'published_at']),
        ]);
    }
}
