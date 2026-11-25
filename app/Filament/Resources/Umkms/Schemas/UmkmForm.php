<?php

namespace App\Filament\Resources\Umkms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UmkmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Nama Usaha')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $context) {
                        if ($context === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('owner_name')
                    ->label('Nama Pemilik'),

                TextInput::make('category')
                    ->label('Kategori Usaha'),

                Textarea::make('description')
                    ->label('Deskripsi Usaha')
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('price_range')
                    ->label('Rentang Harga')
                    ->placeholder('Contoh: Rp5.000 - Rp50.000'),

                TextInput::make('address')
                    ->label('Alamat Lengkap')
                    ->columnSpanFull(),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel(),

                TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->tel(),

                TextInput::make('instagram')
                    ->label('Link Instagram')
                    ->placeholder('https://instagram.com/username')
                    ->url(),

                TextInput::make('map_url')
                    ->label('Link Google Maps')
                    ->url()
                    ->placeholder('https://maps.app.goo.gl/...')
                    ->columnSpanFull(),

                FileUpload::make('image_path')
                    ->label('Foto Utama UMKM')
                    ->image()
                    ->disk('s3')
                    ->directory('umkms')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ]),

                Repeater::make('photos')
                    ->label('Galeri Foto UMKM')
                    ->relationship()
                    ->schema([
                        FileUpload::make('photo_path')
                            ->label('Foto')
                            ->image()
                            ->disk('s3')
                            ->directory('umkms')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->required(),

                        TextInput::make('caption')
                            ->label('Keterangan Foto'),
                    ])
                    ->orderColumn('sort_order')
                    ->collapsible()
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Toggle::make('is_featured')
                    ->label('UMKM Unggulan')
                    ->default(false),

                Toggle::make('is_published')
                    ->label('Publikasikan ke Website')
                    ->default(false),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }
}
