<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_product_details_load_by_slug(): void
    {
        $product = Product::query()->firstOrFail();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee($product->title);
    }

    public function test_inactive_product_details_return_not_found(): void
    {
        $product = Product::query()->firstOrFail();
        $product->update(['is_active' => false]);

        $this->get(route('products.show', $product))->assertNotFound();
    }
}
