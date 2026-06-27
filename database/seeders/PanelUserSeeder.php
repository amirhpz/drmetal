<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'مدیر پنل',
                'password' => Hash::make($password),
                'is_panel_user' => true,
            ]
        );
    }
}
