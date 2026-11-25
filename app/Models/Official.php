<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use CleansUpFiles;

    protected $fillable = [
        'name',
        'position',
        'photo_path',
        'phone',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (Official $official) {
            static::deleteStoredFile($official->photo_path);
        });

        static::updated(function (Official $official) {
            if ($official->wasChanged('photo_path')) {
                static::deleteStoredFile($official->getOriginal('photo_path'));
            }
        });
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return static::storageUrl($this->photo_path);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}