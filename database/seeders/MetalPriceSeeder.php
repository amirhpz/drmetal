<?php

namespace Database\Seeders;

use App\Models\MetalPrice;
use Illuminate\Database\Seeder;

class MetalPriceSeeder extends Seeder
{
    public function run(): void
    {
        MetalPrice::query()
            ->whereNotIn('symbol', config('metals.homepage_symbols', ['XAUUSD', 'Al', 'USD', 'EUR']))
            ->update(['is_active' => false]);

        $prices = [
            ['name' => 'طلا', 'symbol' => 'XAUUSD', 'price' => 3395.52, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => -0.08, 'direction' => 'down', 'sort_order' => 1],
            ['name' => 'آلومینیوم', 'symbol' => 'Al', 'price' => 2647.20, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => 0.09, 'direction' => 'up', 'sort_order' => 2],
            ['name' => 'دلار', 'symbol' => 'USD', 'price' => 81650, 'unit' => 'تومان', 'currency' => 'IRT', 'change_percent' => -0.91, 'direction' => 'down', 'sort_order' => 3],
            ['name' => 'یورو', 'symbol' => 'EUR', 'price' => 91150, 'unit' => 'تومان', 'currency' => 'IRT', 'change_percent' => -0.86, 'direction' => 'down', 'sort_order' => 4],
        ];

        foreach ($prices as $price) {
            MetalPrice::query()->updateOrCreate(
                ['symbol' => $price['symbol']],
                $price + [
                    'currency' => $price['currency'],
                    'source' => 'seed',
                    'provider' => 'seeded fallback',
                    'last_updated_at' => now(),
                    'is_active' => true,
                    'is_stale' => false,
                ]
            );
        }
    }
}
