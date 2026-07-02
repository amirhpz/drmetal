<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'title' => 'آلومینیوم',
                'slug' => 'aluminum',
                'description' => 'مقاله‌ها و یادداشت‌های فنی مرتبط با آلومینیوم و آلیاژهای آن.',
                'sort_order' => 1,
            ],
            [
                'title' => 'دایکاست',
                'slug' => 'die-casting',
                'description' => 'مطالب مرتبط با طراحی، تولید و کنترل فرایند قطعات دایکاست.',
                'sort_order' => 2,
            ],
            [
                'title' => 'فلزات رنگین',
                'slug' => 'non-ferrous-metals',
                'description' => 'محتوای آموزشی و خبری درباره تأمین و کاربرد فلزات رنگین.',
                'sort_order' => 3,
            ],
            [
                'title' => 'دانش فنی',
                'slug' => 'technical-knowledge',
                'description' => 'نکته‌ها و یادداشت‌های کاربردی برای همکاری‌های صنعتی و متالورژی.',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            PostCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category + [
                    'is_active' => true,
                    'meta_title' => $category['title'].' | دکتر متال',
                    'meta_description' => $category['description'],
                ],
            );
        }
    }
}
