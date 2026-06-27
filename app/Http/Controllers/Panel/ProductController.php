<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('panel.products.index', [
            'products' => Product::query()
                ->with('category')
                ->ordered()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('panel.products.create', [
            'product' => new Product([
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->rejectFailedUploads($request);

        $data = $this->validatedData($request);
        $this->applyUploadedImages($request, $data);

        Product::query()->create($data);

        return redirect()
            ->route('panel.products.index')
            ->with('success', 'محصول ایجاد شد.');
    }

    public function edit(Product $product): View
    {
        return view('panel.products.edit', [
            'product' => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->rejectFailedUploads($request);

        $data = $this->validatedData($request, $product);
        $this->applyUploadedImages($request, $data, $product);

        $product->update($data);

        return redirect()
            ->route('panel.products.index')
            ->with('success', 'محصول به‌روزرسانی شد.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteProductImages($product);

        $product->delete();

        return redirect()
            ->route('panel.products.index')
            ->with('success', 'محصول حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9-]+$/',
                Rule::unique('products', 'slug')->ignore($product),
            ],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'grade' => ['nullable', 'string', 'max:255'],
            'purity' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:255'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'packaging' => ['nullable', 'string', 'max:255'],
            'minimum_order_quantity' => ['nullable', 'string', 'max:255'],
            'featured_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_files' => ['nullable', 'array', 'max:8'],
            'gallery_files.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'remove_gallery_images' => ['nullable', 'array'],
            'remove_gallery_images.*' => ['string'],
            'applications_text' => ['nullable', 'string'],
            'specifications_text' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ], [
            'title.required' => 'عنوان محصول را وارد کنید.',
            'slug.regex' => 'نامک فقط می‌تواند شامل حروف انگلیسی، عدد و خط تیره باشد.',
            'slug.unique' => 'این نامک قبلا ثبت شده است.',
            'product_category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نیست.',
            'featured_image_file.uploaded' => 'تصویر اصلی بارگذاری نشد. حجم فایل نباید از محدودیت سرور بیشتر باشد.',
            'featured_image_file.image' => 'تصویر اصلی باید فایل تصویری باشد.',
            'featured_image_file.mimes' => 'فرمت تصویر اصلی باید jpg، jpeg، png یا webp باشد.',
            'featured_image_file.max' => 'حجم تصویر اصلی نباید بیشتر از ۲ مگابایت باشد.',
            'gallery_files.max' => 'حداکثر ۸ تصویر گالری را همزمان بارگذاری کنید.',
            'gallery_files.*.uploaded' => 'یکی از تصاویر گالری بارگذاری نشد. حجم فایل نباید از محدودیت سرور بیشتر باشد.',
            'gallery_files.*.image' => 'فایل‌های گالری باید تصویر باشند.',
            'gallery_files.*.mimes' => 'فرمت تصاویر گالری باید jpg، jpeg، png یا webp باشد.',
            'gallery_files.*.max' => 'حجم هر تصویر گالری نباید بیشتر از ۲ مگابایت باشد.',
        ]);

        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $product);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['applications'] = $this->linesToArray($data['applications_text'] ?? null);
        $data['specifications'] = $this->keyValueLinesToArray($data['specifications_text'] ?? null);

        unset(
            $data['applications_text'],
            $data['specifications_text'],
            $data['featured_image_file'],
            $data['gallery_files'],
            $data['remove_featured_image'],
            $data['remove_gallery_images'],
        );

        return $data;
    }

    private function rejectFailedUploads(Request $request): void
    {
        $messages = [];

        $featuredImage = $request->file('featured_image_file');

        if ($featuredImage && ! $featuredImage->isValid()) {
            $messages['featured_image_file'] = $this->uploadFailureMessage('تصویر اصلی', $featuredImage->getError());
        }

        foreach ($request->file('gallery_files', []) as $index => $galleryFile) {
            if ($galleryFile && ! $galleryFile->isValid()) {
                $messages["gallery_files.$index"] = $this->uploadFailureMessage('تصویر گالری', $galleryFile->getError());
            }
        }

        if ($messages !== []) {
            throw ValidationException::withMessages($messages);
        }
    }

    private function uploadFailureMessage(string $label, int $errorCode): string
    {
        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => $label.' از محدودیت حجم تنظیم‌شده در PHP بیشتر است.',
            UPLOAD_ERR_PARTIAL => $label.' به صورت ناقص بارگذاری شد. دوباره تلاش کنید.',
            UPLOAD_ERR_NO_TMP_DIR => 'پوشه موقت آپلود PHP تنظیم نشده است. مقدار upload_tmp_dir را بررسی کنید.',
            UPLOAD_ERR_CANT_WRITE => 'PHP اجازه نوشتن در پوشه موقت آپلود را ندارد. دسترسی upload_tmp_dir را بررسی کنید.',
            UPLOAD_ERR_EXTENSION => 'یکی از افزونه‌های PHP جلوی آپلود فایل را گرفته است.',
            default => $label.' بارگذاری نشد. کد خطای PHP: '.$errorCode,
        };
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function applyUploadedImages(Request $request, array &$data, ?Product $product = null): void
    {
        if ($request->boolean('remove_featured_image') && $product?->featured_image) {
            $this->deleteStoredPublicAsset($product->featured_image);
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image_file')) {
            if ($product?->featured_image) {
                $this->deleteStoredPublicAsset($product->featured_image);
            }

            $data['featured_image'] = $this->storePublicImage($request->file('featured_image_file'));
        }

        $gallery = collect($product?->gallery ?? [])
            ->filter()
            ->values();

        $removeGalleryImages = collect($request->input('remove_gallery_images', []))
            ->filter()
            ->values();

        if ($removeGalleryImages->isNotEmpty()) {
            $gallery = $gallery
                ->reject(function (string $path) use ($removeGalleryImages): bool {
                    if ($removeGalleryImages->contains($path)) {
                        $this->deleteStoredPublicAsset($path);

                        return true;
                    }

                    return false;
                })
                ->values();
        }

        foreach ($request->file('gallery_files', []) as $file) {
            $gallery->push($this->storePublicImage($file));
        }

        $data['gallery'] = $gallery->isEmpty() ? null : $gallery->values()->all();
    }

    private function storePublicImage($file): string
    {
        return 'storage/'.$file->store('products', 'public');
    }

    private function deleteProductImages(Product $product): void
    {
        if ($product->featured_image) {
            $this->deleteStoredPublicAsset($product->featured_image);
        }

        foreach ($product->gallery ?? [] as $image) {
            $this->deleteStoredPublicAsset($image);
        }
    }

    private function deleteStoredPublicAsset(string $path): void
    {
        $relativePath = Str::after($path, 'storage/');

        if ($relativePath !== $path) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function uniqueSlug(string $title, ?Product $product = null): string
    {
        $base = Str::slug($title) ?: 'product';
        $slug = $base;
        $counter = 1;

        while (Product::query()
            ->where('slug', $slug)
            ->when($product, fn ($query) => $query->whereKeyNot($product->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * @return array<int, string>|null
     */
    private function linesToArray(?string $value): ?array
    {
        $items = collect(preg_split('/\r\n|\r|\n/', $value ?? '') ?: [])
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();

        return $items === [] ? null : $items;
    }

    /**
     * @return array<string, string>|null
     */
    private function keyValueLinesToArray(?string $value): ?array
    {
        $items = [];

        foreach (preg_split('/\r\n|\r|\n/', $value ?? '') ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            [$key, $itemValue] = array_pad(explode(':', $line, 2), 2, '');
            $key = trim($key);
            $itemValue = trim($itemValue);

            if ($key !== '' && $itemValue !== '') {
                $items[$key] = $itemValue;
            }
        }

        return $items === [] ? null : $items;
    }

    private function categories()
    {
        return ProductCategory::query()->ordered()->get(['id', 'title']);
    }
}
