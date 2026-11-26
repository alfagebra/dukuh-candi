@props(['profile', 'height' => 'h-64 sm:h-72 lg:h-80'])

@if ($profile?->map_embed_url)
    <div class="{{ $height }} overflow-hidden rounded-2xl border border-primary-100 bg-primary-50 shadow-sm">
        <iframe src="{{ $profile->map_embed_url }}" title="Peta lokasi {{ $profile->name }}" class="h-full w-full"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
@endif

