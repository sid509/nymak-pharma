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
        Route::get('/', [Controllers\Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::patch('/enquiries/{enquiry}/read', [Controllers\Admin\EnquiryController::class, 'markRead'])->name('enquiries.read');
        Route::delete('/enquiries/{enquiry}', [Controllers\Admin\EnquiryController::class, 'destroy'])->name('enquiries.destroy');
    });
});
