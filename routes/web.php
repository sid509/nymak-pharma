<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', Controllers\HomeController::class)->name('home');
Route::get('/about', Controllers\AboutController::class)->name('about');
Route::get('/manufacturing', Controllers\ManufacturingController::class)->name('manufacturing');
Route::get('/quality-certifications', Controllers\QualityController::class)->name('quality');

Route::get('/products', [Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{category}', [Controllers\ProductController::class, 'category'])->name('products.category');
Route::get('/products/{category}/{product}', [Controllers\ProductController::class, 'show'])
    ->scopeBindings()
    ->name('products.show');

Route::get('/global-presence', [Controllers\MarketController::class, 'index'])->name('markets.index');
Route::get('/global-presence/{market}', [Controllers\MarketController::class, 'show'])->name('markets.show');

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

Route::get('/sitemap.xml', Controllers\SitemapController::class)->name('sitemap');

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

        Route::get('/profile', [Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/password', [Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
});
