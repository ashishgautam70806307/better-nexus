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
        return ["is_active" => "boolean", "show_video" => "boolean"];
    }
    public function images(): HasMany
    {
        return $this->hasMany(HomeHeroImage::class)
            ->orderBy("sort_order")
            ->orderBy("id");
    }
}
