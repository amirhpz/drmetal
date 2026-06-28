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
            'company' => config('company'),
            'metaTitle' => 'زمینه‌های فعالیت دکتر متال | Fields of Activity',
            'metaDescription' => 'زمینه‌های فعالیت دکتر متال شامل طراحی، تولید و بهینه‌سازی شمش آلیاژی آلومینیوم، قطعات دایکاست، ورق آلومینیومی و خرید و فروش فلزات رنگین.',
        ]);
    }
}
