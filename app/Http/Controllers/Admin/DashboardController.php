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
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'enquiries_unread' => Enquiry::unread()->count(),
                'enquiries_total' => Enquiry::count(),
                'products' => Product::count(),
                'products_with_pages' => Product::where('has_detail_page', true)->count(),
                'products_no_image' => Product::where('has_detail_page', true)->whereNull('image')->count(),
                'categories' => ProductCategory::count(),
                'markets' => Market::count(),
                'posts_published' => Post::published()->count(),
                'posts_draft' => Post::whereNull('published_at')->count(),
            ],
            'recentEnquiries' => Enquiry::latest()->limit(6)
                ->get(['id', 'name', 'company', 'country', 'subject', 'created_at', 'read_at']),
            'enquiriesByDay' => Enquiry::selectRaw('date(created_at) as day, count(*) as n')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('day')->orderBy('day')->pluck('n', 'day'),
        ]);
    }
}
