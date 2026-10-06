<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Market;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $productsWithPages = Product::where('has_detail_page', true)->count();
        $productsNoImage = Product::where('has_detail_page', true)->whereNull('image')->count();
        $enquiries30 = Enquiry::where('created_at', '>=', now()->subDays(30))->count();
        $enquiriesPrev30 = Enquiry::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();

        // Fill a continuous 30-day series so the trend chart has no gaps.
        $byDay = Enquiry::selectRaw('date(created_at) as day, count(*) as n')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')->pluck('n', 'day');
        $enquiryTrend = collect(range(29, 0))->map(fn ($i) => [
            'day' => now()->subDays($i)->format('d M'),
            'n' => (int) ($byDay[now()->subDays($i)->toDateString()] ?? 0),
        ]);

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'enquiries_unread' => Enquiry::unread()->count(),
                'enquiries_total' => Enquiry::count(),
                'enquiries_30d' => $enquiries30,
                'enquiries_30d_delta' => $enquiriesPrev30 > 0
                    ? (int) round(($enquiries30 - $enquiriesPrev30) / $enquiriesPrev30 * 100)
                    : null,
                'products' => Product::count(),
                'products_with_pages' => $productsWithPages,
                'products_no_image' => $productsNoImage,
                'categories' => ProductCategory::count(),
                'markets' => Market::count(),
                'posts_published' => Post::published()->count(),
                'posts_draft' => Post::whereNull('published_at')->count(),
                'team' => \App\Models\TeamMember::count(),
            ],
            'enquiryTrend' => $enquiryTrend,
            'enquiriesByCountry' => Enquiry::whereNotNull('country')->where('country', '!=', '')
                ->selectRaw('country, count(*) as n')->groupBy('country')
                ->orderByDesc('n')->limit(8)->get(['country', 'n']),
            'productsByCategory' => ProductCategory::withCount('products')
                ->orderByDesc('products_count')->get(['id', 'name', 'slug']),
            'productsByMarket' => Market::withCount('products')->has('products')
                ->orderByDesc('products_count')->get(['id', 'name', 'slug', 'iso_code']),
            'enquiriesByProduct' => Enquiry::whereNotNull('product_id')
                ->selectRaw('product_id, count(*) as n')->groupBy('product_id')
                ->orderByDesc('n')->limit(5)->with('product:id,name')->get()
                ->map(fn ($e) => ['name' => $e->product?->name ?? 'Deleted product', 'n' => $e->n]),
            'recentEnquiries' => Enquiry::latest()->limit(6)
                ->get(['id', 'name', 'company', 'country', 'subject', 'created_at', 'read_at'])
                ->map(fn ($e) => $e->setAttribute('when', $e->created_at->format('j M, H:i'))),
        ]);
    }
}
