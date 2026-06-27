<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = ProductCategory::query()->pluck('id', 'slug');

        $products = [
            [
                'product_category_id' => $categoryIds['aluminum-billets'] ?? null,
                'title' => 'بیلت آلومینیوم 6063',
                'slug' => 'aluminum-billet-6063',
                'short_description' => 'بیلت مناسب خطوط اکستروژن پروفیل‌های ساختمانی و صنعتی.',
                'description' => 'بیلت آلومینیوم 6063 برای کاربردهای اکستروژن با تمرکز بر سطح یکنواخت، کیفیت پایدار و قابلیت سفارش در ابعاد مختلف عرضه می‌شود.',
                'specifications' => ['آلیاژ' => '6063', 'کاربرد' => 'اکستروژن', 'بسته‌بندی' => 'صنعتی / صادراتی'],
                'applications' => ['اکستروژن', 'پروفیل ساختمانی', 'صنایع عمومی'],
                'grade' => '6063',
                'dimensions' => 'قابل سفارش',
                'packaging' => 'بسته‌بندی صنعتی',
                'minimum_order_quantity' => 'بر اساس توافق',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'product_category_id' => $categoryIds['aluminum-billets'] ?? null,
                'title' => 'بیلت آلومینیوم 6061',
                'slug' => 'aluminum-billet-6061',
                'short_description' => 'بیلت آلیاژی برای قطعات و پروفیل‌هایی که مقاومت مکانیکی بالاتری نیاز دارند.',
                'description' => 'بیلت 6061 برای سفارش‌های صنعتی با نیاز به کنترل دقیق ترکیب، آنالیز فنی و بسته‌بندی استاندارد ارائه می‌شود.',
                'specifications' => ['آلیاژ' => '6061', 'کاربرد' => 'سازه‌ای / صنعتی', 'استاندارد' => 'بر اساس سفارش'],
                'applications' => ['خودروسازی', 'سازه‌های صنعتی', 'اکستروژن'],
                'grade' => '6061',
                'dimensions' => 'قابل سفارش',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'product_category_id' => $categoryIds['aluminum-billets'] ?? null,
                'title' => 'بیلت آلومینیوم 6082',
                'slug' => 'aluminum-billet-6082',
                'short_description' => 'بیلت آلیاژی مقاوم برای کاربردهای فنی و صنعتی سنگین‌تر.',
                'description' => 'بیلت 6082 برای تولید قطعات صنعتی، پروفیل‌های مقاوم و کاربردهایی که استحکام اهمیت دارد قابل تامین است.',
                'specifications' => ['آلیاژ' => '6082', 'کاربرد اصلی' => 'اکستروژن مقاوم', 'بسته‌بندی' => 'صنعتی'],
                'applications' => ['پروفیل صنعتی', 'سازه', 'ماشین‌آلات'],
                'grade' => '6082',
                'dimensions' => 'قابل سفارش',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'product_category_id' => $categoryIds['aluminum-ingots'] ?? null,
                'title' => 'شمش آلومینیوم A7',
                'slug' => 'aluminum-ingot-a7',
                'short_description' => 'شمش آلومینیوم با خلوص 99.7 درصد برای مصرف ریخته‌گری و صنعتی.',
                'description' => 'شمش A7 برای سفارش‌های عمده و تامین منظم صنایع ریخته‌گری، قطعه‌سازی و تولیدکنندگان مواد اولیه عرضه می‌شود.',
                'specifications' => ['گرید' => 'A7', 'خلوص' => '99.7٪', 'وزن' => 'استاندارد / قابل هماهنگی'],
                'applications' => ['ریخته‌گری', 'قطعه‌سازی', 'صنایع عمومی'],
                'grade' => 'A7',
                'purity' => '99.7٪',
                'weight' => 'استاندارد',
                'minimum_order_quantity' => 'بر اساس توافق',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'product_category_id' => $categoryIds['aluminum-ingots'] ?? null,
                'title' => 'شمش آلومینیوم A8',
                'slug' => 'aluminum-ingot-a8',
                'short_description' => 'شمش آلومینیوم با سطح یکنواخت و کیفیت پایدار برای مصرف صنعتی.',
                'description' => 'شمش A8 برای مشتریانی مناسب است که به تامین قابل اتکا، بسته‌بندی استاندارد و هماهنگی تحویل نیاز دارند.',
                'specifications' => ['گرید' => 'A8', 'بسته‌بندی' => 'صنعتی / صادراتی', 'کنترل کیفیت' => 'آنالیز فنی'],
                'applications' => ['ریخته‌گری', 'مواد اولیه کارخانه‌ها', 'صادرات'],
                'grade' => 'A8',
                'purity' => 'خلوص بالا',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'product_category_id' => $categoryIds['aluminum-ingots'] ?? null,
                'title' => 'شمش آلومینیوم A9',
                'slug' => 'aluminum-ingot-a9',
                'short_description' => 'شمش گرید ویژه برای سفارش‌های صنعتی حساس و برنامه‌های تامین صادراتی.',
                'description' => 'شمش A9 به عنوان گزینه‌ای ویژه برای مشتریان عمده و صنایع نیازمند کیفیت بالاتر و مستندسازی فنی قابل ارائه است.',
                'specifications' => ['گرید' => 'A9', 'کاربرد' => 'صنایع حساس', 'بسته‌بندی' => 'صادراتی'],
                'applications' => ['صنایع حساس', 'صادرات', 'تولید مواد اولیه'],
                'grade' => 'A9',
                'purity' => 'خلوص ویژه',
                'is_featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                $product + ['featured_image' => 'image/product.png', 'is_active' => true]
            );
        }
    }
}
