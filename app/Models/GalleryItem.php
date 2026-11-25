<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    use CleansUpFiles;

    public const TYPE_PHOTO = 'photo';
    public const TYPE_VIDEO = 'video';

    protected $fillable = [
        'gallery_album_id',
        'type',
        'title',
        'description',
        'file_path',
        'video_url',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleted(function (GalleryItem $item) {
            static::deleteStoredFile($item->file_path);
        });

        // Ganti foto lewat form edit -> hapus file lama.
        static::updated(function (GalleryItem $item) {
            if ($item->wasChanged('file_path')) {
                static::deleteStoredFile($item->getOriginal('file_path'));
            }
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }

    public function getFileUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url($this->file_path);
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if ($this->type !== self::TYPE_VIDEO || ! $this->video_url) {
            return null;
        }

        $pattern = '~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~';

        return preg_match($pattern, $this->video_url, $m) ? $m[1] : null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id
            ? "https://www.youtube.com/embed/{$this->youtube_id}"
            : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->type === self::TYPE_PHOTO) {
            return $this->file_url;
        }

        return $this->youtube_id
            ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg"
            : null;
    }
}