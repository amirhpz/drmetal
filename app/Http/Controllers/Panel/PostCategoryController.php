<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostCategoryController extends Controller
{
    public function index(): View
    {
        return view('panel.post-categories.index', [
            'categories' => PostCategory::query()
                ->withCount('posts')
                ->ordered()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('panel.post-categories.create', [
            'category' => new PostCategory(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PostCategory::query()->create($this->validatedData($request));

        return redirect()
            ->route('panel.post-categories.index')
            ->with('success', 'دسته‌بندی مقاله ایجاد شد.');
    }

    public function edit(PostCategory $postCategory): View
    {
        return view('panel.post-categories.edit', [
            'category' => $postCategory,
        ]);
    }

    public function update(Request $request, PostCategory $postCategory): RedirectResponse
    {
        $postCategory->update($this->validatedData($request, $postCategory));
        $postCategory->posts()->update(['category' => $postCategory->title]);

        return redirect()
            ->route('panel.post-categories.index')
            ->with('success', 'دسته‌بندی مقاله به‌روزرسانی شد.');
    }

    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        $postCategory->posts()->update(['category' => null]);
        $postCategory->delete();

        return redirect()
            ->route('panel.post-categories.index')
            ->with('success', 'دسته‌بندی مقاله حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?PostCategory $category = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9-]+$/',
                Rule::unique('post_categories', 'slug')->ignore($category),
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

    private function uniqueSlug(string $title, ?PostCategory $category = null): string
    {
        $base = Str::slug($title) ?: 'post-category';
        $slug = $base;
        $counter = 1;

        while (PostCategory::query()
            ->where('slug', $slug)
            ->when($category, fn ($query) => $query->whereKeyNot($category->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
