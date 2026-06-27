<?php

namespace App\Services\Metals\Contracts;

use Illuminate\Support\Collection;

interface MetalPriceProvider
{
    public function prices(): Collection;
}
