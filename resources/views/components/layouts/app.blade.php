@props(['title' => null, 'description' => null, 'image' => null, 'flush' => false])

@php
    $site = \App\Models\Profile::cached();
    $siteName = $site?->name ?? config('site.name');

    $pageTitle = $title
        ? $title . ' — ' . $siteName
        : ($site?->tagline ? $siteName . ' — ' . $site->tagline : $siteName);

    $metaDescription = \Illuminate\Support\Str::limit(
        strip_tags($description ?: ($site?->tagline ?: 'Website resmi ' . $siteName . ': profil, UMKM, budaya, galeri, dan kabar terbaru.')),
        160
    );

    $metaImage = $image ?: $site?->cover_image_url;

    // Menu hanya tampil kalau halamannya sudah ada, jadi tidak ada tautan mati.
    $navItems = collect([
        ['label' => 'Beranda', 'route' => 'home', 'match' => 'home'],
        ['label' => 'Profil', 'route' => 'profile', 'match' => 'profile'],
        ['label' => 'UMKM', 'route' => 'umkm.index', 'match' => 'umkm.*'],
        ['label' => 'Budaya', 'route' => 'culture', 'match' => 'culture'],
        ['label' => 'Galeri', 'route' => 'gallery.index', 'match' => 'gallery.*'],
        ['label' => 'Artikel', 'route' => 'articles.index', 'match' => 'articles.*'],
        ['label' => 'Agenda', 'route' => 'events.index', 'match' => 'events.*'],
        ['label' => 'Kontak', 'route' => 'contact', 'match' => 'contact'],
    ])->filter(fn ($item) => \Illuminate\Support\Facades\Route::has($item['route']));
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-cream font-sans text-ink antialiased">
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-3 focus:py-2 focus:text-primary-800">
        Lewati ke konten
    </a>

    {{-- ===== Navigasi ===== --}}
    <header class="sticky top-0 z-40 border-b border-primary-100 bg-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if ($site?->logo_url)
                    <img src="{{ $site->logo_url }}" alt="Logo {{ $siteName }}" class="h-10 w-10 rounded-full object-cover">
                @else
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-700 font-display text-lg font-bold text-white" aria-hidden="true">
                        {{ mb_strtoupper(mb_substr($siteName, 0, 1)) }}
                    </span>
                @endif
                <span class="font-display text-lg font-bold text-primary-900">{{ $siteName }}</span>
            </a>

            <nav class="hidden md:block" aria-label="Menu utama">
                <ul class="flex items-center gap-1">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                               @if (request()->routeIs($item['match'])) aria-current="page" @endif
                               class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs($item['match']) ? 'bg-primary-700 text-white' : 'text-primary-800 hover:bg-primary-100' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <button id="nav-toggle" type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-primary-800 hover:bg-primary-100 md:hidden"
                    aria-expanded="false" aria-controls="mobile-menu" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav id="mobile-menu" class="hidden border-t border-primary-100 md:hidden" aria-label="Menu seluler">
            <ul class="mx-auto flex max-w-6xl flex-col px-4 py-2">
                @foreach ($navItems as $item)
                    <li>
                        <a href="{{ route($item['route']) }}"
                           @if (request()->routeIs($item['match'])) aria-current="page" @endif
                           class="block rounded-lg px-3 py-3 text-base font-semibold {{ request()->routeIs($item['match']) ? 'bg-primary-100 text-primary-900' : 'text-primary-800' }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </header>

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    {{-- ===== Footer ===== --}}
    <footer class="{{ $flush ? '' : 'mt-16' }} bg-primary-900 text-primary-100">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 md:grid-cols-3">
            <div>
                <p class="font-display text-xl font-bold text-white">{{ $siteName }}</p>
                @if ($site?->tagline)
                    <p class="mt-3 text-sm leading-relaxed text-primary-200">{{ $site->tagline }}</p>
                @endif
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-accent-400">Menu</p>
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach ($navItems as $item)
                        <li><a href="{{ route($item['route']) }}" class="hover:text-white">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-accent-400">Kontak</p>
                <ul class="mt-3 space-y-2 text-sm">
                    @if ($site?->address)
                        <li class="whitespace-pre-line">{{ $site->address }}</li>
                    @endif
                    @if ($site?->phone)
                        <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $site->phone) }}" class="hover:text-white">{{ $site->phone }}</a></li>
                    @endif
                    @if ($site?->whatsapp_url)
                        <li><a href="{{ $site->whatsapp_url }}" target="_blank" rel="noopener" class="hover:text-white">WhatsApp: {{ $site->whatsapp }}</a></li>
                    @endif
                    @if ($site?->email)
                        <li><a href="mailto:{{ $site->email }}" class="hover:text-white">{{ $site->email }}</a></li>
                    @endif
                </ul>

                @php
                    $socials = array_filter([
                        'Instagram' => $site?->instagram,
                        'Facebook' => $site?->facebook,
                        'YouTube' => $site?->youtube,
                        'TikTok' => $site?->tiktok,
                    ]);
                @endphp
                @if ($socials)
                    <ul class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-sm">
                        @foreach ($socials as $label => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener" class="underline hover:text-white">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="border-t border-primary-800 py-4 text-center text-xs text-primary-200">
            &copy; {{ now()->year }} {{ $siteName }}. Seluruh hak dilindungi.
        </div>
    </footer>
</body>
</html>