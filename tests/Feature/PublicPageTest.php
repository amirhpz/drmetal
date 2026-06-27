<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_public_pages_return_successful_responses(): void
    {
        foreach (['/', '/services', '/products', '/about-us', '/contact-us', '/sitemap.xml', '/robots.txt'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_homepage_displays_seeded_metal_prices(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('قیمت لحظه‌ای فلزات')
            ->assertSee('آلومینیوم');
    }
}
