<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Blog extends Model
{
    protected $guarded = ["id"];
    protected function casts(): array
    {
        return ["is_published" => "boolean", "published_at" => "datetime"];
    }
    public function scopePublished(Builder $q): Builder
    {
        return $q
            ->where("is_published", true)
            ->where("published_at", "<=", now());
    }
    public function getImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset($this->featured_image) : null;
    }
}
