<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Market;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with('category:id,name,slug', 'market:id,name')
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")
                ->orWhere('strength', 'like', "%{$s}%")
                ->orWhere('therapeutic_group', 'like', "%{$s}%")))
            ->when($request->category, fn ($q, $c) => $q->whereHas('category', fn ($w) => $w->where('slug', $c)))
            ->orderBy('product_category_id')->orderBy('sort_order')
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => ProductCategory::orderBy('sort_order')->get(['id', 'name', 'slug']),
            'filters' => $request->only('q', 'category'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Form', $this->formProps());
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'i18n']);
        if ($file = $request->file('image')) {
            $data['image'] = ImageUpload::store($file, 'products', $data['slug']);
        }

        $record = Product::create($data);
        foreach (['fr', 'es'] as $locale) {
            $record->setTranslations($locale, (array) $request->input("i18n.{$locale}", []));
        }
        $record->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Form', $this->formProps() + [
            'product' => $product->only('id', 'name', 'slug', 'product_category_id', 'market_id',
                'therapeutic_group', 'strength', 'pack_size', 'specimen', 'description',
                'image', 'meta_title', 'meta_description', 'has_detail_page', 'sort_order', 'i18n'),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'i18n']);
        if ($file = $request->file('image')) {
            ImageUpload::delete($product->image);
            $data['image'] = ImageUpload::store($file, 'products', $data['slug']);
        }

        $product->update($data);

        $record = $product;
        foreach (['fr', 'es'] as $locale) {
            $record->setTranslations($locale, (array) $request->input("i18n.{$locale}", []));
        }
        $record->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_if($product->enquiries()->exists(), 422, 'Cannot delete: enquiries reference this product.');

        ImageUpload::delete($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function formProps(): array
    {
        return [
            'categories' => ProductCategory::orderBy('sort_order')->get(['id', 'name']),
            'markets' => Market::orderBy('sort_order')->get(['id', 'name']),
        ];
    }
}
