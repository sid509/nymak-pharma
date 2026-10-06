<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\ProductCategory;
use App\Support\ImageUpload;
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
                'description', 'content', 'image', 'meta_title', 'meta_description', 'sort_order', 'i18n'),
        ]);
    }

    public function update(CategoryRequest $request, ProductCategory $category): RedirectResponse
    {
        // Slug is intentionally not editable — category URLs are structural
        // and linked throughout the site and sitemap.
        $data = $request->safe()->except(['image', 'i18n']);
        if ($file = $request->file('image')) {
            ImageUpload::delete($category->image);
            $data['image'] = ImageUpload::store($file, 'categories', $category->slug);
        }

        $category->update($data);

        $record = $category;
        foreach (['fr', 'es'] as $locale) {
            $record->setTranslations($locale, (array) $request->input("i18n.{$locale}", []));
        }
        $record->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }
}
