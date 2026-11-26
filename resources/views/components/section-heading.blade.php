@props(['title', 'subtitle' => null, 'href' => null, 'linkLabel' => 'Lihat semua'])

<div class="mb-8 flex flex-wrap items-end justify-between gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-2 max-w-2xl text-muted">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($href)
        <a href="{{ $href }}" class="text-sm font-semibold text-primary-700 hover:text-primary-900">{{ $linkLabel }} &rarr;</a>
    @endif
</div>