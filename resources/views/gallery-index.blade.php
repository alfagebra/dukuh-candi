<x-layouts.app title="Galeri" description="Dokumentasi foto dan video kegiatan dukuh.">
    <x-page-header eyebrow="Galeri" title="Galeri Kegiatan" subtitle="Dokumentasi foto dan video kegiatan dukuh." />

    <div class="mx-auto max-w-6xl px-4 pt-14">
        @if ($albums->isEmpty())
            <p class="rounded-2xl border border-dashed border-primary-200 bg-white p-10 text-center text-muted">
                Belum ada album yang ditampilkan.
            </p>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    <div id="album-{{ $loop->iteration }}" class="scroll-mt-24">
                        <x-album-card :album="$album" />
                    </div>
                @endforeach
            </div>

            @if ($hasMore)
                <x-more-button :href="route('gallery.index', ['tampil' => $nextLimit]) . '#album-' . ($limit + 1)" label="Tampilkan lebih banyak" />
            @endif
        @endif
    </div>
</x-layouts.app>