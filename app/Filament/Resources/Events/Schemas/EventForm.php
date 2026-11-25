<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, string $operation) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                DateTimePicker::make('starts_at')
                    ->label('Waktu Mulai')
                    ->required()
                    ->seconds(false),

                DateTimePicker::make('ends_at')
                    ->label('Waktu Selesai')
                    ->helperText('Boleh dikosongkan.')
                    ->seconds(false)
                    ->after('starts_at'),

                TextInput::make('location')
                    ->label('Lokasi')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('image_path')
                    ->label('Gambar Kegiatan')
                    ->image()
                    ->disk('s3')
                    ->directory('events')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Tampilkan di Website')
                    ->default(false),
            ]);
    }
}