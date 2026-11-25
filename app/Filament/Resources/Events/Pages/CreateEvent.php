<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Concerns\RedirectsToIndex;

class CreateEvent extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = EventResource::class;
}