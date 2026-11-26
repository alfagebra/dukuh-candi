@php
    $siteName = $profile?->name ?? config('site.name');
    $socials = array_filter([
        'Instagram' => $profile?->instagram,
        'Facebook' => $profile?->facebook,
        'YouTube' => $profile?->youtube,
        'TikTok' => $profile?->tiktok,
    ]);
@endphp

<x-layouts.app title="Kontak" :description="'Alamat, telepon, WhatsApp, dan media sosial ' . $siteName . '.'">

    <x-page-header eyebrow="Kontak" :title="'Hubungi ' . $siteName" />

    <div class="mx-auto grid max-w-6xl gap-10 px-4 pt-14 lg:grid-cols-2">

        <div class="space-y-6">
            @if ($profile?->address)
                <div>
                    <h2 class="font-display text-lg font-bold text-primary-900">Alamat</h2>
                    <p class="mt-1 whitespace-pre-line">{{ $profile->address }}</p>
                </div>
            @endif

            @if ($profile?->phone)
                <div>
                    <h2 class="font-display text-lg font-bold text-primary-900">Telepon</h2>
                    <p class="mt-1">
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $profile->phone) }}" class="text-primary-700 hover:underline">{{ $profile->phone }}</a>
                    </p>
                </div>
            @endif

            @if ($profile?->email)
                <div>
                    <h2 class="font-display text-lg font-bold text-primary-900">Email</h2>
                    <p class="mt-1"><a href="mailto:{{ $profile->email }}" class="text-primary-700 hover:underline">{{ $profile->email }}</a></p>
                </div>
            @endif

            @if ($socials)
                <div>
                    <h2 class="font-display text-lg font-bold text-primary-900">Media Sosial</h2>
                    <ul class="mt-1 flex flex-wrap gap-x-5 gap-y-1">
                        @foreach ($socials as $label => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener" class="text-primary-700 hover:underline">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($profile?->whatsapp_url)
                <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener"
                   class="inline-flex items-center rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
                    Chat via WhatsApp
                </a>
            @endif
        </div>

        <div>
            <x-location-map :profile="$profile" height="h-72 lg:h-96" />
        </div>
    </div>
</x-layouts.app>