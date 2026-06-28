<?php

use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\Auth\PanelLoginController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\CertificationPageController;
use App\Http\Controllers\ClientPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Panel\IndexController as PanelIndexController;
use App\Http\Controllers\Panel\ProductCategoryController as PanelProductCategoryController;
use App\Http\Controllers\Panel\ProductController as PanelProductController;
use App\Http\Controllers\Panel\UserController as PanelUserController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\PublicStorageController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/clients', [ClientPageController::class, 'index'])->name('clients.index');
Route::get('/certifications', [CertificationPageController::class, 'index'])->name('certifications.index');
Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductPageController::class, 'show'])->name('products.show');
Route::redirect('/about', '/about-us');
Route::get('/about-us', [AboutPageController::class, 'index'])->name('about');
Route::redirect('/contact', '/contact-us');
Route::get('/contact-us', [ContactPageController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactPageController::class, 'store'])->middleware('throttle:contact-form')->name('contact.store');
Route::post('/quote-request', [QuoteRequestController::class, 'store'])->middleware('throttle:quote-form')->name('quote.store');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', fn () => response("User-agent: *\nAllow: /\nSitemap: ".route('sitemap')."\n", 200, ['Content-Type' => 'text/plain']));
Route::get('/storage/{path}', PublicStorageController::class)
    ->where('path', '.*')
    ->name('storage.public');

Route::middleware('guest')->group(function (): void {
    Route::get('/panel/login', [PanelLoginController::class, 'create'])->name('panel.login');
    Route::post('/panel/login', [PanelLoginController::class, 'store'])->name('panel.login.store');
});

Route::middleware(['auth', 'panel'])
    ->prefix('panel')
    ->name('panel.')
    ->group(function (): void {
        Route::get('/', [PanelIndexController::class, 'index'])->name('dashboard');
        Route::post('/logout', [PanelLoginController::class, 'destroy'])->name('logout');
        Route::resource('users', PanelUserController::class)->except('show');
        Route::resource('product-categories', PanelProductCategoryController::class)->except('show');
        Route::resource('products', PanelProductController::class)->except('show');
    });
