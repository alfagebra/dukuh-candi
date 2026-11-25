@props(['umkm'])

@php
    $url = \Illuminate\Support\Facades\Route::has('umkm.show') ? route('umkm.show', $umkm->slug) : null;
@endphp

<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-primary-100 bg-white shadow-sm transition hover:shadow-md">
    <div class="aspect-[4/3] overflow-hidden bg-primary-50">
        @if ($umkm->image_url)
            <img src="{{ $umkm->image_url }}" alt="{{ $umkm->name }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-4xl text-primary-200" aria-hidden="true">&#9733;</div>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        @if ($umkm->category)
            <span class="mb-2 inline-block w-fit rounded-full bg-accent-100 px-3 py-1 text-xs font-semibold text-accent-600">{{ $umkm->category }}</span>
        @endif

        <h3 class="font-display text-lg font-bold text-primary-900">
            @if ($url)
                <a href="{{ $url }}" class="after:absolute after:inset-0">{{ $umkm->name }}</a>
            @else
                {{ $umkm->name }}
            @endif
        </h3>

        @if ($umkm->owner_name)
            <p class="mt-1 text-sm text-muted">oleh {{ $umkm->owner_name }}</p>
        @endif

        @if ($umkm->price_range)
            <p class="mt-3 text-sm font-semibold text-primary-700">{{ $umkm->price_range }}</p>
        @endif
    </div>
</article>