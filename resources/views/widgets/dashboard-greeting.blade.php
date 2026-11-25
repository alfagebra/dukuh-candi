@php
    use App\Filament\Resources\Articles\ArticleResource;
    use App\Filament\Resources\Events\EventResource;
    use App\Filament\Resources\GalleryAlbums\GalleryAlbumResource;
    use App\Filament\Resources\Umkms\UmkmResource;

    $user = filament()->auth()->user();
    $hour = now()->hour;

    $greeting = match (true) {
        $hour < 11 => 'Selamat pagi',
        $hour < 15 => 'Selamat siang',
        $hour < 18 => 'Selamat sore',
        default => 'Selamat malam',
    };
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; line-height: 1.3;">
                    {{ $greeting }}, {{ $user->name }}
                </h2>
                <p style="margin-top: 0.35rem; opacity: 0.7;">
                    {{ now()->locale('id')->translatedFormat('l, j F Y') }}
                    &middot; Kelola konten website {{ config('site.name') }} dari sini.
                </p>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <x-filament::button tag="a" :href="ArticleResource::getUrl('create')" icon="heroicon-o-pencil-square">
                    Tulis Artikel
                </x-filament::button>
                <x-filament::button tag="a" :href="GalleryAlbumResource::getUrl('create')" icon="heroicon-o-photo" color="gray">
                    Buat Album
                </x-filament::button>
                <x-filament::button tag="a" :href="UmkmResource::getUrl('create')" icon="heroicon-o-shopping-bag" color="gray">
                    Tambah UMKM
                </x-filament::button>
                <x-filament::button tag="a" :href="EventResource::getUrl('create')" icon="heroicon-o-calendar-days" color="gray">
                    Tambah Agenda
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>