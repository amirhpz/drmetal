<?php

namespace App\Services\Metals\Providers;

use App\Models\MetalPrice;
use App\Services\Metals\Contracts\MetalPriceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ExternalMetalPriceProvider implements MetalPriceProvider
{
    public function prices(): Collection
    {
        $url = config('metals.provider_url');
        $apiKey = config('metals.api_key');

        if (! $url || ! $apiKey) {
            return collect();
        }

        $response = Http::timeout(5)
            ->acceptJson()
            ->withToken($apiKey)
            ->get($url);

        if (! $response->successful()) {
            return collect();
        }

        $items = collect($response->json('data', []));

        return $items->map(function (array $item): MetalPrice {
            return new MetalPrice([
                'name' => $item['name'] ?? '',
                'symbol' => $item['symbol'] ?? '',
                'price' => $item['price'] ?? null,
                'unit' => $item['unit'] ?? null,
                'currency' => $item['currency'] ?? 'USD',
                'change_amount' => $item['change_amount'] ?? null,
                'change_percent' => $item['change_percent'] ?? null,
                'direction' => $item['direction'] ?? 'neutral',
                'source' => 'api',
                'provider' => $item['provider'] ?? 'external',
                'last_updated_at' => now(),
                'is_stale' => false,
                'raw_payload' => $item,
            ]);
        })->filter(fn (MetalPrice $price): bool => filled($price->symbol));
    }
}
