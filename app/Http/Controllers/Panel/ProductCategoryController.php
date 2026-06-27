<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function index(): View
    {
        return view('panel.product-categories.index', [
            'categories' => ProductCategory::query()
                ->withCount('products')
                ->ordered()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('panel.product-categories.create', [
            'category' => new ProductCategory(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ProductCategory::query()->create($this->validatedData($request));

        return redirect()
            ->route('panel.product-categories.index')
            ->with('success', 'دسته‌بندی محصول ایجاد شد.');
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view('panel.product-categories.edit', [
            'category' => $productCategory,
        ]);
    }

    public function update(Request $request, ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->update($this->validatedData($request, $productCategory));

        return redirect()
            ->route('panel.product-categories.index')
            ->with('success', 'دسته‌بندی محصول به‌روزرسانی شد.');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();

        return redirect()
            ->route('panel.product-categories.index')
            ->with('success', 'دسته‌بندی محصول حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?ProductCategory $category = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9-]+$/',
                Rule::unique('product_categories', 'slug')->ignore($category),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ], [
            'title.required' => 'عنوان دسته‌بندی را وارد کنید.',
            'slug.regex' => 'نامک فقط می‌تواند شامل حروف انگلیسی، عدد و خط تیره باشد.',
            'slug.unique' => 'این نامک قبلا ثبت شده است.',
        ]);

        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $category);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function uniqueSlug(string $title, ?ProductCategory $category = null): string
    {
        $base = Str::slug($title) ?: 'category';
        $slug = $base;
        $counter = 1;

        while (ProductCategory::query()
            ->where('slug', $slug)
            ->when($category, fn ($query) => $query->whereKeyNot($category->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
