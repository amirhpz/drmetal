<?php

return [
    'commodity_url' => env('BRS_COMMODITY_API_URL', 'https://Api.BrsApi.ir/Market/Commodity.php'),
    'gold_currency_url' => env('BRS_GOLD_CURRENCY_API_URL', 'https://Api.BrsApi.ir/Market/Gold_Currency.php'),
    'api_key' => env('BRS_API_KEY', env('METAL_PRICE_API_KEY')),
    'cache_ttl' => env('METAL_PRICE_CACHE_TTL', 300),
    'stale_after_hours' => env('METAL_PRICE_STALE_AFTER_HOURS', 24),
    'homepage_symbols' => ['XAUUSD', 'IR_GOLD_18K', 'XAGUSD', 'Cu', 'Al', 'USD', 'EUR'],
    'display_names' => [
        'XAUUSD' => 'انس طلا',
        'IR_GOLD_18K' => 'طلای ۱۸ عیار',
        'XAGUSD' => 'نقره',
        'Cu'     => 'مس',
        'Al'     => 'آلومینیوم',
        'USD'    => 'دلار',
        'EUR'    => 'یورو',
    ],
    'sort_order' => [
        'XAUUSD' => 1,
        'IR_GOLD_18K' => 2,
        'XAGUSD' => 3,
        'Cu'     => 4,
        'Al'     => 5,
        'USD'    => 6,
        'EUR'    => 7,
    ],
];
