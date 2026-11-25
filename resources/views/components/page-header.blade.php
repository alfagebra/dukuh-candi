@props(['title', 'eyebrow' => null, 'subtitle' => null])

<section class="bg-primary-900 text-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:py-20">
        @if ($eyebrow)
            <p class="text-sm font-semibold uppercase tracking-widest text-accent-400">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-2 max-w-3xl font-display text-3xl font-bold sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-primary-100">{{ $subtitle }}</p>
        @endif
    </div>
</section>