<x-layouts.app title="Halaman tidak ditemukan">
    <div class="mx-auto max-w-2xl px-4 py-24 text-center">
        <p class="font-display text-7xl font-bold text-primary-200">404</p>
        <h1 class="mt-4 font-display text-2xl font-bold text-primary-900 sm:text-3xl">Halaman tidak ditemukan</h1>
        <p class="mt-3 text-muted">Maaf, halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
        <a href="{{ route('home') }}" class="mt-8 inline-block rounded-full bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-800">
            Kembali ke Beranda
        </a>
    </div>
</x-layouts.app>