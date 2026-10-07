<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;

use App\Models\PageContent;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\Seo;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $content = PageContent::for('products.index');

        return Inertia::render('Products/Index', [
            'seo' => Seo::make(
                'Pharmaceutical Products — IV Fluids, Formulations & More',
                'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, rapid diagnostic kits and vaccines.'
            )->override('products.index')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Products', SetLocale::absolute('/products')],
            ])->toArray(),
            'content' => $content,
            'categories' => ProductCategory::orderBy('sort_order')
                ->withCount('products')
                ->get(['id', 'name', 'slug', 'icon', 'intro', 'image', 'i18n']),
            'branded' => $content['show_brands'] ? Product::where('has_detail_page', true)
                ->whereNotNull('image')
                ->with('category:id,name,slug,i18n')
                ->orderBy('sort_order')
                ->limit(12)
                ->get(['id', 'name', 'slug', 'image', 'product_category_id', 'i18n']) : [],
        ]);
    }

    /**
     * Category landing page — indexable content about the range plus a
     * summary of what it covers. The full table lives on catalogue().
     */
    public function category(ProductCategory $category): Response
    {
        $category->loadCount('products')->load(['products' => fn ($q) => $q
            ->select('id', 'product_category_id', 'name', 'slug', 'therapeutic_group', 'image', 'has_detail_page', 'i18n')]);

        $groups = $category->products->groupBy('therapeutic_group')
            ->map(fn ($items, $group) => ['name' => $group ?: 'Products', 'count' => $items->count()])
            ->values();

        return Inertia::render('Products/Category', [
            'seo' => Seo::make(
                $category->meta_title ?? $category->name,
                $category->meta_description ?? $category->intro ?? ''
            )->image($this->categoryImage($category))
            ->schema([
                '@type' => 'CollectionPage',
                'name' => $category->name,
                'url' => SetLocale::absolute("/product/{$category->slug}"),
                'description' => $category->meta_description ?? $category->intro,
                'isPartOf' => ['@id' => url('/#website')],
                'hasPart' => ['@type' => 'ItemList', 'url' => SetLocale::absolute("/product/{$category->slug}/products"), 'numberOfItems' => $category->products_count],
            ])->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Products', SetLocale::absolute('/products')],
                [$category->name, SetLocale::absolute("/product/{$category->slug}")],
            ])->toArray(),
            'category' => $category->only('name', 'slug', 'intro', 'description', 'content', 'image') + [
                'products_count' => $category->products_count,
                'catalogue_url' => "/product/{$category->slug}/products",
            ],
            'groups' => $groups,
            'siblings' => $this->siblings(),
            'content' => PageContent::for('products.category'),
        ]);
    }

    /** Full product list for a category — grouped spec tables with search. */
    public function catalogue(ProductCategory $category): Response
    {
        $category->load(['products' => fn ($q) => $q
            ->select('id', 'product_category_id', 'name', 'slug', 'therapeutic_group', 'strength', 'pack_size', 'specimen', 'image', 'has_detail_page', 'i18n')]);

        $products = $category->products->groupBy('therapeutic_group');

        return Inertia::render('Products/Catalogue', [
            'seo' => Seo::make(
                "{$category->name} Product List — Strengths & Pack Sizes",
                "Complete list of {$category->name} manufactured and exported by Nymak Pharma — {$category->products->count()} products with strengths and pack sizes."
            )->image($this->categoryImage($category))
            ->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Products', SetLocale::absolute('/products')],
                [$category->name, SetLocale::absolute("/product/{$category->slug}")],
                ['Product list', SetLocale::absolute("/product/{$category->slug}/products")],
            ])->toArray(),
            'category' => $category->only('name', 'slug', 'intro') + [
                'url' => "/product/{$category->slug}",
                'products_count' => $category->products->count(),
            ],
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
                        ? "/product/{$category->slug}/{$p->slug}" : null,
                ])->values(),
            ])->values(),
            'siblings' => $this->siblings(),
            'content' => PageContent::for('products.catalogue'),
        ]);
    }

    public function show(ProductCategory $category, Product $product): Response
    {
        abort_unless($product->has_detail_page, 404);

        $product->load('market:id,name,slug');
        $content = PageContent::for('products.show');

        $related = ! $content['show_related'] ? [] : Product::where('has_detail_page', true)
            ->where('id', '!=', $product->id)
            ->where(fn ($q) => $q->where('market_id', $product->market_id)
                ->orWhere('therapeutic_group', $product->therapeutic_group))
            ->whereNotNull('image')
            ->with('category:id,slug')
            ->inRandomOrder()
            ->limit(4)
            ->get(['id', 'name', 'slug', 'image', 'product_category_id', 'i18n'])
            ->map(fn ($p) => [
                'name' => $p->name,
                'image' => $p->image,
                'url' => "/product/{$p->category->slug}/{$p->slug}",
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
                ['Home', SetLocale::absolute('/')],
                ['Products', SetLocale::absolute('/products')],
                [$category->name, SetLocale::absolute("/product/{$category->slug}")],
                [$product->name, SetLocale::absolute("/product/{$category->slug}/{$product->slug}")],
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
            'category' => $category->only('name', 'slug') + ['url' => "/product/{$category->slug}"],
            'related' => $related,
            'content' => $content,
        ]);
    }

    private function siblings(): Collection
    {
        return ProductCategory::orderBy('sort_order')->get(['name', 'slug', 'icon', 'i18n']);
    }

    private function categoryImage(ProductCategory $category): ?string
    {
        if ($category->image) {
            return url($category->image);
        }
        $first = $category->products->firstWhere('image');

        return $first ? url($first->image) : null;
    }
}
