<?php

namespace Database\Seeders;

use App\Models\MetalPrice;
use Illuminate\Database\Seeder;

class MetalPriceSeeder extends Seeder
{
    public function run(): void
    {
        $prices = [
            ['name' => 'آلومینیوم', 'symbol' => 'AL', 'price' => 2500, 'unit' => 'دلار / تن', 'change_percent' => 0.42, 'direction' => 'up', 'sort_order' => 1],
            ['name' => 'مس', 'symbol' => 'CU', 'price' => 9600, 'unit' => 'دلار / تن', 'change_percent' => -0.18, 'direction' => 'down', 'sort_order' => 2],
            ['name' => 'طلا', 'symbol' => 'AU', 'price' => 2320, 'unit' => 'دلار / اونس', 'change_percent' => 0.24, 'direction' => 'up', 'sort_order' => 3],
            ['name' => 'نقره', 'symbol' => 'AG', 'price' => 29.40, 'unit' => 'دلار / اونس', 'change_percent' => -0.08, 'direction' => 'down', 'sort_order' => 4],
            ['name' => 'پلاتین', 'symbol' => 'PT', 'price' => 980, 'unit' => 'دلار / اونس', 'change_percent' => 0.16, 'direction' => 'up', 'sort_order' => 5],
            ['name' => 'پالادیوم', 'symbol' => 'PD', 'price' => 925, 'unit' => 'دلار / اونس', 'change_percent' => -0.22, 'direction' => 'down', 'sort_order' => 6],
        ];

        foreach ($prices as $price) {
            MetalPrice::query()->updateOrCreate(
                ['symbol' => $price['symbol']],
                $price + [
                    'currency' => 'USD',
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
