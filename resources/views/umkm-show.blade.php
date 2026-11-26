@php
    $siteName = $profile?->name ?? config('site.name');

    $images = collect([['url' => $umkm->image_url, 'caption' => $umkm->name]])
        ->merge($umkm->photos->map(fn ($photo) => [
            'url' => $photo->photo_url,
            'caption' => $photo->caption ?: $umkm->name,
        ]))
        ->filter(fn ($image) => $image['url'])
        ->values();

    $waLink = $umkm->whatsapp_url
        ? $umkm->whatsapp_url . '?text=' . rawurlencode('Halo, saya melihat ' . $umkm->name . ' di website ' . $siteName . '.')
        : null;
@endphp

<x-layouts.app :title="$umkm->name" :description="$umkm->description" :image="$images->first()['url'] ?? null">
    <div class="mx-auto max-w-6xl px-4 pt-8">
        <a href="{{ route('umkm.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-900">&larr; Semua UMKM</a>

        <div class="mt-6 grid gap-10 lg:grid-cols-2">

            {{-- Foto --}}
            <div>
                @if ($images->isNotEmpty())
                    <a href="{{ $images[0]['url'] }}" data-lightbox="umkm" data-caption="{{ $images[0]['caption'] }}"
                       class="block aspect-[4/3] overflow-hidden rounded-2xl bg-primary-50">
                        <img src="{{ $images[0]['url'] }}" alt="{{ $umkm->name }}" decoding="async" fetchpriority="high"
                             class="h-full w-full object-cover">
                    </a>

                    @if ($images->count() > 1)
                        <ul class="mt-3 grid grid-cols-4 gap-3">
                            @foreach ($images->slice(1) as $image)
                                <li>
                                    <a href="{{ $image['url'] }}" data-lightbox="umkm" data-caption="{{ $image['caption'] }}"
                                       class="block aspect-square overflow-hidden rounded-xl bg-primary-50">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['caption'] }}" loading="lazy" decoding="async"
                                             class="h-full w-full object-cover">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-2xl bg-primary-50 text-6xl text-primary-200" aria-hidden="true">&#9733;</div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                @if ($umkm->category)
                    <span class="inline-block rounded-full bg-accent-100 px-3 py-1 text-xs font-semibold text-accent-600">{{ $umkm->category }}</span>
                @endif

                <h1 class="mt-3 font-display text-3xl font-bold text-primary-900 sm:text-4xl">{{ $umkm->name }}</h1>

                @if ($umkm->owner_name)
                    <p class="mt-2 text-muted">oleh {{ $umkm->owner_name }}</p>
                @endif

                @if ($umkm->description)
                    <p class="prose-dukuh mt-6 whitespace-pre-line">{{ $umkm->description }}</p>
                @endif

                <dl class="mt-6 space-y-4">
                    @if ($umkm->price_range)
                        <div>
                            <dt class="text-sm font-semibold text-primary-900">Kisaran Harga</dt>
                            <dd class="mt-1">{{ $umkm->price_range }}</dd>
                        </div>
                    @endif
                    @if ($umkm->address)
                        <div>
                            <dt class="text-sm font-semibold text-primary-900">Alamat</dt>
                            <dd class="mt-1 whitespace-pre-line">{{ $umkm->address }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener"
                           class="rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
                            Hubungi via WhatsApp
                        </a>
                    @endif
                    @if ($umkm->instagram_url)
                        <a href="{{ $umkm->instagram_url }}" target="_blank" rel="noopener"
                           class="rounded-full border border-primary-700 px-6 py-3 text-sm font-semibold text-primary-800 transition hover:bg-primary-100">
                            Instagram
                        </a>
                    @endif
                    @if ($umkm->map_url)
                        <a href="{{ $umkm->map_url }}" target="_blank" rel="noopener"
                           class="rounded-full border border-primary-700 px-6 py-3 text-sm font-semibold text-primary-800 transition hover:bg-primary-100">
                            Lihat Lokasi
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-lightbox />
</x-layouts.app>