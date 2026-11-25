<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Concerns\RedirectsToIndex;

class CreateArticle extends CreateRecord
{   
    use RedirectsToIndex;
    protected static string $resource = ArticleResource::class;
}