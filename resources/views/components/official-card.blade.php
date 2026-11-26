@props(['official'])

<li class="w-[calc(50%-0.5rem)] overflow-hidden rounded-2xl border border-primary-100 bg-white text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:w-44 lg:w-48">
    <div class="aspect-square bg-primary-50">
        @if ($official->photo_url)
            <img src="{{ $official->photo_url }}" alt="{{ $official->name }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover">
        @else
            <div class="flex h-full items-center justify-center font-display text-4xl font-bold text-primary-200" aria-hidden="true">
                {{ mb_strtoupper(mb_substr($official->name, 0, 1)) }}
            </div>
        @endif
    </div>
    <div class="p-3">
        <p class="font-display text-sm font-bold leading-snug text-primary-900">{{ $official->name }}</p>
        <p class="mt-1 text-xs text-muted">{{ $official->position }}</p>
    </div>
</li>