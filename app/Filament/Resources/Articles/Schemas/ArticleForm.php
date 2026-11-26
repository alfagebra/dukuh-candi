<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Isi Artikel')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, string $operation) {
                                // Slug hanya otomatis saat membuat, supaya URL artikel lama tidak berubah.
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Kategori')
                            ->options(Article::CATEGORIES)
                            ->required()
                            ->native(false),

                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Tampil di daftar artikel dan saat tautan dibagikan.')
                            ->rows(3)
                            ->maxLength(300)
                            ->columnSpanFull(),

                        FileUpload::make('image_path')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('s3')
                            ->directory('articles')
                            ->visibility('private')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Isi Artikel')
                            ->required()
                            ->fileAttachmentsDisk('s3')
                            ->fileAttachmentsDirectory('articles/content')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull(),
                    ]),

                Section::make('Publikasi')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(Article::STATUSES)
                            ->default(Article::STATUS_DRAFT)
                            ->required()
                            ->native(false),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->helperText('Kosongkan untuk memakai waktu saat artikel diterbitkan.')
                            ->seconds(false),
                    ]),

                Section::make('SEO')
                    ->description('Opsional. Kalau kosong, judul dan ringkasan artikel yang dipakai.')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Judul SEO')
                            ->maxLength(70),

                        Textarea::make('meta_description')
                            ->label('Deskripsi SEO')
                            ->rows(2)
                            ->maxLength(160),
                    ]),
            ]);
    }
}