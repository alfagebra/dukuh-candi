<?php

namespace App\Filament\Resources\GalleryAlbums\RelationManagers;

use App\Models\GalleryItem;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Foto & Video Album';

    protected static ?string $modelLabel = 'item';

    protected static ?string $pluralModelLabel = 'item';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Jenis')
                    ->options([
                        GalleryItem::TYPE_PHOTO => 'Foto',
                        GalleryItem::TYPE_VIDEO => 'Video (link YouTube)',
                    ])
                    ->default(GalleryItem::TYPE_PHOTO)
                    ->required()
                    ->live()
                    ->native(false),

                FileUpload::make('file_path')
                    ->label('Foto')
                    ->image()
                    ->disk('s3')
                    ->directory('gallery')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->required(fn (Get $get): bool => $get('type') === GalleryItem::TYPE_PHOTO)
                    ->visible(fn (Get $get): bool => $get('type') === GalleryItem::TYPE_PHOTO)
                    ->columnSpanFull(),

                TextInput::make('video_url')
                    ->label('Link Video YouTube')
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->helperText('Tempel link video dari YouTube (youtube.com/watch, youtu.be, shorts, atau live).')
                    ->required(fn (Get $get): bool => $get('type') === GalleryItem::TYPE_VIDEO)
                    ->visible(fn (Get $get): bool => $get('type') === GalleryItem::TYPE_VIDEO)
                    ->regex('~^(?:https?://)?(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))[A-Za-z0-9_-]{11}~i')
                    ->validationMessages([
                        'regex' => 'Link harus berupa link video YouTube yang lengkap, bukan link channel.',
                    ])
                    // Link tanpa https:// tetap diterima dan dilengkapi otomatis.
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) && ! preg_match('~^https?://~i', $state)
                        ? 'https://' . ltrim($state, '/')
                        : $state)
                    ->columnSpanFull(),

                TextInput::make('title')
                    ->label('Judul')
                    ->maxLength(255),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Textarea::make('description')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('thumbnail_url')
                    ->label('Pratinjau')
                    ->square()
                    ->size(60),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === GalleryItem::TYPE_VIDEO ? 'Video' : 'Foto')
                    ->color(fn (string $state): string => $state === GalleryItem::TYPE_VIDEO ? 'info' : 'success'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->placeholder('-')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(50)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis')
                    ->options([
                        GalleryItem::TYPE_PHOTO => 'Foto',
                        GalleryItem::TYPE_VIDEO => 'Video',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Satu Item'),

                Action::make('bulkUpload')
                    ->label('Upload Banyak Foto')
                    ->icon('heroicon-o-photo')
                    ->color('gray')
                    ->modalHeading('Upload Banyak Foto')
                    ->modalSubmitActionLabel('Simpan Semua')
                    ->schema([
                        FileUpload::make('files')
                            ->label('Foto')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->maxFiles(30)
                            ->disk('s3')
                            ->directory('gallery')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->required()
                            ->helperText('Maksimal 30 foto sekali upload, masing-masing 5 MB.'),
                    ])
                    ->action(function (array $data): void {
                        $album = $this->getOwnerRecord();
                        $order = (int) $album->items()->max('sort_order');

                        foreach ($data['files'] as $path) {
                            $album->items()->create([
                                'type' => GalleryItem::TYPE_PHOTO,
                                'file_path' => $path,
                                'sort_order' => ++$order,
                            ]);
                        }

                        Notification::make()
                            ->title(count($data['files']) . ' foto berhasil ditambahkan')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}