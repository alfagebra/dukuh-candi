<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'documentation_date',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'documentation_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // cascadeOnDelete di database tidak memicu event model,
        // jadi item dihapus lewat model agar file di storage ikut terhapus.
        static::deleting(function (GalleryAlbum $album) {
            $album->items()->each(fn (GalleryItem $item) => $item->delete());
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'gallery_album_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Cover album = item pertama (foto lebih diutamakan, video pakai thumbnail YouTube).
     */
    public function getCoverUrlAttribute(): ?string
    {
        $item = $this->items->firstWhere('type', 'photo') ?? $this->items->first();

        return $item?->thumbnail_url;
    }
}