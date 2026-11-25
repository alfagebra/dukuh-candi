@php
    $siteName = $profile?->name ?? config('site.name');
    $showLocation = $profile?->map_embed_url || $profile?->map_url || $profile?->address;
@endphp

<x-layouts.app title="Profil" :description="$profile?->description">

    <x-page-header eyebrow="Profil" :title="$siteName" :subtitle="$profile?->tagline" />

    <div class="mx-auto max-w-6xl space-y-20 px-4 pt-14">

        {{-- Tentang --}}
        @if ($profile?->description)
            <section aria-labelledby="tentang">
                <h2 id="tentang" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Tentang Dukuh</h2>
                <p class="mt-4 max-w-3xl whitespace-pre-line text-lg leading-relaxed">{{ $profile->description }}</p>
            </section>
        @endif

        {{-- Visi & misi --}}
        @if ($profile?->vision || $profile?->mission)
            <section class="grid gap-6 md:grid-cols-2" aria-label="Visi dan misi">
                @if ($profile->vision)
                    <div class="rounded-2xl border border-primary-100 bg-white p-6 shadow-sm">
                        <h2 class="font-display text-xl font-bold text-primary-900">Visi</h2>
                        <p class="mt-3 whitespace-pre-line leading-relaxed">{{ $profile->vision }}</p>
                    </div>
                @endif
                @if ($profile->mission)
                    <div class="rounded-2xl border border-primary-100 bg-white p-6 shadow-sm">
                        <h2 class="font-display text-xl font-bold text-primary-900">Misi</h2>
                        <p class="mt-3 whitespace-pre-line leading-relaxed">{{ $profile->mission }}</p>
                    </div>
                @endif
            </section>
        @endif

        {{-- Sejarah: hanya tampil kalau sudah diisi --}}
        @if ($profile?->history)
            <section aria-labelledby="sejarah">
                <h2 id="sejarah" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Sejarah</h2>
                <p class="mt-4 max-w-3xl whitespace-pre-line text-lg leading-relaxed">{{ $profile->history }}</p>
            </section>
        @endif

        {{-- Struktur dukuh --}}
        @if ($officials->isNotEmpty())
            @php
                $head = $officials->first();
                $members = $officials->skip(1);
            @endphp

            <section aria-labelledby="perangkat" class="scroll-mt-24">
                <h2 id="perangkat" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Struktur Dukuh</h2>

                <div class="mt-8 flex justify-center">
                    <x-official-head :official="$head" />
                </div>

                @if ($members->isNotEmpty())
                    <div class="mx-auto h-8 w-px bg-primary-200" aria-hidden="true"></div>
                    <div class="mx-auto hidden h-px w-3/4 bg-primary-200 md:block" aria-hidden="true"></div>

                    <ul class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($members as $official)
                            <x-official-card :official="$official" />
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif

        {{-- Lokasi --}}
        @if ($showLocation)
            <section aria-labelledby="lokasi">
                <h2 id="lokasi" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Lokasi</h2>

                @if ($profile->address)
                    <p class="mt-4 whitespace-pre-line text-lg">{{ $profile->address }}</p>
                @endif

                <div class="mt-6">
                    <x-location-map :profile="$profile" />
                </div>
            </section>
        @endif

    </div>
</x-layouts.app>