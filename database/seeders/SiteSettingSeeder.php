<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company.name', 'value' => 'صنایع متالورژی دکتر متال', 'group' => 'company', 'type' => 'text'],
            ['key' => 'company.tagline', 'value' => 'پرتوی فناوری و دانش', 'group' => 'company', 'type' => 'text'],
            ['key' => 'company.short_description', 'value' => 'دکتر متال با تکیه بر دانش تخصصی، تجربه صنعتی و فناوری‌های نوین، در زمینه طراحی، تولید و بهینه‌سازی محصولات آلومینیومی و فلزات رنگین فعالیت می‌کند.', 'group' => 'company', 'type' => 'textarea'],
            ['key' => 'company.address', 'value' => 'شهرک صنعتی عباس‌آباد، مولوی جنوبی، خیابان ۱۰/۷، پلاک ۵۷۳', 'group' => 'company', 'type' => 'textarea'],
            ['key' => 'contact.main_phone', 'value' => '+۹۱۲۶۵۹۱۶۰۱۰', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.sales_phone', 'value' => '+۹۱۲۶۵۹۱۶۰۱۰', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.email', 'value' => '', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact.working_hours', 'value' => 'شنبه تا چهارشنبه، ۸:۰۰ تا ۱۷:۰۰', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'social.whatsapp', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social.telegram', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'seo.default_title', 'value' => 'صنایع متالورژی دکتر متال | Dr Metal Metallurgical Industries', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'seo.default_description', 'value' => 'دکتر متال، فعال در طراحی، تولید، بهینه‌سازی و تأمین محصولات و قطعات فلزی، آلومینیوم و فلزات رنگین با شعار پرتوی فناوری و دانش.', 'group' => 'seo', 'type' => 'textarea'],
            ['key' => 'about.mission', 'value' => 'توسعه راهکارهای دانش‌پایه در طراحی، تولید و بهینه‌سازی محصولات فلزی با تمرکز بر فناوری، تخصص متالورژی و اعتماد صنعتی.', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about.vision', 'value' => 'تبدیل شدن به مرجع قابل اعتماد در صنعت فلزات رنگین، آلومینیوم و قطعات صنعتی دانش‌پایه.', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about.story', 'value' => 'شرکت برتر فناوران راکا متشکل از تیمی متخصص، خوش‌فکر و پویا است که با نزدیک به یک دهه نام نیک در صنعت فلزات، با برند دکتر متال فعالیت می‌کند. این مجموعه در حوزه طراحی، تولید، بهینه‌سازی و تأمین محصولات و قطعات فلزی، به‌ویژه آلومینیوم و فلزات رنگین، فعالیت دارد.', 'group' => 'about', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
