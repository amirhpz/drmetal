<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Services\Metals\MetalPriceService;
use App\Support\SiteSettings;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(MetalPriceService $metalPriceService): View
    {
        return view('pages.home', [
            'featuredProducts' => Product::query()->active()->featured()->with('category')->ordered()->take(6)->get(),
            'featuredServices' => Service::query()->active()->featured()->ordered()->take(6)->get(),
            'metalPrices' => $metalPriceService->getHomepagePrices(),
            'settings' => SiteSettings::group('company'),
            'metaTitle' => SiteSettings::get('seo.default_title', config('app.name')),
            'metaDescription' => SiteSettings::get('seo.default_description', ''),
        ]);
    }
}
