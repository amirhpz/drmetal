<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $definitions = $this->definitions();

        foreach ($definitions as $group) {
            foreach ($group['fields'] as $field) {
                SiteSetting::query()->firstOrCreate(
                    ['key' => $field['key']],
                    [
                        'value' => $field['default'] ?? '',
                        'group' => $group['key'],
                        'type' => $field['type'],
                    ],
                );
            }
        }

        return view('panel.settings.edit', [
            'definitions' => $definitions,
            'settings' => SiteSetting::query()->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $definitions = $this->definitions();
        $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string'],
        ]);

        $settings = $request->input('settings', []);

        foreach ($definitions as $group) {
            foreach ($group['fields'] as $field) {
                $currentValue = SiteSetting::query()->where('key', $field['key'])->value('value');

                SiteSetting::query()->updateOrCreate(
                    ['key' => $field['key']],
                    [
                        'value' => array_key_exists($field['key'], $settings) ? $settings[$field['key']] : ($currentValue ?? ''),
                        'group' => $group['key'],
                        'type' => $field['type'],
                    ],
                );
            }
        }

        return redirect()
            ->route('panel.settings.edit')
            ->with('success', 'تنظیمات سایت به‌روزرسانی شد.');
    }

    /**
     * @return array<int, array{key: string, title: string, description: string, fields: array<int, array{key: string, label: string, type: string, default?: string}>}>
     */
    private function definitions(): array
    {
        return [
            [
                'key' => 'company',
                'title' => 'برند و اطلاعات شرکت',
                'description' => 'نام برند، شعار، معرفی کوتاه و اطلاعات ثابت شرکت.',
                'fields' => [
                    ['key' => 'company.name', 'label' => 'نام فارسی شرکت', 'type' => 'text', 'default' => config('company.name_fa')],
                    ['key' => 'company.name_en', 'label' => 'نام انگلیسی شرکت', 'type' => 'text', 'default' => config('company.name_en')],
                    ['key' => 'company.legal_name', 'label' => 'نام حقوقی', 'type' => 'text', 'default' => config('company.legal_name_fa')],
                    ['key' => 'company.tagline', 'label' => 'شعار فارسی', 'type' => 'text', 'default' => config('company.slogan_fa')],
                    ['key' => 'company.tagline_en', 'label' => 'شعار انگلیسی', 'type' => 'text', 'default' => config('company.slogan_en')],
                    ['key' => 'company.website', 'label' => 'وب‌سایت', 'type' => 'text', 'default' => config('company.website')],
                    ['key' => 'company.short_description', 'label' => 'معرفی کوتاه', 'type' => 'textarea', 'default' => config('company.hero_description')],
                    ['key' => 'company.address', 'label' => 'آدرس', 'type' => 'textarea', 'default' => config('company.address')],
                ],
            ],
            [
                'key' => 'contact',
                'title' => 'راه‌های ارتباطی',
                'description' => 'شماره‌ها، ایمیل و ساعات پاسخ‌گویی.',
                'fields' => [
                    ['key' => 'contact.main_phone', 'label' => 'شماره اصلی', 'type' => 'text', 'default' => config('company.phone')],
                    ['key' => 'contact.sales_phone', 'label' => 'شماره فروش', 'type' => 'text', 'default' => config('company.phone')],
                    ['key' => 'contact.email', 'label' => 'ایمیل', 'type' => 'text'],
                    ['key' => 'contact.working_hours', 'label' => 'ساعات کاری', 'type' => 'text', 'default' => 'شنبه تا چهارشنبه، ۸:۰۰ تا ۱۷:۰۰'],
                ],
            ],
            [
                'key' => 'social',
                'title' => 'شبکه‌ها و پیام‌رسان‌ها',
                'description' => 'لینک‌های ارتباطی شبکه‌های اجتماعی.',
                'fields' => [
                    ['key' => 'social.whatsapp', 'label' => 'واتساپ', 'type' => 'text'],
                    ['key' => 'social.telegram', 'label' => 'تلگرام', 'type' => 'text'],
                    ['key' => 'social.instagram', 'label' => 'اینستاگرام', 'type' => 'text'],
                    ['key' => 'social.linkedin', 'label' => 'لینکدین', 'type' => 'text'],
                ],
            ],
            [
                'key' => 'seo',
                'title' => 'سئوی پیش‌فرض',
                'description' => 'متادیتای عمومی زمانی استفاده می‌شود که صفحه عنوان یا توضیح اختصاصی ندارد.',
                'fields' => [
                    ['key' => 'seo.default_title', 'label' => 'عنوان پیش‌فرض', 'type' => 'text', 'default' => 'صنایع متالورژی دکتر متال | Dr Metal Metallurgical Industries'],
                    ['key' => 'seo.default_description', 'label' => 'توضیح پیش‌فرض', 'type' => 'textarea', 'default' => 'دکتر متال، فعال در طراحی، تولید، بهینه‌سازی و تأمین محصولات و قطعات فلزی، آلومینیوم و فلزات رنگین با شعار پرتوی فناوری و دانش.'],
                ],
            ],
            [
                'key' => 'about',
                'title' => 'محتوای درباره ما',
                'description' => 'متن‌های اصلی صفحه درباره ما.',
                'fields' => [
                    ['key' => 'about.story', 'label' => 'معرفی شرکت', 'type' => 'textarea', 'default' => 'شرکت برتر فناوران راکا متشکل از تیمی متخصص، خوش‌فکر و پویا است که با نزدیک به یک دهه نام نیک در صنعت فلزات، با برند دکتر متال فعالیت می‌کند. این مجموعه در حوزه طراحی، تولید، بهینه‌سازی و تأمین محصولات و قطعات فلزی، به‌ویژه آلومینیوم و فلزات رنگین، فعالیت دارد.'],
                    ['key' => 'about.mission', 'label' => 'ماموریت', 'type' => 'textarea', 'default' => 'توسعه راهکارهای دانش‌پایه در طراحی، تولید و بهینه‌سازی محصولات فلزی با تمرکز بر فناوری، تخصص متالورژی و اعتماد صنعتی.'],
                    ['key' => 'about.vision', 'label' => 'چشم‌انداز', 'type' => 'textarea', 'default' => 'تبدیل شدن به مرجع قابل اعتماد در صنعت فلزات رنگین، آلومینیوم و قطعات صنعتی دانش‌پایه.'],
                ],
            ],
        ];
    }
}
