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
            'metaTitle' => 'درباره شرکت',
            'metaDescription' => 'آشنایی با رویکرد شرکت در تولید و تامین محصولات آلومینیومی برای مشتریان صنعتی.',
        ]);
    }
}
