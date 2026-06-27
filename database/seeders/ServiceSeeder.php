<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title' => 'تولید بیلت آلومینیوم', 'slug' => 'aluminum-billet-production', 'short_description' => 'تولید بیلت قابل اتکا برای خطوط اکستروژن.', 'description' => 'بیلت آلومینیوم با تمرکز بر یکنواختی سطح، ترکیب پایدار و قابلیت سفارش در ابعاد مختلف تولید و عرضه می‌شود.', 'icon' => 'factory', 'sort_order' => 1],
            ['title' => 'تولید شمش آلومینیوم', 'slug' => 'aluminum-ingot-production', 'short_description' => 'تولید شمش برای مصرف صنعتی و ریخته‌گری.', 'description' => 'فرایند تولید با تمرکز بر پایداری کیفیت، کنترل ترکیب و آماده‌سازی برای مصرف کارخانه‌ای انجام می‌شود.', 'icon' => 'supply', 'sort_order' => 2],
            ['title' => 'کنترل کیفیت و آنالیز', 'slug' => 'quality-control-analysis', 'short_description' => 'بررسی فنی محصول پیش از تحویل.', 'description' => 'امکان آماده‌سازی اطلاعات فنی، نمونه‌برداری و کنترل مشخصات محصول برای سفارش‌های صنعتی فراهم است.', 'icon' => 'quality', 'sort_order' => 3],
            ['title' => 'برش و بسته‌بندی', 'slug' => 'cutting-packaging', 'short_description' => 'آماده‌سازی محصول برای حمل و انبارش.', 'description' => 'برش، چیدمان و بسته‌بندی با توجه به نوع محصول، شرایط حمل و نیاز خریدار هماهنگ می‌شود.', 'icon' => 'package', 'sort_order' => 4],
            ['title' => 'حمل و ارسال', 'slug' => 'logistics-delivery', 'short_description' => 'کمک به برنامه‌ریزی تحویل سفارش.', 'description' => 'تیم فروش می‌تواند هماهنگی‌های لازم برای زمان‌بندی و تحویل سفارش را با مشتری انجام دهد.', 'icon' => 'delivery', 'sort_order' => 5],
            ['title' => 'مشاوره فنی', 'slug' => 'technical-consulting', 'short_description' => 'انتخاب گرید، محصول و شرایط تامین مناسب.', 'description' => 'برای انتخاب محصول، بررسی مشخصات فنی و برنامه‌ریزی همکاری بلندمدت، مشاوره تخصصی فروش و فنی ارائه می‌شود.', 'icon' => 'partnership', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service + ['is_active' => true, 'is_featured' => true]);
        }
    }
}
