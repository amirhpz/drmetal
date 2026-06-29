<?php

namespace App\Services\Metals;

use App\Models\MetalPrice;
use App\Services\Metals\Providers\DatabaseMetalPriceProvider;
use App\Services\Metals\Providers\ExternalMetalPriceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MetalPriceService
{
    public function __construct(
        private readonly ExternalMetalPriceProvider $externalProvider,
        private readonly DatabaseMetalPriceProvider $databaseProvider,
    ) {}

    public function getHomepagePrices(): Collection
    {
        $cachedPrices = Cache::get('homepage_metal_prices');

        if (is_array($cachedPrices)) {
            return MetalPrice::hydrate($cachedPrices);
        }

        Cache::forget('homepage_metal_prices');

        $prices = $this->resolveHomepagePrices();

        Cache::put(
            'homepage_metal_prices',
            $prices->map(fn (MetalPrice $price): array => $price->getAttributes())->all(),
            (int) config('metals.cache_ttl', 900),
        );

        return $prices;
    }

    public function refreshHomepagePrices(): Collection
    {
        Cache::forget('homepage_metal_prices');

        $prices = $this->resolveHomepagePrices();

        Cache::put(
            'homepage_metal_prices',
            $prices->map(fn (MetalPrice $price): array => $price->getAttributes())->all(),
            (int) config('metals.cache_ttl', 300),
        );

        return $prices;
    }

    private function resolveHomepagePrices(): Collection
    {
        try {
            $externalPrices = $this->externalProvider->prices();

            if ($externalPrices->isNotEmpty()) {
                $this->persistExternalPrices($externalPrices);

                return $externalPrices;
            }
        } catch (\Throwable $exception) {
            Log::warning('Metal price provider failed.', ['message' => $exception->getMessage()]);
        }

        return $this->databaseProvider->prices()->map(function (MetalPrice $price): MetalPrice {
            $staleAfter = now()->subHours((int) config('metals.stale_after_hours', 24));

            if ($price->last_updated_at && $price->last_updated_at->lt($staleAfter)) {
                $price->is_stale = true;
            }

            return $price;
        });
    }

    private function persistExternalPrices(Collection $prices): void
    {
        $prices->each(function (MetalPrice $price): void {
            MetalPrice::query()->updateOrCreate(
                ['symbol' => $price->symbol],
                $price->only([
                    'name',
                    'price',
                    'unit',
                    'currency',
                    'change_amount',
                    'change_percent',
                    'direction',
                    'source',
                    'provider',
                    'last_updated_at',
                    'is_stale',
                    'is_active',
                    'sort_order',
                    'raw_payload',
                ])
            );
        });
    }
}
