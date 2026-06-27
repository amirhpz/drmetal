<?php

return [
    'provider_url' => env('METAL_PRICE_API_URL'),
    'api_key' => env('METAL_PRICE_API_KEY'),
    'cache_ttl' => env('METAL_PRICE_CACHE_TTL', 900),
    'stale_after_hours' => env('METAL_PRICE_STALE_AFTER_HOURS', 24),
];
