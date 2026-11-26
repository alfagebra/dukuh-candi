@php
    $siteName = $profile?->name ?? config('site.name');

    $quickLinks = collect([
        [
            'route' => 'profile',
            'title' => 'Profil Dukuh',
            'desc' => 'Kenali dukuh dan perangkatnya',
            'icon' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
        ],
        [
            'route' => 'umkm.index',
            'title' => 'UMKM Warga',
            'desc' => 'Usaha warga yang bisa dihubungi',
            'icon' => 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
        ],
        [
            'route' => 'gallery.index',
            'title' => 'Galeri',
            'desc' => 'Foto dan video kegiatan',
            'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
        ],
        [
            'route' => 'events.index',
            'title' => 'Agenda',
            'desc' => 'Kegiatan yang akan datang',
            'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
        ],
    ])->filter(fn ($link) => Route::has($link['route']));

    $nextEvent = $events->first();
    $showLocation = $profile?->map_embed_url || $profile?->map_url || $profile?->address;
    // Foto bagian "Mengenal Dukuh" diunggah dari menu Profil Dukuh (bukan dari album).
    $aboutImage = $profile?->about_image_url;
    $showAbout = $profile?->description || $profile?->history || $profile?->vision;
@endphp

<x-layouts.app :description="$profile?->tagline ?: $profile?->description" flush>

    {{-- ===== Hero ===== --}}
    <section class="relative isolate overflow-hidden bg-primary-900 text-white">
        @if ($profile?->cover_image_url)
            <img src="{{ $profile->cover_image_url }}" alt="" fetchpriority="high" decoding="async"
                 class="absolute inset-0 -z-30 h-full w-full object-cover opacity-55">
        @else
            <div class="absolute inset-0 -z-30 bg-gradient-to-br from-primary-700 to-primary-900"></div>
        @endif
        <div class="bg-pattern-dots absolute inset-0 -z-20"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-primary-900/30 via-primary-900/55 to-primary-900/90"></div>

        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 pb-32 pt-20 sm:pb-40 sm:pt-28 lg:grid-cols-[1.4fr_1fr] lg:pt-32">
            <div>
                <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-accent-400">
                    <span class="h-px w-8 bg-accent-400" aria-hidden="true"></span> Selamat datang di
                </p>
                <h1 class="mt-4 font-display text-4xl font-bold leading-tight sm:text-6xl">{{ $siteName }}</h1>

                @if ($profile?->tagline)
                    <p class="mt-5 max-w-xl text-lg leading-relaxed text-primary-100 sm:text-xl">{{ $profile->tagline }}</p>
                @endif

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('profile') }}" class="rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold text-soil-900 transition hover:bg-accent-400">
                        Kenali Dukuh
                    </a>
                    <a href="{{ route('contact') }}" class="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- Kartu agenda terdekat (hanya di layar lebar) --}}
            @if ($nextEvent)
                <aside class="hidden rounded-3xl border border-white/20 bg-white/10 p-6 backdrop-blur-md lg:block" aria-label="Agenda terdekat">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-400">Agenda terdekat</p>

                    <div class="mt-4 flex gap-4">
                        <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-accent-500 text-soil-900" aria-hidden="true">
                            <span class="text-2xl font-bold leading-none">{{ $nextEvent->starts_at->format('j') }}</span>
                            <span class="mt-1 text-xs font-semibold uppercase">{{ $nextEvent->starts_at->locale('id')->translatedFormat('M') }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="font-display text-lg font-bold leading-snug">{{ $nextEvent->title }}</p>
                            <p class="mt-1 text-sm text-primary-100">{{ $nextEvent->start_date }} &middot; {{ $nextEvent->time_range }}</p>
                            @if ($nextEvent->location)
                                <p class="mt-1 text-sm text-primary-100">{{ $nextEvent->location }}</p>
                            @endif
                        </div>
                    </div>

                    @if (Route::has('events.index'))
                        <a href="{{ route('events.index') }}" class="mt-5 inline-block text-sm font-semibold text-accent-400 hover:text-white">Lihat semua agenda &rarr;</a>
                    @endif
                </aside>
            @endif
        </div>
    </section>

    {{-- ===== Kotak highlight (menumpuk di atas hero) ===== --}}
    @if ($quickLinks->isNotEmpty())
        <div class="relative z-10 mx-auto -mt-16 max-w-6xl px-4 sm:-mt-20">
            <ul class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
                @foreach ($quickLinks as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-white/70 bg-white/90 p-4 shadow-lg ring-1 ring-primary-100 backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:p-5">
                            <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-700 text-white shadow-md transition group-hover:bg-accent-500 group-hover:text-soil-900">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                                </svg>
                            </span>

                            <span class="mt-4 font-display text-base font-bold text-primary-900 sm:text-lg">{{ $link['title'] }}</span>
                            <span class="mt-1 flex-1 text-xs text-muted sm:text-sm">{{ $link['desc'] }}</span>

                            <span class="mt-4 inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 transition group-hover:translate-x-1 group-hover:bg-primary-700 group-hover:text-white" aria-hidden="true">&rarr;</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===== 1. Mengenal Dukuh: tentang, sejarah, visi ===== --}}
    @if ($showAbout)
        <x-section tone="cream">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                @if ($aboutImage)
                    <div class="relative">
                        <div class="absolute -left-3 -top-3 h-full w-full rounded-3xl border-2 border-accent-400" aria-hidden="true"></div>
                        <img src="{{ $aboutImage }}" alt="Suasana {{ $siteName }}" loading="lazy" decoding="async"
                             class="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-xl">
                    </div>
                @endif

                <div class="{{ $aboutImage ? '' : 'max-w-3xl lg:col-span-2' }}">
                    <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-accent-600">
                        <span class="h-px w-8 bg-accent-500" aria-hidden="true"></span> Mengenal Dukuh
                    </p>
                    <h2 class="mt-3 font-display text-3xl font-bold text-primary-900 sm:text-4xl">{{ $siteName }}</h2>

                    @if ($profile->description)
                        <p class="mt-5 whitespace-pre-line text-lg leading-relaxed">{{ Str::limit($profile->description, 420) }}</p>
                    @endif

                    @if ($profile->history)
                        <div class="mt-6">
                            <h3 class="font-display text-lg font-bold text-primary-900">Sejarah Singkat</h3>
                            <p class="mt-2 whitespace-pre-line leading-relaxed text-ink/90">{{ Str::limit($profile->history, 340) }}</p>
                        </div>
                    @endif

                    @if ($profile->vision)
                        <div class="mt-6 rounded-2xl border border-accent-400/40 bg-accent-100/60 p-5">
                            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600">Visi</p>
                            <p class="mt-2 whitespace-pre-line font-display text-lg italic leading-relaxed text-primary-900">{{ Str::limit($profile->vision, 240) }}</p>
                        </div>
                    @endif

                    <a href="{{ route('profile') }}{{ $profile->history ? '#sejarah' : '' }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-700 hover:text-primary-900">
                        Baca selengkapnya <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </x-section>
    @endif

    {{-- ===== 2. UMKM ===== --}}
    @if ($umkms->isNotEmpty())
        <x-section tone="white">
            <x-section-heading title="UMKM Warga" subtitle="Usaha warga yang bisa langsung dihubungi." />

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($umkms as $umkm)
                    <x-umkm-card :umkm="$umkm" />
                @endforeach
            </div>

            @if (Route::has('umkm.index'))
                <x-more-button :href="route('umkm.index')" label="Lihat semua UMKM" />
            @endif
        </x-section>
    @endif

    {{-- ===== 3. Budaya ===== --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-br from-soil-700 to-soil-900 py-16 text-white sm:py-24">
        <div class="bg-pattern-dots absolute inset-0 -z-10"></div>
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 lg:grid-cols-[1.4fr_1fr]">
            <div>
                <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-accent-400">
                    <span class="h-px w-8 bg-accent-400" aria-hidden="true"></span> Budaya &amp; Kesenian
                </p>
                <h2 class="mt-3 max-w-2xl font-display text-2xl font-bold sm:text-4xl">Kesenian dan tradisi yang terus hidup di {{ $siteName }}</h2>
                <p class="mt-4 max-w-2xl text-primary-100">Kegiatan kesenian dukuh dikelola dan didokumentasikan oleh sanggar.</p>
                <a href="{{ route('culture') }}" class="mt-7 inline-block rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold text-soil-900 transition hover:bg-accent-400">
                    Lihat Budaya
                </a>
            </div>

            <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-400">Sanggar</p>
                <p class="mt-2 font-display text-2xl font-bold">{{ config('site.sanggar.name') }}</p>
                <p class="mt-2 text-sm text-primary-100">Pusat informasi kesenian dukuh.</p>
                <a href="{{ config('site.sanggar.url') }}" target="_blank" rel="noopener"
                   class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-white">
                    Kunjungi website sanggar <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== 4. Artikel (satu artikel pilihan + dua lainnya) ===== --}}
    @if ($articles->isNotEmpty())
        @php
            $lead = $articles->first();
            $others = $articles->skip(1);
            $leadUrl = Route::has('articles.show') ? route('articles.show', $lead->slug) : null;
        @endphp

        <x-section tone="cream">
            <x-section-heading title="Kabar Terbaru" subtitle="Berita dan cerita dari dukuh." />

            <div class="grid gap-6 lg:grid-cols-3">
                <article class="group relative isolate flex min-h-[22rem] flex-col justify-end overflow-hidden rounded-3xl bg-primary-900 text-white {{ $others->isEmpty() ? 'lg:col-span-3' : 'lg:col-span-2 lg:row-span-2' }}">
                    @if ($lead->image_url)
                        <img src="{{ $lead->image_url }}" alt="" loading="lazy" decoding="async"
                             class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-primary-900 via-primary-900/55 to-transparent"></div>

                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                            <span class="rounded-full bg-accent-500 px-3 py-1 text-soil-900">Artikel Pilihan</span>
                            <span class="rounded-full bg-white/20 px-3 py-1">{{ $lead->category_label }}</span>
                            @if ($lead->published_date)
                                <span class="text-primary-100">{{ $lead->published_date }}</span>
                            @endif
                        </div>

                        <h3 class="mt-3 font-display text-2xl font-bold leading-snug sm:text-3xl">
                            @if ($leadUrl)
                                <a href="{{ $leadUrl }}" class="after:absolute after:inset-0">{{ $lead->title }}</a>
                            @else
                                {{ $lead->title }}
                            @endif
                        </h3>

                        @if ($lead->excerpt)
                            <p class="mt-3 line-clamp-2 max-w-2xl text-primary-100">{{ $lead->excerpt }}</p>
                        @endif
                    </div>
                </article>

                @foreach ($others as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>

            @if (Route::has('articles.index'))
                <x-more-button :href="route('articles.index')" label="Lihat semua artikel" />
            @endif
        </x-section>
    @endif

    {{-- ===== 5. Galeri (satu cover per album) ===== --}}
    @if ($albums->isNotEmpty())
        <x-section tone="green">
            <x-section-heading title="Galeri Kegiatan" subtitle="Pilih album untuk melihat semua fotonya." />

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    <x-album-card :album="$album" />
                @endforeach
            </div>

            @if (Route::has('gallery.index'))
                <x-more-button :href="route('gallery.index')" label="Lihat semua album" />
            @endif
        </x-section>
    @endif

    {{-- ===== Struktur Dukuh (tetap di bagian bawah) ===== --}}
    @if ($officials->isNotEmpty())
        @php
            $head = $officials->first();
            $members = $officials->skip(1);
        @endphp

        <x-section tone="white" id="struktur">
            <x-section-heading title="Struktur Dukuh" subtitle="Perangkat yang melayani dan menggerakkan warga." />

            <div class="flex justify-center">
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

            <x-more-button :href="route('profile') . '#perangkat'" label="Lihat selengkapnya" />
        </x-section>
    @endif

    {{-- ===== 6. Peta (paling akhir), agenda di sampingnya ===== --}}
    @if ($events->isNotEmpty() || $showLocation)
        <x-section tone="green" id="lokasi">
            <div class="grid items-start gap-10 lg:grid-cols-2">

                @if ($events->isNotEmpty())
                    <div>
                        <x-section-heading title="Agenda Terdekat" subtitle="Kegiatan dukuh yang akan datang."
                            :href="Route::has('events.index') ? route('events.index') : null" />

                        <div class="space-y-4">
                            @foreach ($events as $event)
                                <x-event-card :event="$event" />
                            @endforeach
                        </div>
                    </div>
                @elseif ($showLocation)
                    <div>
                        <x-section-heading title="Temukan Kami" subtitle="Alamat dan kontak dukuh." />

                        <div class="space-y-4 rounded-2xl border border-primary-100 bg-white p-6 shadow-sm">
                            @if ($profile?->address)
                                <p class="whitespace-pre-line">{{ $profile->address }}</p>
                            @endif
                            @if ($profile?->whatsapp_url)
                                <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener"
                                   class="inline-block rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
                                    Chat via WhatsApp
                                </a>
                            @endif
                            <p><a href="{{ route('contact') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-900">Halaman kontak &rarr;</a></p>
                        </div>
                    </div>
                @endif

                @if ($showLocation)
                    <div class="{{ $events->isNotEmpty() || $showLocation ? '' : 'lg:col-span-2' }}">
                        <x-section-heading title="Lokasi" subtitle="Temukan kami di peta." />

                        <x-location-map :profile="$profile" height="h-72 lg:h-80" />

                        @if ($events->isNotEmpty() && $profile?->address)
                            <p class="mt-3 whitespace-pre-line text-sm text-muted">{{ $profile->address }}</p>
                        @endif
                    </div>
                @endif

            </div>
        </x-section>
    @endif

</x-layouts.app>