<?php

namespace Database\Seeders;

use App\Models\PanelRole;
use Illuminate\Database\Seeder;

class PanelRoleSeeder extends Seeder
{
    public function run(): void
    {
        PanelRole::query()->updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'مدیر کل',
                'description' => 'دسترسی کامل به تمام بخش‌های پنل.',
                'permissions' => array_keys(config('panel.permissions', [])),
                'is_active' => true,
                'sort_order' => 1,
            ],
        );
    }
}
