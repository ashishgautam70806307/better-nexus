<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class HomeHero extends Model
{
    protected $table = "home_heroes";
    protected $guarded = ["id"];
    protected function casts(): array
    {
        return ["is_active" => "boolean", "show_video" => "boolean", "desktop_video_published" => "boolean", "mobile_video_published" => "boolean"];
    }
    public static function isVideoUploadPath(?string $path): bool
    {
        return $path !== null && preg_match('~^home-hero-videos/[a-f0-9]{32}\.(mp4|webm)$~D', $path) === 1;
    }

    public function images(): HasMany
    {
        return $this->hasMany(HomeHeroImage::class)
            ->orderBy("sort_order")
            ->orderBy("id");
    }
}
