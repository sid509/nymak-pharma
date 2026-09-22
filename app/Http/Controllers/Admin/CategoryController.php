<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => ProductCategory::orderBy('sort_order')
                ->withCount('products')
                ->get(['id', 'name', 'slug', 'icon', 'intro', 'sort_order']),
        ]);
    }

    public function edit(ProductCategory $category): Response
    {
        return Inertia::render('Admin/Categories/Form', [
            'category' => $category->only('id', 'name', 'slug', 'icon', 'intro',
                'description', 'meta_title', 'meta_description', 'sort_order'),
        ]);
    }

    public function update(CategoryRequest $request, ProductCategory $category): RedirectResponse
    {
        // Slug is intentionally not editable — category URLs are structural
        // and linked throughout the site and sitemap.
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }
}
