<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company.name', 'value' => 'دکتر متالینیوم', 'group' => 'company', 'type' => 'text'],
            ['key' => 'company.tagline', 'value' => 'تولیدکننده بیلت و شمش آلومینیوم', 'group' => 'company', 'type' => 'text'],
            ['key' => 'company.short_description', 'value' => 'دکتر متالینیوم با تکیه بر فناوری روز، دانش فنی و تیم متخصص، محصولاتی با کیفیت بالا و مطابق با استانداردهای بین‌المللی تولید و عرضه می‌کند.', 'group' => 'company', 'type' => 'textarea'],
            ['key' => 'company.address', 'value' => 'اصفهان، شهرک صنعتی جی، خیابان پنجم، بلوار صنعتگران، پلاک ۲۷', 'group' => 'company', 'type' => 'textarea'],
            ['key' => 'contact.main_phone', 'value' => '031-33346678', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.sales_phone', 'value' => '0913-123-4567', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.email', 'value' => 'info@drmetalinium.com', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.working_hours', 'value' => 'شنبه تا چهارشنبه، ۸:۰۰ تا ۱۷:۰۰', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'social.whatsapp', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social.telegram', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'seo.default_title', 'value' => 'دکتر متالینیوم | تولیدکننده بیلت و شمش آلومینیوم', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'seo.default_description', 'value' => 'وب‌سایت شرکتی تولید و تامین شمش آلومینیوم، محصولات آلیاژی، خدمات کنترل کیفیت و تامین صنعتی.', 'group' => 'seo', 'type' => 'textarea'],
            ['key' => 'about.mission', 'value' => 'تولید و تامین محصولات آلومینیومی قابل اتکا برای مشتریان صنعتی با تمرکز بر کیفیت، شفافیت و استمرار تامین.', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about.vision', 'value' => 'تبدیل شدن به تامین‌کننده‌ای قابل اعتماد در زنجیره تامین آلومینیوم منطقه‌ای.', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about.story', 'value' => 'دکتر متالینیوم با هدف تامین نیاز صنایع داخلی به فلزات پایه، مسیر رشد پایدار را دنبال کرده است. تمرکز ما بر کیفیت محصول، بهبود مداوم فرایندها و ایجاد ارزش برای مشتریان صنعتی است.', 'group' => 'about', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
