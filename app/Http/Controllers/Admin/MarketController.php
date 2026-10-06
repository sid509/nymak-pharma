<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarketRequest;
use App\Models\Market;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Markets/Index', [
            'markets' => Market::query()
                ->withCount('products')
                ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
                ->orderBy('sort_order')
                ->paginate(25)
                ->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Markets/Form');
    }

    public function store(MarketRequest $request): RedirectResponse
    {
        Market::create($request->validated());

        return redirect()->route('admin.markets.index')->with('success', 'Market created.');
    }

    public function edit(Market $market): Response
    {
        return Inertia::render('Admin/Markets/Form', [
            'market' => $market->only('id', 'name', 'slug', 'iso_code', 'region',
                'description', 'content', 'latitude', 'longitude', 'show_in_portfolio', 'sort_order'),
        ]);
    }

    public function update(MarketRequest $request, Market $market): RedirectResponse
    {
        $market->update($request->validated());

        return redirect()->route('admin.markets.index')->with('success', 'Market updated.');
    }

    public function destroy(Market $market): RedirectResponse
    {
        abort_if($market->products()->exists(), 422, 'Cannot delete: products reference this market.');

        $market->delete();

        return redirect()->route('admin.markets.index')->with('success', 'Market deleted.');
    }
}
