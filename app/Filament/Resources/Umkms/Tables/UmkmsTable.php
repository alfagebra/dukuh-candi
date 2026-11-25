<?php

namespace App\Filament\Resources\Umkms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UmkmsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Foto')
                    ->disk('s3')
                    ->square()
                    ->size(50),

                TextColumn::make('name')
                    ->label('Nama Usaha')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('owner_name')
                    ->label('Pemilik')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('price_range')
                    ->label('Rentang Harga')
                    ->toggleable(),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('instagram')
                    ->label('Instagram')
                    ->toggleable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('photos_count')
                    ->label('Jumlah Foto')
                    ->counts('photos'),

                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),

                IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_featured')
                    ->label('UMKM Unggulan'),

                TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
