<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PanelProductManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $panelUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->panelUser = User::factory()->create(['is_panel_user' => true]);
    }

    public function test_panel_user_can_create_product_category(): void
    {
        $this->actingAs($this->panelUser)
            ->post(route('panel.product-categories.store'), [
                'title' => 'شمش آلومینیوم',
                'slug' => 'aluminum-ingots',
                'description' => 'دسته‌بندی محصولات شمش',
                'sort_order' => 10,
                'is_active' => '1',
            ])
            ->assertRedirect(route('panel.product-categories.index'));

        $this->assertDatabaseHas('product_categories', [
            'slug' => 'aluminum-ingots',
            'is_active' => true,
        ]);
    }

    public function test_panel_user_can_create_product(): void
    {
        Storage::fake('public');

        $category = ProductCategory::query()->create([
            'title' => 'شمش آلومینیوم',
            'slug' => 'aluminum-ingots',
            'is_active' => true,
        ]);

        $this->actingAs($this->panelUser)
            ->post(route('panel.products.store'), [
                'product_category_id' => $category->id,
                'title' => 'شمش آلومینیوم ۹۹.۷',
                'slug' => 'aluminum-ingot-997',
                'short_description' => 'شمش مناسب مصرف صنعتی',
                'description' => 'محصول تولیدی برای صنایع پایین‌دستی.',
                'grade' => '99.7',
                'applications_text' => "ریخته‌گری\nقطعه‌سازی",
                'specifications_text' => "Purity: 99.7\nUnit: Ton",
                'featured_image_file' => UploadedFile::fake()->image('ingot.jpg', 900, 600),
                'gallery_files' => [
                    UploadedFile::fake()->image('gallery-1.jpg', 900, 600),
                    UploadedFile::fake()->image('gallery-2.jpg', 900, 600),
                ],
                'is_active' => '1',
                'is_featured' => '1',
                'sort_order' => 5,
            ])
            ->assertRedirect(route('panel.products.index'));

        $product = Product::query()->where('slug', 'aluminum-ingot-997')->firstOrFail();

        $this->assertTrue($product->is_active);
        $this->assertTrue($product->is_featured);
        $this->assertSame(['ریخته‌گری', 'قطعه‌سازی'], $product->applications);
        $this->assertSame('99.7', $product->specifications['Purity']);
        $this->assertStringStartsWith('storage/products/', $product->featured_image);
        $this->assertCount(2, $product->gallery);

        Storage::disk('public')->assertExists(str_replace('storage/', '', $product->featured_image));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $product->gallery[0]));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $product->gallery[1]));
    }

    public function test_panel_user_can_replace_and_remove_product_images(): void
    {
        Storage::fake('public');

        $oldFeatured = UploadedFile::fake()->image('old.jpg')->store('products', 'public');
        $oldGallery = UploadedFile::fake()->image('old-gallery.jpg')->store('products', 'public');

        $product = Product::query()->create([
            'title' => 'شمش تست',
            'slug' => 'test-ingot',
            'featured_image' => 'storage/'.$oldFeatured,
            'gallery' => ['storage/'.$oldGallery],
            'is_active' => true,
        ]);

        $this->actingAs($this->panelUser)
            ->put(route('panel.products.update', $product), [
                'title' => 'شمش تست',
                'slug' => 'test-ingot',
                'featured_image_file' => UploadedFile::fake()->image('new.jpg'),
                'remove_gallery_images' => ['storage/'.$oldGallery],
            ])
            ->assertRedirect(route('panel.products.index'));

        $product->refresh();

        Storage::disk('public')->assertMissing($oldFeatured);
        Storage::disk('public')->assertMissing($oldGallery);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $product->featured_image));
        $this->assertNull($product->gallery);
    }
}
