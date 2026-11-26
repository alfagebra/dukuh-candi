@php
    use App\Filament\Resources\Articles\ArticleResource;
    use App\Filament\Resources\Events\EventResource;
    use App\Filament\Resources\GalleryAlbums\GalleryAlbumResource;
    use App\Filament\Resources\Umkms\UmkmResource;

    $user = filament()->auth()->user();
    $hour = now()->hour;

    $greeting = match (true) {
        $hour < 11 => 'Selamat Pagi',
        $hour < 15 => 'Selamat Siang',
        $hour < 18 => 'Selamat Sore',
        default => 'Selamat Malam',
    };
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="dukuh-greeting">
            <div>
                <h2 class="dukuh-greeting__title">
                    {{ $greeting }}, {{ $user->name }}
                </h2>
                <p class="dukuh-greeting__sub">
                    {{ now()->locale('id')->translatedFormat('l, j F Y') }}
                    &middot; Kelola konten website {{ config('site.name') }} dari sini.
                </p>
            </div>

            <div class="dukuh-actions">
                <x-filament::button tag="a" :href="ArticleResource::getUrl('create')" icon="heroicon-o-pencil-square" class="dukuh-btn dukuh-btn--primary">
                    Tulis Artikel
                </x-filament::button>
                <x-filament::button tag="a" :href="GalleryAlbumResource::getUrl('create')" icon="heroicon-o-photo" color="gray" class="dukuh-btn dukuh-btn--soft">
                    Buat Album
                </x-filament::button>
                <x-filament::button tag="a" :href="UmkmResource::getUrl('create')" icon="heroicon-o-shopping-bag" color="gray" class="dukuh-btn dukuh-btn--soft">
                    Tambah UMKM
                </x-filament::button>
                <x-filament::button tag="a" :href="EventResource::getUrl('create')" icon="heroicon-o-calendar-days" color="gray" class="dukuh-btn dukuh-btn--soft">
                    Tambah Agenda
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>