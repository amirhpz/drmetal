<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('company.clients', []) as $index => $client) {
            Client::query()->updateOrCreate(
                ['name' => $client['name']],
                [
                    'english_name' => $client['en'] ?? null,
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
