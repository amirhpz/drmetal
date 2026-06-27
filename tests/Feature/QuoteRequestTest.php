<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_valid_quote_request_is_stored_with_product(): void
    {
        $product = Product::query()->firstOrFail();

        $this->post(route('quote.store'), [
            'product_id' => $product->id,
            'company_name' => 'شرکت نمونه',
            'contact_person' => 'مریم احمدی',
            'phone' => '02100000000',
            'email' => 'sales@example.com',
            'quantity' => 'یک محموله',
            'message' => 'لطفا شرایط فروش را اعلام کنید.',
        ])->assertRedirect();

        $this->assertDatabaseHas('quote_requests', [
            'product_id' => $product->id,
            'phone' => '02100000000',
        ]);
    }

    public function test_invalid_quote_request_returns_validation_errors(): void
    {
        $this->post(route('quote.store'), [])
            ->assertSessionHasErrors(['contact_person', 'phone']);
    }
}
