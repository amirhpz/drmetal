<?php

namespace App\Services\Metals\Providers;

use App\Models\MetalPrice;
use App\Services\Metals\Contracts\MetalPriceProvider;
use Illuminate\Support\Collection;

class DatabaseMetalPriceProvider implements MetalPriceProvider
{
    public function prices(): Collection
    {
        return MetalPrice::query()
            ->active()
            ->ordered()
            ->get();
    }
}
