<?php

namespace App\Models\Concerns;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait CleansUpFiles
{
    /**
     * Hapus file dari bucket s3. Kegagalan hanya dicatat di log
     * supaya data tetap bisa dihapus/diubah walaupun storage bermasalah.
     */
    protected static function deleteStoredFile(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        try {
            Storage::disk('s3')->delete($path);
        } catch (Throwable $e) {
            report($e);
        }
    }

    /** URL publik file di bucket s3 (null kalau path kosong). */
    protected static function storageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url($path);
    }
}