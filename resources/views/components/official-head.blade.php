@props(['official'])

<div class="flex w-full max-w-lg items-center gap-5 rounded-3xl border border-primary-100 bg-white p-5 shadow-md">
    <div class="h-28 w-28 shrink-0 overflow-hidden rounded-2xl bg-primary-50 sm:h-32 sm:w-32">
        @if ($official->photo_url)
            <img src="{{ $official->photo_url }}" alt="{{ $official->name }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover">
        @else
            <div class="flex h-full items-center justify-center font-display text-5xl font-bold text-primary-200" aria-hidden="true">
                {{ mb_strtoupper(mb_substr($official->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="min-w-0">
        <span class="inline-block rounded-full bg-accent-100 px-3 py-1 text-xs font-semibold text-accent-600">{{ $official->position }}</span>
        <p class="mt-2 font-display text-xl font-bold leading-snug text-primary-900 sm:text-2xl">{{ $official->name }}</p>
    </div>
</div>