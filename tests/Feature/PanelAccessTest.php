<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_panel_login(): void
    {
        $this->get(route('panel.dashboard'))
            ->assertRedirect(route('panel.login'));
    }

    public function test_panel_login_page_loads(): void
    {
        $this->get(route('panel.login'))
            ->assertOk()
            ->assertSee('ورود به پنل');
    }

    public function test_authenticated_panel_user_visiting_login_redirects_to_panel_dashboard(): void
    {
        $user = User::factory()->create(['is_panel_user' => true]);

        $this->actingAs($user)
            ->get(route('panel.login'))
            ->assertRedirect(route('panel.dashboard'));
    }

    public function test_panel_user_can_login_and_access_dashboard(): void
    {
        User::factory()->create([
            'email' => 'panel@example.com',
            'password' => 'password',
            'is_panel_user' => true,
        ]);

        $this->post(route('panel.login.store'), [
            'email' => 'panel@example.com',
            'password' => 'password',
        ])->assertRedirect(route('panel.dashboard'));

        $this->get(route('panel.dashboard'))
            ->assertOk()
            ->assertSee('داشبورد');
    }

    public function test_user_without_panel_access_is_forbidden(): void
    {
        $user = User::factory()->create(['is_panel_user' => false]);

        $this->actingAs($user)
            ->get(route('panel.dashboard'))
            ->assertForbidden();
    }
}
