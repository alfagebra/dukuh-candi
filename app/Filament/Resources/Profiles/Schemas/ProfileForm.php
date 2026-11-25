<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Dukuh')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Dukuh')
                            ->required()
                            ->maxLength(255)
                            ->default('Dukuh Candi'),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->default('dukuh-candi'),

                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->maxLength(255)
                            ->placeholder('Kalimat singkat yang tampil di bagian atas beranda')
                            ->columnSpanFull(),

                        FileUpload::make('logo_path')
                            ->label('Logo Dukuh')
                            ->image()
                            ->disk('s3')
                            ->directory('profiles')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ]),

                        FileUpload::make('cover_image_path')
                            ->label('Gambar Utama (Hero)')
                            ->image()
                            ->disk('s3')
                            ->directory('profiles')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ]),
                    ]),

                Section::make('Tentang Dukuh')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('description')
                            ->label('Tentang')
                            ->rows(5),

                        Textarea::make('history')
                            ->label('Sejarah')
                            ->helperText('Bagian sejarah di website hanya tampil kalau kolom ini diisi.')
                            ->rows(6),

                        Textarea::make('vision')
                            ->label('Visi')
                            ->rows(3),

                        Textarea::make('mission')
                            ->label('Misi')
                            ->rows(5),
                    ]),

                Section::make('Kontak dan Lokasi')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel(),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email(),

                        Textarea::make('map_embed')
                            ->label('Kode Sematan Peta (Embed)')
                            ->rows(3)
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>')
                            ->helperText('Cara: buka lokasi dukuh di Google Maps, klik Bagikan, pilih tab "Sematkan peta", klik "Salin HTML", lalu tempel di sini. Peta akan tampil langsung di website.')
                            ->regex('~google\.com/maps/embed~i')
                            ->validationMessages([
                                'regex' => 'Tempel kode sematan dari Google Maps (Bagikan, lalu Sematkan peta).',
                            ])
                            ->columnSpanFull(),

                        TextInput::make('map_url')
                            ->label('Link Google Maps')
                            ->url()
                            ->placeholder('https://maps.app.goo.gl/...')
                            ->helperText('Dipakai untuk tombol "Buka di Google Maps".')
                            ->columnSpanFull(),

                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->minValue(-90)
                            ->maxValue(90)
                            ->placeholder('-7.xxxxxx')
                            ->helperText('Alternatif kalau tidak memakai kode sematan. Cara ambil: buka link Google Maps, angka setelah tanda @ di alamat browser adalah latitude lalu longitude.'),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->minValue(-180)
                            ->maxValue(180)
                            ->placeholder('110.xxxxxx'),
                    ]),

                Section::make('Media Sosial')
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/...'),

                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url(),

                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url(),

                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url(),
                    ]),

                Section::make('Statistik Wilayah')
                    ->description('Belum ditampilkan di website sampai data sensus dukuh tersedia. Boleh dikosongkan.')
                    ->columns(3)
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        TextInput::make('population')
                            ->label('Jumlah Penduduk')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('households')
                            ->label('Jumlah KK')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('area_hectares')
                            ->label('Luas Wilayah (hektare)')
                            ->numeric()
                            ->minValue(0),
                    ]),
            ]);
    }
}