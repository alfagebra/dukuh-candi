<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->disk('s3')
                    ->square()
                    ->size(50),

                TextColumn::make('title')
                    ->label('Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('starts_at')
                    ->label('Waktu Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->placeholder('-')
                    ->limit(30)
                    ->searchable(),

                IconColumn::make('is_published')
                    ->label('Tampil')
                    ->boolean(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                Filter::make('upcoming')
                    ->label('Hanya yang mendatang')
                    ->query(fn (Builder $query): Builder => $query->upcoming()),

                TernaryFilter::make('is_published')
                    ->label('Status Tampil'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}