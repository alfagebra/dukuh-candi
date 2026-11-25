<?php

namespace App\Filament\Resources\Umkms\Pages;

use App\Filament\Resources\Umkms\UmkmResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Concerns\RedirectsToIndex;

class CreateUmkm extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = UmkmResource::class;
}
