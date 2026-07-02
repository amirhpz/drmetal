<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ClientPageController extends Controller
{
    public function index(): View
    {
        return view('pages.clients', [
            'company' => config('company'),
            'clients' => $this->clients(),
            'metaTitle' => 'مشتریان دکتر متال | Top Clients',
            'metaDescription' => 'آشنایی با مشتریان برتر صنایع متالورژی دکتر متال در حوزه فلزات، آلومینیوم و قطعات صنعتی.',
        ]);
    }

    private function clients(): Collection
    {
        $clients = Client::query()->active()->ordered()->get();

        if ($clients->isNotEmpty()) {
            return $clients;
        }

        return collect(config('company.clients', []))
            ->map(fn (array $client): object => (object) [
                'name' => $client['name'],
                'english_name' => $client['en'] ?? null,
                'logo' => null,
                'industry' => null,
                'website' => null,
            ]);
    }
}
