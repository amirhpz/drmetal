<?php

namespace App\Support;

use App\Models\SiteSetting;

class SiteSettings
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return SiteSetting::getValue($key, $default);
    }

    public static function group(string $group): array
    {
        return SiteSetting::getGroup($group);
    }
}
