@php
    $siteName = $profile?->name ?? config('site.name');
    $sanggarName = config('site.sanggar.name');
    $sanggarUrl = config('site.sanggar.url');
@endphp

<x-layouts.app title="Budaya dan Kesenian" :description="'Kesenian dan tradisi ' . $siteName . ' dikelola dan didokumentasikan oleh sanggar.'">

    <section class="bg-soil-900 text-white">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:py-20">
            <p class="text-sm font-semibold uppercase tracking-widest text-accent-400">Budaya &amp; Kesenian</p>
            <h1 class="mt-2 max-w-3xl font-display text-3xl font-bold sm:text-5xl">Kesenian dan tradisi {{ $siteName }}</h1>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-4 pt-14">
        <p class="max-w-3xl text-lg leading-relaxed">
            Kegiatan kesenian dukuh dikelola dan didokumentasikan oleh sanggar. Informasi lengkapnya
            tersedia di website sanggar.
        </p>

        <article class="mt-10 overflow-hidden rounded-3xl border border-primary-100 bg-white shadow-sm md:flex">
            <div class="flex items-center justify-center bg-gradient-to-br from-soil-700 to-soil-900 p-10 text-center text-white md:w-2/5">
                <div>
                    <p class="font-display text-3xl font-bold">{{ $sanggarName }}</p>
                    <p class="mt-2 text-sm text-primary-200">{{ $siteName }}</p>
                </div>
            </div>

            <div class="p-8 md:w-3/5">
                <h2 class="font-display text-2xl font-bold text-primary-900">Kunjungi website sanggar</h2>
                <p class="mt-3 leading-relaxed text-muted">
                    Website sanggar menjadi pusat informasi kesenian dukuh. Buka untuk melihat kegiatan dan
                    dokumentasi terbaru.
                </p>
                <a href="{{ $sanggarUrl }}" target="_blank" rel="noopener"
                   class="mt-6 inline-block rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
                    Buka Website Sanggar &rarr;
                </a>
            </div>
        </article>
    </div>
</x-layouts.app>