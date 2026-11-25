<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use CleansUpFiles;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'image_path',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (Event $event) {
            static::deleteStoredFile($event->image_path);
        });

        static::updated(function (Event $event) {
            if ($event->wasChanged('image_path')) {
                static::deleteStoredFile($event->getOriginal('image_path'));
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Kegiatan yang belum selesai: kalau ada jam selesai, pakai itu,
     * kalau tidak pakai jam mulai. Yang sudah lewat otomatis tidak tampil.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query
            ->where(function (Builder $q) {
                $q->where('ends_at', '>=', now())
                    ->orWhere(function (Builder $q) {
                        $q->whereNull('ends_at')->where('starts_at', '>=', now());
                    });
            })
            ->orderBy('starts_at');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url($this->image_path);
    }

    /** Contoh: "Sabtu, 21 November 2026". */
    public function getStartDateAttribute(): string
    {
        return $this->starts_at->locale('id')->translatedFormat('l, j F Y');
    }

    /** Contoh: "19.00 WIB" atau "19.00 - 22.00 WIB". */
    public function getTimeRangeAttribute(): string
    {
        $start = $this->starts_at->format('H.i');

        return $this->ends_at
            ? "{$start} - {$this->ends_at->format('H.i')} WIB"
            : "{$start} WIB";
    }
}