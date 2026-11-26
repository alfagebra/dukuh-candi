@php
    $siteName = $profile?->name ?? config('site.name');

    $cardClass = 'group relative overflow-hidden rounded-2xl border border-white/70 bg-white/90 shadow-lg ring-1 ring-primary-100 backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:shadow-xl';
    $iconClass = 'flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white shadow-md transition group-hover:bg-accent-500 group-hover:text-soil-900';

    $stats = collect([
        [
            'label' => 'Penduduk',
            'value' => $profile?->population,
            'unit' => 'jiwa',
            'decimals' => 0,
            'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        ],
        [
            'label' => 'Kepala Keluarga',
            'value' => $profile?->households,
            'unit' => 'KK',
            'decimals' => 0,
            'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
        ],
        [
            'label' => 'Luas Wilayah',
            'value' => $profile?->area_hectares,
            'unit' => 'hektare',
            'decimals' => 1,
            'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z',
        ],
    ])->filter(fn ($stat) => ($stat['value'] ?? 0) > 0);

    $eyeIcon = 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z';
    $flagIcon = 'M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5';
@endphp

<x-layouts.app title="Profil" :description="$profile?->description">

    <x-page-header eyebrow="Profil" :title="$siteName" :subtitle="$profile?->tagline" />

    <div class="mx-auto max-w-6xl space-y-20 px-4 pt-14">

        @if ($profile?->description)
            <section aria-labelledby="tentang" class="grid items-start gap-10 {{ $stats->isNotEmpty() ? 'lg:grid-cols-[1.7fr_1fr] lg:gap-14' : '' }}">
                <div>
                    <h2 id="tentang" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Tentang Dukuh</h2>
                    <p class="prose-dukuh mt-4 whitespace-pre-line sm:text-justify {{ $stats->isEmpty() ? 'lg:columns-2 lg:gap-12' : '' }}">{{ $profile->description }}</p>
                </div>

                @if ($stats->isNotEmpty())
                    <ul class="grid gap-4" aria-label="Dukuh dalam angka">
                        @foreach ($stats as $stat)
                            <li class="{{ $cardClass }} flex items-center gap-4 p-5">
                                <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

                                <span class="{{ $iconClass }}">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="font-display text-2xl font-bold leading-none text-primary-900">
                                        {{ number_format($stat['value'], $stat['decimals'], ',', '.') }}
                                        <span class="text-sm font-semibold text-muted">{{ $stat['unit'] }}</span>
                                    </p>
                                    <p class="mt-1 text-sm text-muted">{{ $stat['label'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif

        @if ($profile?->history)
            <section aria-labelledby="sejarah" class="scroll-mt-24">
                <h2 id="sejarah" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Sejarah</h2>
                <p class="prose-dukuh mt-4 whitespace-pre-line sm:text-justify lg:columns-2 lg:gap-12">{{ $profile->history }}</p>
            </section>
        @endif

        @if ($profile?->vision || $profile?->mission)
            <section class="grid gap-6 md:grid-cols-2" aria-label="Visi dan misi">
                @if ($profile->vision)
                    <div class="{{ $cardClass }} p-6 sm:p-8">
                        <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

                        <div class="flex items-center gap-4">
                            <span class="{{ $iconClass }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $eyeIcon }}" />
                                </svg>
                            </span>
                            <h2 class="font-display text-xl font-bold text-primary-900">Visi</h2>
                        </div>

                        <p class="mt-4 whitespace-pre-line leading-relaxed sm:text-justify">{{ $profile->vision }}</p>
                    </div>
                @endif

                @if ($profile->mission)
                    <div class="{{ $cardClass }} p-6 sm:p-8">
                        <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

                        <div class="flex items-center gap-4">
                            <span class="{{ $iconClass }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $flagIcon }}" />
                                </svg>
                            </span>
                            <h2 class="font-display text-xl font-bold text-primary-900">Misi</h2>
                        </div>

                        <p class="mt-4 whitespace-pre-line leading-relaxed sm:text-justify">{{ $profile->mission }}</p>
                    </div>
                @endif
            </section>
        @endif

        @if ($officials->isNotEmpty())
            <section aria-labelledby="perangkat" class="scroll-mt-24">
                <h2 id="perangkat" class="font-display text-2xl font-bold text-primary-900 sm:text-3xl">Struktur Dukuh</h2>

                <ul class="mt-8 flex flex-wrap justify-center gap-4">
                    @foreach ($officials as $official)
                        <x-official-card :official="$official" />
                    @endforeach
                </ul>
            </section>
        @endif

    </div>
</x-layouts.app>