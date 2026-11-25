@props(['album'])

@php
    $url = \Illuminate\Support\Facades\Route::has('gallery.show') ? route('gallery.show', $album->slug) : null;
    $photoCount = $album->items->where('type', 'photo')->count();
    $videoCount = $album->items->where('type', 'video')->count();
    $summary = implode(' · ', array_filter([
        $photoCount ? $photoCount . ' foto' : null,
        $videoCount ? $videoCount . ' video' : null,
    ]));
@endphp

<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-primary-100 bg-white shadow-sm transition hover:shadow-md">
    <div class="relative aspect-[4/3] overflow-hidden bg-primary-50">
        @if ($album->cover_url)
            <img src="{{ $album->cover_url }}" alt="Cover album {{ $album->title }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-5xl text-primary-200" aria-hidden="true">&#9635;</div>
        @endif

        @if ($summary)
            <span class="absolute right-3 top-3 rounded-full bg-black/65 px-3 py-1 text-xs font-semibold text-white">{{ $summary }}</span>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        @if ($album->documentation_date)
            <time datetime="{{ $album->documentation_date->toDateString() }}" class="text-xs font-semibold uppercase tracking-wide text-accent-600">
                {{ $album->documentation_date->locale('id')->translatedFormat('j F Y') }}
            </time>
        @endif

        <h3 class="mt-1 font-display text-lg font-bold leading-snug text-primary-900">
            @if ($url)
                <a href="{{ $url }}" class="after:absolute after:inset-0">{{ $album->title }}</a>
            @else
                {{ $album->title }}
            @endif
        </h3>

        @if ($album->description)
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-muted">{{ $album->description }}</p>
        @endif

        <span class="mt-4 text-sm font-semibold text-primary-700" aria-hidden="true">Lihat semua foto &rarr;</span>
    </div>
</article>