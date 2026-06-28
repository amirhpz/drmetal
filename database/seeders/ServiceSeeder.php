<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::query()
            ->whereIn('slug', [
                'aluminum-billet-production',
                'aluminum-ingot-production',
                'quality-control-analysis',
                'cutting-packaging',
                'logistics-delivery',
                'technical-consulting',
            ])
            ->update(['is_active' => false, 'is_featured' => false]);

        $services = [
            ['title' => 'طراحی، تولید و بهینه‌سازی شمش آلیاژی آلومینیوم', 'slug' => 'aluminum-alloy-ingot-design-production', 'short_description' => 'شمش آلیاژی آلومینیوم در رده‌های خشک و نرم.', 'description' => 'طراحی، تولید و بهینه‌سازی شمش آلیاژی آلومینیوم در رده‌های خشک و نرم با روش‌های روز دنیا و شیوه دانش‌پایه.', 'icon' => 'factory', 'sort_order' => 1],
            ['title' => 'طراحی و تولید قطعات آلومینیومی دایکاست', 'slug' => 'aluminum-die-cast-parts', 'short_description' => 'تولید قطعات آلومینیومی به روش دایکاست.', 'description' => 'طراحی و تولید قطعات آلومینیومی به روش دایکاست برای نیازهای صنعتی و تولیدی.', 'icon' => 'quality', 'sort_order' => 2],
            ['title' => 'طراحی و تولید ورق آلومینیومی', 'slug' => 'aluminum-sheet-design-production', 'short_description' => 'تولید و تأمین ورق آلومینیومی.', 'description' => 'طراحی و تولید ورق آلومینیومی با تمرکز بر کیفیت، کاربرد صنعتی و نیاز فنی مشتری.', 'icon' => 'package', 'sort_order' => 3],
            ['title' => 'خرید و فروش فلزات رنگین', 'slug' => 'non-ferrous-metals-trading', 'short_description' => 'تأمین آلومینیوم، مس و سایر فلزات رنگین.', 'description' => 'خرید و فروش انواع فلزات رنگین، خصوصاً آلومینیوم و مس، با رویکرد تخصصی، شفاف و قابل اتکا.', 'icon' => 'supply', 'sort_order' => 4],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service + ['is_active' => true, 'is_featured' => true]);
        }
    }
}
