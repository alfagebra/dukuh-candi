@php
    $siteName = $profile?->name ?? config('site.name');
    $sanggarName = config('site.sanggar.name');
    $sanggarUrl = config('site.sanggar.url');
@endphp

<x-layouts.app title="Budaya dan Kesenian" :description="'Kesenian dan tradisi ' . $siteName . ' dikelola dan didokumentasikan oleh sanggar.'">

    <x-page-header eyebrow="Budaya & Kesenian" :title="'Kesenian dan tradisi ' . $siteName" />

    <div class="mx-auto max-w-6xl px-4 pt-14">

        <div class="mx-auto max-w-2xl text-center">
            <span class="mx-auto block h-1 rounded-full bg-accent-500" style="width: 3rem;" aria-hidden="true"></span>
            <p class="mt-5 text-lg leading-relaxed text-ink/90">
                Kegiatan kesenian dukuh dikelola dan didokumentasikan oleh sanggar. Informasi lengkapnya
                tersedia di website sanggar.
            </p>
        </div>

        <article class="group relative overflow-hidden rounded-3xl border border-white/70 bg-white/90 shadow-lg ring-1 ring-primary-100 backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:shadow-xl md:flex" style="margin-top: 3rem;">
            <span class="absolute inset-x-0 top-0 z-10 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

            <div class="relative isolate flex items-center justify-center overflow-hidden bg-gradient-to-br from-soil-700 to-soil-900 p-10 text-center text-white md:w-2/5">
                <div class="bg-pattern-dots absolute inset-0 -z-10"></div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-400">Sanggar</p>
                    <p class="mt-2 font-display text-3xl font-bold">{{ $sanggarName }}</p>
                    <p class="mt-2 text-sm text-primary-200">{{ $siteName }}</p>
                </div>
            </div>

            <div class="flex flex-col justify-center p-8 md:w-3/5 lg:p-10">
                <h2 class="font-display text-2xl font-bold text-primary-900">Kunjungi website sanggar</h2>
                <p class="mt-3 leading-relaxed text-muted sm:text-justify">
                    Website sanggar menjadi pusat informasi kesenian dukuh. Buka untuk melihat kegiatan dan
                    dokumentasi terbaru.
                </p>
                <a href="{{ $sanggarUrl }}" target="_blank" rel="noopener"
                   class="mt-6 inline-flex w-fit items-center rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
                    Buka Website Sanggar &rarr;
                </a>
            </div>
        </article>

    </div>
</x-layouts.app>