<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    // Tanpa tombol hapus: profil dukuh tidak boleh terhapus.
    protected function getHeaderActions(): array
    {
        return [];
    }
}