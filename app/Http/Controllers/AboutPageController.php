<?php

namespace App\Http\Controllers;

use App\Support\SiteSettings;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function index(): View
    {
        return view('pages.about', [
            'settings' => SiteSettings::group('about') + SiteSettings::group('company'),
            'company' => config('company'),
            'metaTitle' => 'درباره صنایع متالورژی دکتر متال',
            'metaDescription' => 'آشنایی با صنایع متالورژی دکتر متال، بنیان‌گذار مجموعه و رویکرد دانش‌پایه در صنعت فلزات.',
        ]);
    }
}
