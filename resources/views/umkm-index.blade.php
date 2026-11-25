<x-layouts.app title="UMKM Warga" description="Daftar usaha warga yang bisa langsung dihubungi lewat WhatsApp.">
    <x-page-header eyebrow="UMKM" title="UMKM Warga" subtitle="Usaha warga yang bisa langsung dihubungi." />

    <div class="mx-auto max-w-6xl px-4 pt-14">
        @if ($umkms->isEmpty())
            <p class="rounded-2xl border border-dashed border-primary-200 bg-white p-10 text-center text-muted">
                Belum ada UMKM yang ditampilkan.
            </p>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($umkms as $umkm)
                    <div id="umkm-{{ $loop->iteration }}" class="scroll-mt-24">
                        <x-umkm-card :umkm="$umkm" />
                    </div>
                @endforeach
            </div>

            @if ($hasMore)
                <x-more-button :href="route('umkm.index', ['tampil' => $nextLimit]) . '#umkm-' . ($limit + 1)" label="Tampilkan lebih banyak" />
            @endif
        @endif
    </div>
</x-layouts.app>