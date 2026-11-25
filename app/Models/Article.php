<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use CleansUpFiles;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    public const CATEGORIES = [
        'berita' => 'Berita',
        'kegiatan' => 'Kegiatan',
        'budaya' => 'Budaya',
        'umkm' => 'UMKM',
        'pengumuman' => 'Pengumuman',
    ];

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draf',
        self::STATUS_PUBLISHED => 'Terbit',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image_path',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        // Artikel yang diterbitkan tanpa tanggal otomatis memakai waktu sekarang.
        static::saving(function (Article $article) {
            if ($article->status === self::STATUS_PUBLISHED && blank($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::deleted(function (Article $article) {
            static::deleteStoredFile($article->image_path);
        });

        static::updated(function (Article $article) {
            if ($article->wasChanged('image_path')) {
                static::deleteStoredFile($article->getOriginal('image_path'));
            }
        });
    }

    /** Hanya artikel berstatus terbit dan tanggalnya sudah tiba. */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->where('published_at', '<=', now());
    }

    public function scopeLatestPublished(Builder $query): Builder
    {
        return $query->published()->orderByDesc('published_at');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? Str::headline((string) $this->category);
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

    /** Tanggal terbit berbahasa Indonesia, mis. "18 November 2026". */
    public function getPublishedDateAttribute(): ?string
    {
        return $this->published_at?->locale('id')->translatedFormat('j F Y');
    }

    /**
     * Isi artikel siap tampil: HTML dari editor disaring dan URL gambar di dalamnya
     * diperbaiki. Hasilnya di-cache dan otomatis diperbarui saat artikel diubah.
     */
    public function getContentHtmlAttribute(): string
    {
        $key = "article.{$this->id}.html." . ($this->updated_at?->timestamp ?? 0);

        return Cache::remember($key, now()->addDay(), function (): string {
            return RichContentRenderer::make($this->content)
                ->fileAttachmentsDisk('s3')
                ->fileAttachmentsVisibility('public')
                ->toHtml();
        });
    }

    /** Judul untuk tag <title> dan Open Graph. */
    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description
            ?: ($this->excerpt ?: Str::limit(strip_tags((string) $this->content), 155));
    }
}