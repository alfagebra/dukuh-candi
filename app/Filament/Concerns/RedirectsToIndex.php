<?php

namespace App\Filament\Concerns;

trait RedirectsToIndex
{
    /**
     * Setelah form disimpan, kembali ke tabel daftar data
     * (bukan tetap di halaman edit).
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResourceUrl('index');
    }
}