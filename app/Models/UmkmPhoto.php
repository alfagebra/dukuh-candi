<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmPhoto extends Model
{
    use CleansUpFiles;

    protected $fillable = [
        'umkm_id',
        'photo_path',
        'caption',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleted(function (UmkmPhoto $photo) {
            static::deleteStoredFile($photo->photo_path);
        });

        static::updated(function (UmkmPhoto $photo) {
            if ($photo->wasChanged('photo_path')) {
                static::deleteStoredFile($photo->getOriginal('photo_path'));
            }
        });
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return static::storageUrl($this->photo_path);
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }
}