<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PanelRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PanelUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('PANEL_ADMIN_EMAIL');
        $password = env('PANEL_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            return;
        }

        $role = PanelRole::query()->firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'مدیر کل',
                'description' => 'دسترسی کامل به تمام بخش‌های پنل.',
                'permissions' => array_keys(config('panel.permissions', [])),
                'is_active' => true,
                'sort_order' => 1,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'مدیر پنل',
                'password' => Hash::make($password),
                'is_panel_user' => true,
                'panel_role_id' => $role->id,
            ]
        );
    }
}
