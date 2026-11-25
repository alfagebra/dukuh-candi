@props(['official'])

<li class="overflow-hidden rounded-2xl border border-primary-100 bg-white text-center shadow-sm">
    <div class="aspect-[3/4] bg-primary-50">
        @if ($official->photo_url)
            <img src="{{ $official->photo_url }}" alt="{{ $official->name }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover">
        @else
            <div class="flex h-full items-center justify-center font-display text-5xl font-bold text-primary-200" aria-hidden="true">
                {{ mb_strtoupper(mb_substr($official->name, 0, 1)) }}
            </div>
        @endif
    </div>
    <div class="p-4">
        <p class="font-display font-bold text-primary-900">{{ $official->name }}</p>
        <p class="mt-1 text-sm text-muted">{{ $official->position }}</p>
    </div>
</li>