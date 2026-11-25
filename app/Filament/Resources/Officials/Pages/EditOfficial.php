<?php

namespace App\Filament\Resources\Officials\Pages;

use App\Filament\Resources\Officials\OfficialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\RedirectsToIndex;

class EditOfficial extends EditRecord
{
    use RedirectsToIndex;
    protected static string $resource = OfficialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
