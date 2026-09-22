<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Posts/Index', [
            'posts' => Post::query()
                ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                    ->where('title', 'like', "%{$s}%")->orWhere('category', 'like', "%{$s}%")))
                ->when($request->status === 'published', fn ($q) => $q->published())
                ->when($request->status === 'draft', fn ($q) => $q->whereNull('published_at'))
                ->latest('published_at')->latest('created_at')
                ->paginate(20)
                ->withQueryString(),
            'filters' => $request->only('q', 'status'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Form');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        Post::create($request->validated());

        return redirect()->route('admin.posts.index')->with('success', 'Article created.');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Posts/Form', [
            'post' => $post->only('id', 'title', 'slug', 'category', 'excerpt', 'body',
                'meta_title', 'meta_description', 'published_at'),
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return redirect()->route('admin.posts.index')->with('success', 'Article updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted.');
    }
}
