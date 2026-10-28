<?php
namespace App\Support;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
class SiteSettings {
    private ?array $values=null;
    public function get(string $key, mixed $fallback=null): mixed {
        if ($this->values===null) {
            $defaults=[];
            foreach(config('website-settings',[]) as $fields) {
                foreach($fields as $name=>$definition) $defaults[$name]=$definition[1];
            }
            // Defaults keep pages available before the first settings migration.
            $defaults['phone_primary']=config('better-nexus.phone_primary','');
            $defaults['phone_secondary']=config('better-nexus.phone_secondary','');
            $stored=Schema::hasTable('website_settings') ? Cache::remember('bn.website-settings.v1',3600,fn()=>WebsiteSetting::pluck('value','key')->all()) : [];
            $this->values=array_replace($defaults,$stored);
        }
        return array_key_exists($key,$this->values) ? $this->values[$key] : $fallback;
    }
    public function asset(string $key, ?string $fallback=null): ?string {
        $path=$this->get($key);
        return $path ? asset($path) : ($fallback ? asset($fallback) : null);
    }
    public function forget(): void { Cache::forget('bn.website-settings.v1'); $this->values=null; }
}
