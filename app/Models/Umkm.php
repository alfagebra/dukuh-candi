<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    use CleansUpFiles;

    protected $fillable = [
        'name',
        'owner_name',
        'category',
        'description',
        'price_range',
        'address',
        'phone',
        'whatsapp',
        'instagram',
        'image_path',
        'map_url',
        'slug',
        'sort_order',
        'is_featured',
        'is_published',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Umkm $umkm) {
            $umkm->photos()->each(fn (UmkmPhoto $photo) => $photo->delete());
        });

        static::deleted(function (Umkm $umkm) {
            static::deleteStoredFile($umkm->image_path);
        });

        static::updated(function (Umkm $umkm) {
            if ($umkm->wasChanged('image_path')) {
                static::deleteStoredFile($umkm->getOriginal('image_path'));
            }
        });
    }

    public function photos(): HasMany
    {
        return $this->hasMany(UmkmPhoto::class)
            ->orderBy('sort_order');
    }

    /** UMKM yang tampil di website publik. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getImageUrlAttribute(): ?string
    {
        return static::storageUrl($this->image_path);
    }

    /** Link Instagram: menerima @username atau URL lengkap. */
    public function getInstagramUrlAttribute(): ?string
    {
        $value = trim((string) $this->instagram);

        if ($value === '') {
            return null;
        }

        if (preg_match('~^https?://~i', $value)) {
            return $value;
        }

        return 'https://instagram.com/' . ltrim($value, '@/');
    }

    /** Link WhatsApp siap pakai (nomor 08xx otomatis jadi 628xx). */
    public function getWhatsappUrlAttribute(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $this->whatsapp);

        if ($number === '') {
            return null;
        }

        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        return "https://wa.me/{$number}";
    }
}