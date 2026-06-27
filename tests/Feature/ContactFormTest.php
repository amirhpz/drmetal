<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_contact_form_submission_is_stored(): void
    {
        $response = $this->post(route('contact.store'), [
            'full_name' => 'علی رضایی',
            'phone' => '09120000000',
            'email' => 'ali@example.com',
            'subject' => 'استعلام',
            'message' => 'برای دریافت اطلاعات محصول تماس گرفته‌ام.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', ['phone' => '09120000000']);
    }

    public function test_invalid_contact_form_returns_validation_errors(): void
    {
        $this->post(route('contact.store'), [])
            ->assertSessionHasErrors(['full_name', 'phone', 'message']);
    }

    public function test_contact_honeypot_rejects_submission(): void
    {
        $this->post(route('contact.store'), [
            'full_name' => 'علی رضایی',
            'phone' => '09120000000',
            'message' => 'پیام معتبر برای تست فرم تماس.',
            'website' => 'bot',
        ])->assertSessionHasErrors(['website']);
    }
}
