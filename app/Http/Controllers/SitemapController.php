<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            route('home'),
            route('services.index'),
            route('products.index'),
            route('about'),
            route('contact.index'),
        ])->merge(
            Product::query()->active()->ordered()->pluck('slug')->map(fn (string $slug): string => route('products.show', $slug))
        );

        return response()
            ->view('sitemap', ['urls' => $urls], 200)
            ->header('Content-Type', 'application/xml');
    }
}
