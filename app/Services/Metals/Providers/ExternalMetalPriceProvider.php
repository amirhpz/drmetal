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
        $apiKey = config('metals.api_key');

        if (! $apiKey) {
            return collect();
        }

        $items = collect()
            ->merge($this->commodityItems($apiKey))
            ->merge($this->goldCurrencyItems($apiKey));

        return $items
            ->map(fn (array $item): MetalPrice => $this->toMetalPrice($item))
            ->filter(fn (MetalPrice $price): bool => filled($price->symbol))
            ->unique('symbol')
            ->sortBy('sort_order')
            ->values();
    }

    private function commodityItems(string $apiKey): Collection
    {
        $response = $this->get(config('metals.commodity_url'), $apiKey);

        if (! $response) {
            return collect();
        }

        $symbols = config('metals.homepage_symbols', []);

        return collect($response['metal_precious'] ?? [])
            ->merge(collect($response['metal_base'] ?? []))
            ->whereIn('symbol', $symbols)
            ->values();
    }

    private function goldCurrencyItems(string $apiKey): Collection
    {
        $response = $this->get(config('metals.gold_currency_url'), $apiKey);

        if (! $response) {
            return collect();
        }

        return collect($response['gold'] ?? [])
            ->merge(collect($response['currency'] ?? []))
            ->whereIn('symbol', config('metals.homepage_symbols', []))
            ->values();
    }

    /**
     * @return array<string, mixed>|null
     */
    private function get(?string $url, string $apiKey): ?array
    {
        if (! $url) {
            return null;
        }

        $response = Http::timeout(10)
            ->acceptJson()
            ->get($url, ['key' => $apiKey]);

        return $response->successful() ? $response->json() : null;
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function toMetalPrice(array $item): MetalPrice
    {
        $symbol = (string) ($item['symbol'] ?? '');
        $changePercent = $item['change_percent'] ?? null;
        $timestamp = isset($item['time_unix']) ? now()->setTimestamp((int) $item['time_unix']) : now();

        return new MetalPrice([
            'name' => $this->displayName($symbol, (string) ($item['name'] ?? '')),
            'symbol' => $symbol,
            'price' => $item['price'] ?? null,
            'unit' => $item['unit'] ?? null,
            'currency' => $this->currency($item),
            'change_amount' => $item['change_value'] ?? null,
            'change_percent' => $changePercent,
            'direction' => $this->direction($changePercent),
            'source' => 'api',
            'provider' => 'BRS API',
            'last_updated_at' => $timestamp,
            'is_stale' => false,
            'is_active' => true,
            'sort_order' => config('metals.sort_order.'.$symbol, 100),
            'raw_payload' => $item,
        ]);
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function currency(array $item): ?string
    {
        return match ($item['unit'] ?? null) {
            'تومان' => 'IRT',
            'دلار' => 'USD',
            default => $item['unit'] ?? null,
        };
    }

    private function direction(mixed $changePercent): string
    {
        $value = (float) ($changePercent ?? 0);

        return match (true) {
            $value > 0 => 'up',
            $value < 0 => 'down',
            default => 'neutral',
        };
    }

    private function displayName(string $symbol, string $fallback): string
    {
        return config('metals.display_names.'.$symbol, $fallback);
    }
}
