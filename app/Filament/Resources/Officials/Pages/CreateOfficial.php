<?php

namespace App\Filament\Resources\Officials\Pages;

use App\Filament\Resources\Officials\OfficialResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Concerns\RedirectsToIndex;

class CreateOfficial extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = OfficialResource::class;
}
