<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['title' => 'شمش آلومینیوم', 'slug' => 'aluminum-ingots', 'description' => 'شمش‌های آلومینیومی برای مصرف صنعتی و ریخته‌گری.', 'sort_order' => 1],
            ['title' => 'بیلت آلومینیوم', 'slug' => 'aluminum-billets', 'description' => 'بیلت‌های آلومینیومی مناسب صنایع اکستروژن و تولید پروفیل.', 'sort_order' => 2],
            ['title' => 'آلیاژهای آلومینیوم', 'slug' => 'aluminum-alloys', 'description' => 'محصولات آلیاژی بر اساس نیاز فنی سفارش.', 'sort_order' => 3],
            ['title' => 'تامین صنعتی سفارشی', 'slug' => 'custom-industrial-supply', 'description' => 'تامین برنامه‌ریزی‌شده مواد اولیه برای مشتریان B2B.', 'sort_order' => 4],
        ];

        foreach ($categories as $category) {
            ProductCategory::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }
    }
}
