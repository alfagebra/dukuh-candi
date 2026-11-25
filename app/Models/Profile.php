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

    /** Profil dukuh hanya satu baris. */
    public static function current(): ?self
    {
        return static::query()->first();
    }

    /**
     * Profil untuk website publik, disimpan di cache beberapa menit supaya
     * tiap halaman tidak perlu query ke database. Kalau database bermasalah,
     * mengembalikan null agar halaman tetap bisa tampil.
     */
    public static function cached(): ?self
    {
        try {
            return Cache::remember('site.profile', now()->addMinutes(10), fn () => static::current());
        } catch (Throwable $e) {
            // Cache bermasalah: ambil langsung dari database.
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

    /** Link WhatsApp siap pakai (08xx otomatis jadi 628xx). */
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

    /**
     * Kolom ini boleh diisi dengan kode HTML sematan dari Google Maps
     * (<iframe ... src="...">) atau langsung URL-nya. Yang disimpan hanya URL-nya.
     */
    public function setMapEmbedAttribute(?string $value): void
    {
        $value = trim((string) $value);

        if ($value !== '' && preg_match('~src=["\']([^"\']+)["\']~i', $value, $matches)) {
            $value = html_entity_decode($matches[1]);
        }

        $this->attributes['map_embed'] = $value !== '' ? $value : null;
    }

    /**
     * URL peta untuk iframe. Urutan pilihan:
     * 1. kode sematan Google Maps (kolom map_embed),
     * 2. link "embed" yang ditempel di kolom link peta,
     * 3. koordinat (latitude dan longitude),
     * 4. alamat.
     * Kalau semuanya kosong, tidak ada peta yang ditampilkan.
     */
    public function getMapEmbedUrlAttribute(): ?string
    {
        foreach ([$this->map_embed, $this->map_url] as $candidate) {
            // Hanya sematan resmi Google Maps yang dipakai di iframe.
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