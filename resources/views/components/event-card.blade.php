@props(['event', 'showDescription' => false])

<article class="flex gap-4 rounded-2xl border border-primary-100 bg-white p-4 shadow-sm">
    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-primary-700 text-white" aria-hidden="true">
        <span class="text-2xl font-bold leading-none">{{ $event->starts_at->format('j') }}</span>
        <span class="mt-1 text-xs uppercase tracking-wide">{{ $event->starts_at->locale('id')->translatedFormat('M') }}</span>
    </div>

    <div class="min-w-0">
        <h3 class="font-display text-base font-bold text-primary-900">{{ $event->title }}</h3>
        <p class="mt-1 text-sm text-muted">{{ $event->start_date }} &middot; {{ $event->time_range }}</p>
        @if ($event->location)
            <p class="mt-1 text-sm text-muted">{{ $event->location }}</p>
        @endif
        @if ($showDescription && $event->description)
            <p class="mt-3 whitespace-pre-line text-sm leading-relaxed">{{ $event->description }}</p>
        @endif
    </div>
</article>