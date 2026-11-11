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
    public function scopePublicInsights(Builder $query): Builder
    {
        return $query->published()
            ->whereRaw("LOWER(TRIM(COALESCE(category, ''))) NOT IN (?, ?)", [
                'engineering services', 'engineering support',
            ]);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset($this->featured_image) : null;
    }
    /**
     * Local fallback for articles without an uploaded cover. Pick a stable
     * editorial photograph per slug so the blog grid is not one repeated image.
     * Uploaded editorial images always take precedence.
     */
    public function getDisplayImageUrlAttribute(): string
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        $photographs = [
            'better-nexus/assets/images/editorial/office-3184303.jpg',
            'better-nexus/assets/images/editorial/office-3184321.jpg',
            'better-nexus/assets/images/editorial/office-3184342.jpg',
            'better-nexus/assets/images/editorial/office-3184298.jpg',
            'better-nexus/assets/images/editorial/office-3184361.jpg',
            'better-nexus/assets/images/editorial/office-3184315.jpg',
            'better-nexus/assets/images/editorial/office-3184324.jpg',
            'better-nexus/assets/images/editorial/office-3184311.jpg',
            'better-nexus/assets/images/editorial/office-3184349.jpg',
            'better-nexus/assets/images/editorial/office-3184405.jpg',
            'better-nexus/assets/images/editorial/office-3184320.jpg',
            'better-nexus/assets/images/editorial/office-3184346.jpg',
        ];

        return asset($photographs[(int) ($this->id ?: crc32((string) $this->slug)) % count($photographs)]);
    }

}
