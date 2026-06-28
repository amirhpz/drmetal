<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ClientPageController extends Controller
{
    public function index(): View
    {
        return view('pages.clients', [
            'company' => config('company'),
            'metaTitle' => 'مشتریان دکتر متال | Top Clients',
            'metaDescription' => 'آشنایی با مشتریان برتر صنایع متالورژی دکتر متال در حوزه فلزات، آلومینیوم و قطعات صنعتی.',
        ]);
    }
}
