@props(['profile', 'ratio' => 'aspect-[4/3] sm:aspect-[16/9]'])

@if ($profile?->map_embed_url)
    <div class="{{ $ratio }} overflow-hidden rounded-2xl border border-primary-100 bg-primary-50 shadow-sm">
        <iframe src="{{ $profile->map_embed_url }}" title="Peta lokasi {{ $profile->name }}" class="h-full w-full"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
@endif

@if ($profile?->map_url)
    <a href="{{ $profile->map_url }}" target="_blank" rel="noopener"
       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary-700 hover:text-primary-900">
        Buka di Google Maps <span aria-hidden="true">&rarr;</span>
    </a>
@endif