<?php

return [
    'commodity_url' => env('BRS_COMMODITY_API_URL', 'https://Api.BrsApi.ir/Market/Commodity.php'),
    'gold_currency_url' => env('BRS_GOLD_CURRENCY_API_URL', 'https://Api.BrsApi.ir/Market/Gold_Currency.php'),
    'api_key' => env('BRS_API_KEY', env('METAL_PRICE_API_KEY')),
    'cache_ttl' => env('METAL_PRICE_CACHE_TTL', 300),
    'stale_after_hours' => env('METAL_PRICE_STALE_AFTER_HOURS', 24),
    'homepage_symbols' => ['XAUUSD', 'Al', 'USD', 'EUR'],
    'sort_order' => [
        'XAUUSD' => 1,
        'Al' => 2,
        'USD' => 3,
        'EUR' => 4,
    ],
];
