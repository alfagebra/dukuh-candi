<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\GalleryAlbums\GalleryAlbumResource;
use App\Filament\Resources\Officials\OfficialResource;
use App\Filament\Resources\Umkms\UmkmResource;
use App\Models\Article;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\Official;
use App\Models\Umkm;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStats extends StatsOverviewWidget
{
    protected static ?int $sort = -9;

    protected ?string $heading = 'Ringkasan Konten';

    protected ?string $description = 'Jumlah data yang sudah diisi di website.';

    protected function getStats(): array
    {
        // Satu query per jenis data (bukan satu per angka), supaya dashboard tetap cepat.
        $umkm = Umkm::query()
            ->selectRaw('count(*) as total, sum(case when is_published then 1 else 0 end) as published')
            ->first();

        $articles = Article::query()
            ->selectRaw("count(*) as total, sum(case when status = 'published' then 1 else 0 end) as published")
            ->first();

        $albums = GalleryAlbum::query()
            ->selectRaw('count(*) as total, sum(case when is_published then 1 else 0 end) as published')
            ->first();

        $items = GalleryItem::query()
            ->selectRaw("sum(case when type = 'photo' then 1 else 0 end) as photos, sum(case when type = 'video' then 1 else 0 end) as videos")
            ->first();

        $events = Event::query()
            ->selectRaw(
                'count(*) as total, sum(case when (ends_at >= ? or (ends_at is null and starts_at >= ?)) then 1 else 0 end) as upcoming',
                [now(), now()]
            )
            ->first();

        $officials = Official::query()
            ->selectRaw('count(*) as total, sum(case when is_active then 1 else 0 end) as active')
            ->first();

        $photos = (int) $items->photos;
        $videos = (int) $items->videos;

        return [
            Stat::make('UMKM', (int) $umkm->total)
                ->description((int) $umkm->published . ' tayang di website')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-shopping-bag')
                ->color('success')
                ->url(UmkmResource::getUrl('index')),

            Stat::make('Artikel', (int) $articles->total)
                ->description((int) $articles->published . ' terbit, ' . ((int) $articles->total - (int) $articles->published) . ' draf')
                ->descriptionIcon('heroicon-m-newspaper')
                ->icon('heroicon-o-newspaper')
                ->color('primary')
                ->url(ArticleResource::getUrl('index')),

            Stat::make('Album Galeri', (int) $albums->total)
                ->description((int) $albums->published . ' album diterbitkan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-photo')
                ->color('warning')
                ->url(GalleryAlbumResource::getUrl('index')),

            Stat::make('Foto & Video Diunggah', $photos + $videos)
                ->description($photos . ' foto, ' . $videos . ' video')
                ->descriptionIcon('heroicon-m-photo')
                ->icon('heroicon-o-camera')
                ->color('info'),

            Stat::make('Agenda', (int) $events->total)
                ->description((int) $events->upcoming . ' kegiatan mendatang')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->icon('heroicon-o-calendar-days')
                ->color('primary')
                ->url(EventResource::getUrl('index')),

            Stat::make('Perangkat Dukuh', (int) $officials->total)
                ->description((int) $officials->active . ' aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->url(OfficialResource::getUrl('index')),
        ];
    }
}