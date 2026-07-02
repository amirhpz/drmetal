<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
            'clients' => $this->featuredClients(),
            'metalPrices' => $metalPriceService->getHomepagePrices(),
            'settings' => SiteSettings::group('company') + SiteSettings::group('about'),
            'company' => config('company'),
            'metaTitle' => SiteSettings::get('seo.default_title', config('app.name')),
            'metaDescription' => SiteSettings::get('seo.default_description', ''),
        ]);
    }

    private function featuredClients()
    {
        $clients = Client::query()->active()->featured()->ordered()->take(8)->get();

        if ($clients->isNotEmpty()) {
            return $clients;
        }

        return collect(config('company.clients', []))
            ->take(8)
            ->map(fn (array $client): object => (object) [
                'name' => $client['name'],
                'english_name' => $client['en'] ?? null,
                'logo' => null,
            ]);
    }
}
