<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CertificationPageController extends Controller
{
    public function index(): View
    {
        return view('pages.certifications', [
            'company' => config('company'),
            'metaTitle' => 'گواهینامه‌های دکتر متال | Certifications & Approvals',
            'metaDescription' => 'گواهینامه‌ها و تأییدیه‌های ISO، IMS و HSE صنایع متالورژی دکتر متال.',
        ]);
    }
}
