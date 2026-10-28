<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Support\SiteSettings;
class WebsiteSettingsServiceProvider extends ServiceProvider {
    public function register(): void {
        require_once app_path('Support/site_helpers.php');
        // One instance per request, including on long-running workers.
        $this->app->scoped(SiteSettings::class, fn()=>new SiteSettings);
    }
}
