<x-layouts.app title="Artikel" description="Berita, kegiatan, dan pengumuman terbaru dari dukuh.">
    <x-page-header eyebrow="Artikel" title="Kabar dari Dukuh" subtitle="Berita, kegiatan, dan pengumuman terbaru." />

    <div class="mx-auto max-w-6xl px-4 pt-10">

        {{-- Filter kategori --}}
        <nav aria-label="Filter kategori" class="flex flex-wrap gap-2">
            <a href="{{ route('articles.index') }}"
               @if (! $category) aria-current="page" @endif
               class="rounded-full px-4 py-2 text-sm font-semibold transition {{ ! $category ? 'bg-primary-700 text-white' : 'bg-white text-primary-800 ring-1 ring-primary-200 hover:bg-primary-100' }}">
                Semua
            </a>
            @foreach (\App\Models\Article::CATEGORIES as $key => $label)
                <a href="{{ route('articles.index', ['kategori' => $key]) }}"
                   @if ($category === $key) aria-current="page" @endif
                   class="rounded-full px-4 py-2 text-sm font-semibold transition {{ $category === $key ? 'bg-primary-700 text-white' : 'bg-white text-primary-800 ring-1 ring-primary-200 hover:bg-primary-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="mt-10">
            @if ($articles->isEmpty())
                <p class="rounded-2xl border border-dashed border-primary-200 bg-white p-10 text-center text-muted">
                    Belum ada artikel{{ $category ? ' di kategori ini' : '' }}.
                </p>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <div id="artikel-{{ $loop->iteration }}" class="scroll-mt-24">
                            <x-article-card :article="$article" />
                        </div>
                    @endforeach
                </div>

                @if ($hasMore)
                    <x-more-button
                        :href="route('articles.index', array_filter(['kategori' => $category, 'tampil' => $nextLimit])) . '#artikel-' . ($limit + 1)"
                        label="Tampilkan lebih banyak" />
                @endif
            @endif
        </div>
    </div>
</x-layouts.app>