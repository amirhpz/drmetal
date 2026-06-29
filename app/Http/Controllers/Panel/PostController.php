<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%')
                        ->orWhere('category', 'like', '%'.$search.'%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                match ($request->string('status')->toString()) {
                    'active' => $query->where('is_active', true),
                    'inactive' => $query->where('is_active', false),
                    'featured' => $query->where('is_featured', true),
                    'published' => $query->whereNotNull('published_at')->where('published_at', '<=', now()),
                    'draft' => $query->whereNull('published_at'),
                    default => null,
                };
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panel.posts.index', [
            'posts' => $posts,
            'filters' => [
                'q' => $request->string('q')->toString(),
                'status' => $request->string('status')->toString(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('panel.posts.create', [
            'post' => new Post([
                'author_name' => 'تیم دکتر متال',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->rejectFailedUpload($request);

        $data = $this->validatedData($request);
        $this->applyUploadedImage($request, $data);

        Post::query()->create($data);

        return redirect()
            ->route('panel.posts.index')
            ->with('success', 'پست ایجاد شد.');
    }

    public function edit(Post $post): View
    {
        return view('panel.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->rejectFailedUpload($request);

        $data = $this->validatedData($request, $post);
        $this->applyUploadedImage($request, $data, $post);

        $post->update($data);

        return redirect()
            ->route('panel.posts.index')
            ->with('success', 'پست به‌روزرسانی شد.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            $this->deleteStoredPublicAsset($post->featured_image);
        }

        $post->delete();

        return redirect()
            ->route('panel.posts.index')
            ->with('success', 'پست حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9-]+$/',
                Rule::unique('posts', 'slug')->ignore($post),
            ],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'featured_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'category' => ['nullable', 'string', 'max:120'],
            'author_name' => ['nullable', 'string', 'max:120'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ], [
            'title.required' => 'عنوان پست را وارد کنید.',
            'slug.regex' => 'نامک فقط می‌تواند شامل حروف انگلیسی، عدد و خط تیره باشد.',
            'slug.unique' => 'این نامک قبلا ثبت شده است.',
            'excerpt.max' => 'خلاصه پست نباید بیشتر از ۱۰۰۰ کاراکتر باشد.',
            'featured_image_file.uploaded' => 'تصویر پست بارگذاری نشد. حجم فایل نباید از محدودیت سرور بیشتر باشد.',
            'featured_image_file.image' => 'تصویر پست باید فایل تصویری باشد.',
            'featured_image_file.mimes' => 'فرمت تصویر پست باید jpg، jpeg، png یا webp باشد.',
            'featured_image_file.max' => 'حجم تصویر پست نباید بیشتر از ۲ مگابایت باشد.',
            'published_at.date' => 'تاریخ انتشار معتبر نیست.',
        ]);

        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $post);
        $data['published_at'] = blank($data['published_at'] ?? null) ? null : $data['published_at'];
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        unset($data['featured_image_file'], $data['remove_featured_image']);

        return $data;
    }

    private function rejectFailedUpload(Request $request): void
    {
        $image = $request->file('featured_image_file');

        if ($image && ! $image->isValid()) {
            throw ValidationException::withMessages([
                'featured_image_file' => $this->uploadFailureMessage($image->getError()),
            ]);
        }
    }

    private function uploadFailureMessage(int $errorCode): string
    {
        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'تصویر پست از محدودیت حجم تنظیم‌شده در PHP بیشتر است.',
            UPLOAD_ERR_PARTIAL => 'تصویر پست به صورت ناقص بارگذاری شد. دوباره تلاش کنید.',
            UPLOAD_ERR_NO_TMP_DIR => 'پوشه موقت آپلود PHP تنظیم نشده است. مقدار upload_tmp_dir را بررسی کنید.',
            UPLOAD_ERR_CANT_WRITE => 'PHP اجازه نوشتن در پوشه موقت آپلود را ندارد. دسترسی upload_tmp_dir را بررسی کنید.',
            UPLOAD_ERR_EXTENSION => 'یکی از افزونه‌های PHP جلوی آپلود فایل را گرفته است.',
            default => 'تصویر پست بارگذاری نشد. کد خطای PHP: '.$errorCode,
        };
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function applyUploadedImage(Request $request, array &$data, ?Post $post = null): void
    {
        if ($request->boolean('remove_featured_image') && $post?->featured_image) {
            $this->deleteStoredPublicAsset($post->featured_image);
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image_file')) {
            if ($post?->featured_image) {
                $this->deleteStoredPublicAsset($post->featured_image);
            }

            $data['featured_image'] = 'storage/'.$request->file('featured_image_file')->store('posts', 'public');
        }
    }

    private function deleteStoredPublicAsset(string $path): void
    {
        $relativePath = Str::after($path, 'storage/');

        if ($relativePath !== $path) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function uniqueSlug(string $title, ?Post $post = null): string
    {
        $base = Str::slug($title) ?: 'post';
        $slug = $base;
        $counter = 1;

        while (Post::query()
            ->where('slug', $slug)
            ->when($post, fn ($query) => $query->whereKeyNot($post->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
