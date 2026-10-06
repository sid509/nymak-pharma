<?php

use App\Http\Controllers;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public site — localised: English unprefixed (canonical), /fr/…, /es/…
// The same routes register twice. The {locale?} group registers FIRST so
// named routes resolve to the locale-carrying URI (nameList keeps the first
// registration) — route() then honours URL::defaults('locale') set by
// SetLocale. Bare EN routes register second: {locale?}/x fails to match a
// plain /x (Laravel's greedy first-segment quirk), so English requests fall
// through to these.
$public = function () {
    Route::get('/', Controllers\HomeController::class)->name('home');
    Route::get('/about', Controllers\AboutController::class)->name('about');
    Route::get('/manufacturing', Controllers\ManufacturingController::class)->name('manufacturing');
    Route::get('/quality-certifications', Controllers\QualityController::class)->name('quality');

    // Catalogue hierarchy: overview → category landing page → full product
    // list → product detail. Category URLs match the live site (/product/{slug})
    // so existing rankings carry over without redirects.
    Route::get('/products', [Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/product/{category}', [Controllers\ProductController::class, 'category'])->name('products.category');
    Route::get('/product/{category}/products', [Controllers\ProductController::class, 'catalogue'])->name('products.catalogue');
    Route::get('/product/{category}/{product}', [Controllers\ProductController::class, 'show'])
        ->scopeBindings()
        ->name('products.show');

    // 301s — old-site URLs (docs/seo-page-map.md) and the interim /products/{category}
    // paths. Redirects preserve the locale prefix.
    $redir = fn (string $to) => function () use ($to) {
        $prefix = ($l = app()->getLocale()) === 'en' ? '' : "/{$l}";

        return redirect($prefix.$to, 301);
    };
    Route::get('/about-us', $redir('/about'));
    Route::get('/contact-us', $redir('/contact'));
    Route::get('/iv-fluid', $redir('/product/iv-fluids'));
    Route::get('/products/{category}/{product?}', function (Request $request) {
        $prefix = ($l = app()->getLocale()) === 'en' ? '' : "/{$l}";
        [$category, $product] = [$request->route('category'), $request->route('product')];

        return redirect($prefix.($product ? "/product/{$category}/{$product}" : "/product/{$category}"), 301);
    });

    Route::get('/global-presence', [Controllers\MarketController::class, 'index'])->name('markets.index');

    Route::get('/team', [Controllers\TeamController::class, 'index'])->name('team.index');
    Route::get('/team/{member}', [Controllers\TeamController::class, 'show'])->name('team.show');

    Route::get('/inside-nymak', Controllers\InsideController::class)->name('inside');

    Route::get('/blog', [Controllers\PostController::class, 'index'])->name('posts.index');
    Route::get('/blog/{post}', [Controllers\PostController::class, 'show'])
        ->scopeBindings()
        ->name('posts.show');

    Route::get('/faqs', Controllers\FaqController::class)->name('faqs');

    Route::get('/contact', [Controllers\ContactController::class, 'create'])->name('contact');
    Route::post('/contact', [Controllers\ContactController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('contact.store');

    Route::get('/privacy-policy', [Controllers\PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [Controllers\PageController::class, 'terms'])->name('terms');
};

Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'fr|es'],
    'middleware' => SetLocale::class,
], $public);
Route::middleware(SetLocale::class)->group($public);

Route::get('/sitemap.xml', Controllers\SitemapController::class)->name('sitemap');

// llms.txt — generated from site settings + catalogue so admin edits reach AI crawlers.
Route::get('/llms.txt', function () {
    return response(view('llms', [
        'c' => \App\Models\SiteSetting::merged(),
        'categories' => \App\Models\ProductCategory::orderBy('sort_order')->get(['name', 'slug', 'intro']),
        'markets' => \App\Models\Market::orderBy('sort_order')->pluck('name'),
    ]))->header('Content-Type', 'text/plain; charset=utf-8');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [Controllers\Admin\AuthController::class, 'create'])->name('login');
        Route::post('/login', [Controllers\Admin\AuthController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [Controllers\Admin\AuthController::class, 'destroy'])->name('logout');
        Route::redirect('/', '/admin/dashboard')->name('home');
        Route::get('/dashboard', Controllers\Admin\DashboardController::class)->name('dashboard');

        Route::get('/enquiries', [Controllers\Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::patch('/enquiries/{enquiry}/read', [Controllers\Admin\EnquiryController::class, 'markRead'])->name('enquiries.read');
        Route::patch('/enquiries/{enquiry}/unread', [Controllers\Admin\EnquiryController::class, 'markUnread'])->name('enquiries.unread');
        Route::delete('/enquiries/{enquiry}', [Controllers\Admin\EnquiryController::class, 'destroy'])->name('enquiries.destroy');

        Route::resource('products', Controllers\Admin\ProductController::class)->except('show');
        Route::resource('categories', Controllers\Admin\CategoryController::class)->only('index', 'edit', 'update');
        Route::resource('markets', Controllers\Admin\MarketController::class)->except('show');
        Route::resource('posts', Controllers\Admin\PostController::class)->except('show');
        Route::resource('faqs', Controllers\Admin\FaqController::class)->except('show');
        Route::resource('testimonials', Controllers\Admin\TestimonialController::class)->except('show');
        Route::resource('certifications', Controllers\Admin\CertificationController::class)->except('show');
        Route::resource('team-members', Controllers\Admin\TeamMemberController::class)->except('show');
        Route::resource('users', Controllers\Admin\UserController::class)->except('show');
        Route::resource('seo-pages', Controllers\Admin\SeoPageController::class)->only('index', 'edit', 'update')
            ->parameters(['seo-pages' => 'seoPage']);
        Route::resource('clients', Controllers\Admin\ClientLogoController::class)->except('show');
        Route::get('/pages', [Controllers\Admin\PageContentController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [Controllers\Admin\PageContentController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [Controllers\Admin\PageContentController::class, 'update'])->name('pages.update');
        Route::get('/settings', [Controllers\Admin\SiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Controllers\Admin\SiteSettingsController::class, 'update'])->name('settings.update');

        Route::get('/profile', [Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/password', [Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
});
