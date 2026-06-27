<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::query()->active()->ordered()->get(),
            'metaTitle' => 'خدمات تامین و تولید آلومینیوم',
            'metaDescription' => 'خدمات تولید شمش آلومینیوم، تامین عمده صنعتی، کنترل کیفیت، بسته‌بندی و هماهنگی تحویل.',
        ]);
    }
}
