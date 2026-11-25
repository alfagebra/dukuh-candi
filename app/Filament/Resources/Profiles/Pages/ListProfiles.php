<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Filament\Resources\Pages\ListRecords;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    /**
     * Karena profil cuma satu baris, menu "Profil Dukuh" langsung
     * membuka form edit (atau form buat kalau datanya belum ada).
     */
    public function mount(): void
    {
        parent::mount();

        $profile = Profile::current();

        $this->redirect(
            $profile
                ? ProfileResource::getUrl('edit', ['record' => $profile])
                : ProfileResource::getUrl('create')
        );
    }
}