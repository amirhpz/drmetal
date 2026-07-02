<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'نقش کنترل ترکیب شیمیایی در کیفیت شمش آلیاژی آلومینیوم',
                'slug' => 'chemical-composition-control-aluminum-alloy-ingot',
                'excerpt' => 'کنترل ترکیب شیمیایی یکی از عوامل کلیدی در دستیابی به کیفیت پایدار در تولید شمش آلیاژی آلومینیوم است.',
                'body' => 'در تولید شمش آلیاژی آلومینیوم، شناخت دقیق نیاز کاربردی و کنترل عناصر آلیاژی نقش مهمی در پایداری کیفیت محصول دارد. انتخاب مواد اولیه، پایش فرایند ذوب و ثبت داده‌های کنترل کیفیت به تصمیم‌گیری بهتر در زنجیره تولید کمک می‌کند.',
                'category' => 'آلومینیوم',
                'sort_order' => 1,
            ],
            [
                'title' => 'دایکاست آلومینیوم و اهمیت طراحی قطعه در تولید صنعتی',
                'slug' => 'aluminum-die-casting-part-design',
                'excerpt' => 'در تولید قطعات دایکاست، طراحی درست قطعه و قالب می‌تواند کیفیت نهایی و تکرارپذیری تولید را بهبود دهد.',
                'body' => 'فرایند دایکاست آلومینیوم زمانی نتیجه قابل اتکا دارد که طراحی قطعه، انتخاب آلیاژ، شرایط قالب و کنترل فرایند همزمان دیده شوند. این نگاه یکپارچه باعث کاهش دوباره‌کاری و افزایش پایداری تولید می‌شود.',
                'category' => 'دایکاست',
                'sort_order' => 2,
            ],
            [
                'title' => 'فلزات رنگین در صنایع تولیدی و اهمیت تأمین قابل اتکا',
                'slug' => 'non-ferrous-metals-industrial-supply',
                'excerpt' => 'آلومینیوم، مس و سایر فلزات رنگین در بسیاری از صنایع تولیدی نقش پایه‌ای دارند و تأمین پایدار آن‌ها اهمیت بالایی دارد.',
                'body' => 'تأمین فلزات رنگین برای واحدهای صنعتی تنها خرید ماده اولیه نیست. شناخت بازار، کیفیت، شرایط حمل، زمان‌بندی تحویل و نیاز فنی مشتری همگی در شکل‌گیری یک همکاری پایدار نقش دارند.',
                'category' => 'فلزات رنگین',
                'sort_order' => 3,
            ],
            [
                'title' => 'چرا مستندسازی فنی در همکاری‌های متالورژی اهمیت دارد؟',
                'slug' => 'technical-documentation-metallurgy-cooperation',
                'excerpt' => 'مستندسازی مشخصات فنی و الزامات سفارش، مسیر همکاری صنعتی را شفاف‌تر و قابل پیگیری‌تر می‌کند.',
                'body' => 'در همکاری‌های صنعتی، توافق دقیق روی مشخصات فنی، کاربرد محصول، شرایط بسته‌بندی و معیارهای پذیرش باعث کاهش ابهام و افزایش اعتماد میان تأمین‌کننده و مشتری می‌شود.',
                'category' => 'دانش فنی',
                'sort_order' => 4,
            ],
        ];

        $categoryIds = PostCategory::query()->pluck('id', 'title');

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => $post['slug']],
                $post + [
                    'post_category_id' => $categoryIds->get($post['category']),
                    'author_name' => 'تیم دکتر متال',
                    'published_at' => now(),
                    'is_featured' => true,
                    'is_active' => true,
                    'meta_title' => $post['title'].' | دکتر متال',
                    'meta_description' => $post['excerpt'],
                ],
            );
        }
    }
}
