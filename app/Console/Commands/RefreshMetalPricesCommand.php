<?php

namespace App\Console\Commands;

use App\Services\Metals\MetalPriceService;
use Illuminate\Console\Command;

class RefreshMetalPricesCommand extends Command
{
    protected $signature = 'metals:refresh-prices';

    protected $description = 'Fetch latest configured metal and currency prices from BRS API.';

    public function handle(MetalPriceService $metalPriceService): int
    {
        $prices = $metalPriceService->refreshHomepagePrices();

        $this->info('Updated '.$prices->count().' homepage price records.');

        return self::SUCCESS;
    }
}
