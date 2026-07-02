<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Support\SiteSettings;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function index(): View
    {
        return view('pages.about', [
            'settings' => SiteSettings::group('about') + SiteSettings::group('company'),
            'company' => config('company'),
            'clients' => $this->featuredClients(),
            'metaTitle' => 'درباره صنایع متالورژی دکتر متال',
            'metaDescription' => 'آشنایی با صنایع متالورژی دکتر متال، بنیان‌گذار مجموعه و رویکرد دانش‌پایه در صنعت فلزات.',
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
