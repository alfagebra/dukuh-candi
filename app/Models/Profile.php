<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Profile extends Model
{
    use CleansUpFiles;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'history',
        'vision',
        'mission',
        'address',
        'phone',
        'whatsapp',
        'email',
        'map_url',
        'map_embed',
        'latitude',
        'longitude',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
        'population',
        'households',
        'area_hectares',
        'logo_path',
        'cover_image_path',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'population' => 'integer',
            'households' => 'integer',
            'area_hectares' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.profile'));
        static::deleted(fn () => Cache::forget('site.profile'));

        static::updated(function (Profile $profile) {
            foreach (['logo_path', 'cover_image_path'] as $column) {
                if ($profile->wasChanged($column)) {
                    static::deleteStoredFile($profile->getOriginal($column));
                }
            }
        });
    }

    public static function current(): ?self
    {
        return static::query()->first();
    }

    public static function cached(): ?self
    {
        try {
            return Cache::remember('site.profile', now()->addMinutes(10), fn () => static::current());
        } catch (Throwable $e) {
            report($e);
        }

        try {
            return static::current();
        } catch (Throwable $e) {
            report($e);

            return null;
        }
    }

    public function getLogoUrlAttribute(): ?string
    {
        return static::storageUrl($this->logo_path);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return static::storageUrl($this->cover_image_path);
    }

    /**
     * Foto untuk section "Mengenal Dukuh".
     * Kalau kolom about_image_path belum ada, pakai foto cover dari Profil Dukuh.
     */
    public function getAboutImageUrlAttribute(): ?string
    {
        return static::storageUrl($this->about_image_path ?? null) ?: $this->cover_image_url;
    }

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

    public function setMapEmbedAttribute(?string $value): void
    {
        $value = trim((string) $value);

        if ($value !== '' && preg_match('~src=["\']([^"\']+)["\']~i', $value, $matches)) {
            $value = html_entity_decode($matches[1]);
        }

        $this->attributes['map_embed'] = $value !== '' ? $value : null;
    }

    public function getMapEmbedUrlAttribute(): ?string
    {
        foreach ([$this->map_embed, $this->map_url] as $candidate) {
            if ($candidate && str_starts_with($candidate, 'https://www.google.com/maps/embed')) {
                return $candidate;
            }
        }

        if ($this->latitude !== null && $this->longitude !== null) {
            return 'https://maps.google.com/maps?q=' . $this->latitude . ',' . $this->longitude . '&z=16&output=embed';
        }

        if (filled($this->address)) {
            $address = str_replace(["\r\n", "\n"], ', ', trim($this->address));

            return 'https://maps.google.com/maps?q=' . rawurlencode($address) . '&z=15&output=embed';
        }

        return null;
    }
}