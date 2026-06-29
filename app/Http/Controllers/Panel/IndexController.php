<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        return view('panel.dashboard', [
            'productCount' => Product::query()->count(),
            'postCount' => Post::query()->count(),
            'categoryCount' => ProductCategory::query()->count(),
            'serviceCount' => Service::query()->count(),
            'panelUserCount' => User::query()->where('is_panel_user', true)->count(),
            'newContactCount' => ContactMessage::query()->where('status', 'new')->count(),
            'newQuoteCount' => QuoteRequest::query()->where('status', 'new')->count(),
            'latestProducts' => Product::query()
                ->with('category')
                ->latest()
                ->take(5)
                ->get(),
            'latestPosts' => Post::query()
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
