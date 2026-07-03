<?php

namespace Database\Seeders;

use App\Models\MetalPrice;
use Illuminate\Database\Seeder;

class MetalPriceSeeder extends Seeder
{
    public function run(): void
    {
        MetalPrice::query()
            ->whereNotIn('symbol', config('metals.homepage_symbols', ['XAUUSD', 'IR_GOLD_18K', 'XAGUSD', 'Cu', 'Al', 'USD', 'EUR']))
            ->update(['is_active' => false]);

        $prices = [
            ['name' => 'انس طلا', 'symbol' => 'XAUUSD', 'price' => 3395.52, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => -0.08, 'direction' => 'down', 'sort_order' => 1],
            ['name' => 'طلای ۱۸ عیار', 'symbol' => 'IR_GOLD_18K', 'price' => 17462700, 'unit' => 'تومان', 'currency' => 'IRT', 'change_percent' => 1.19, 'direction' => 'up', 'sort_order' => 2],
            ['name' => 'نقره', 'symbol' => 'XAGUSD', 'price' => 36.82, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => 0.00, 'direction' => 'neutral', 'sort_order' => 3],
            ['name' => 'مس', 'symbol' => 'Cu', 'price' => 9890.00, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => 0.00, 'direction' => 'neutral', 'sort_order' => 4],
            ['name' => 'آلومینیوم', 'symbol' => 'Al', 'price' => 2647.20, 'unit' => 'دلار', 'currency' => 'USD', 'change_percent' => 0.09, 'direction' => 'up', 'sort_order' => 5],
            ['name' => 'دلار', 'symbol' => 'USD', 'price' => 81650, 'unit' => 'تومان', 'currency' => 'IRT', 'change_percent' => -0.91, 'direction' => 'down', 'sort_order' => 6],
            ['name' => 'یورو', 'symbol' => 'EUR', 'price' => 91150, 'unit' => 'تومان', 'currency' => 'IRT', 'change_percent' => -0.86, 'direction' => 'down', 'sort_order' => 7],
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
