<?php
if (!function_exists('site_setting')) {
    function site_setting(string $key, mixed $fallback=null): mixed {
        return app(\App\Support\SiteSettings::class)->get($key,$fallback);
    }
}
if (!function_exists('site_asset')) {
    function site_asset(string $key, ?string $fallback=null): ?string {
        return app(\App\Support\SiteSettings::class)->asset($key,$fallback);
    }
}
