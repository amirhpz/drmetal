<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProductCategory::query()->active()->ordered()->get();
        $selectedCategory = null;

        $products = Product::query()
            ->active()
            ->with('category')
            ->when($request->filled('category'), function ($query) use ($request, &$selectedCategory): void {
                $selectedCategory = ProductCategory::query()
                    ->active()
                    ->where('slug', $request->string('category')->toString())
                    ->first();

                if ($selectedCategory) {
                    $query->whereBelongsTo($selectedCategory, 'category');
                }
            })
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('pages.products.index', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $selectedCategory,
            'metaTitle' => 'محصولات آلومینیومی صنعتی',
            'metaDescription' => 'مشاهده شمش آلومینیوم، بیلت، آلیاژها و گزینه‌های تامین صنعتی سفارشی.',
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $relatedProducts = Product::query()
            ->active()
            ->with('category')
            ->whereKeyNot($product->getKey())
            ->when($product->product_category_id, fn ($query) => $query->where('product_category_id', $product->product_category_id))
            ->ordered()
            ->take(3)
            ->get();

        return view('pages.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'metaTitle' => $product->meta_title ?: $product->title,
            'metaDescription' => $product->meta_description ?: $product->short_description,
        ]);
    }
}
