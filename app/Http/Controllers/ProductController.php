<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'seo' => Seo::make(
                'Pharmaceutical Products — IV Fluids, Formulations & More',
                'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, rapid diagnostic kits and vaccines.'
            )->override('products.index')->breadcrumbs([
                ['Home', url('/')],
                ['Products', url('/products')],
            ])->toArray(),
            'content' => \App\Models\PageContent::for('products.index'),
            'categories' => ProductCategory::orderBy('sort_order')
                ->withCount('products')
                ->with(['featuredProducts' => fn ($q) => $q->whereNotNull('image')->limit(4)
                    ->select('id', 'product_category_id', 'name', 'slug', 'image')])
                ->get(),
            'branded' => Product::where('has_detail_page', true)
                ->whereNotNull('image')
                ->with('category:id,name,slug')
                ->orderBy('sort_order')
                ->limit(12)
                ->get(['id', 'name', 'slug', 'image', 'product_category_id']),
        ]);
    }

    public function category(ProductCategory $category): Response
    {
        $category->load(['products' => fn ($q) => $q
            ->select('id', 'product_category_id', 'name', 'slug', 'therapeutic_group', 'strength', 'pack_size', 'specimen', 'image', 'has_detail_page')]);

        $products = $category->products->groupBy('therapeutic_group');

        return Inertia::render('Products/Category', [
            'seo' => Seo::make(
                $category->meta_title ?? $category->name,
                $category->meta_description ?? $category->intro ?? ''
            )->image($category->products->firstWhere('image')?->image
                ? url($category->products->firstWhere('image')->image) : null)
            ->breadcrumbs([
                ['Home', url('/')],
                ['Products', url('/products')],
                [$category->name, url("/products/{$category->slug}")],
            ])->toArray(),
            'category' => $category->only('name', 'slug', 'intro', 'description'),
            'groups' => $products->map(fn ($items, $group) => [
                'name' => $group ?: 'Products',
                'products' => $items->map(fn ($p) => [
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'strength' => $p->strength,
                    'pack_size' => $p->pack_size,
                    'specimen' => $p->specimen,
                    'image' => $p->image,
                    'url' => $p->has_detail_page
                        ? url("/products/{$category->slug}/{$p->slug}") : null,
                ])->values(),
            ])->values(),
            'siblings' => ProductCategory::orderBy('sort_order')->get(['name', 'slug', 'icon']),
        ]);
    }

    public function show(ProductCategory $category, Product $product): Response
    {
        abort_unless($product->has_detail_page, 404);

        $product->load('market:id,name,slug');

        $related = Product::where('has_detail_page', true)
            ->where('id', '!=', $product->id)
            ->where(fn ($q) => $q->where('market_id', $product->market_id)
                ->orWhere('therapeutic_group', $product->therapeutic_group))
            ->whereNotNull('image')
            ->inRandomOrder()
            ->limit(4)
            ->get(['id', 'name', 'slug', 'image', 'product_category_id'])
            ->map(fn ($p) => [
                'name' => $p->name,
                'image' => $p->image,
                'url' => url("/products/{$category->slug}/{$p->slug}"),
            ]);

        return Inertia::render('Products/Show', [
            'seo' => Seo::make(
                $product->meta_title ?? $product->name,
                $product->meta_description ?? $product->description ?? ''
            )->type('product')->image($product->image ? url($product->image) : null)
            ->schema([
                '@type' => 'Product',
                'name' => $product->name,
                'image' => $product->image ? url($product->image) : null,
                'description' => $product->description,
                'brand' => ['@type' => 'Brand', 'name' => config('nymak.short_name')],
                'manufacturer' => ['@id' => url('/#organization')],
                'category' => $category->name,
            ])->breadcrumbs([
                ['Home', url('/')],
                ['Products', url('/products')],
                [$category->name, url("/products/{$category->slug}")],
                [$product->name, url("/products/{$category->slug}/{$product->slug}")],
            ])->toArray(),
            'product' => [
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'image' => $product->image,
                'market' => $product->market?->only('name', 'slug'),
                'strength' => $product->strength,
                'pack_size' => $product->pack_size,
            ],
            'category' => $category->only('name', 'slug'),
            'related' => $related,
        ]);
    }
}
