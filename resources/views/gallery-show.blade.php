<x-layouts.app :title="$album->title" :description="$album->description" :image="$album->cover_url">
    <x-page-header eyebrow="Galeri" :title="$album->title"
        :subtitle="$album->documentation_date?->locale('id')->translatedFormat('j F Y')" />

    <div class="mx-auto max-w-6xl px-4 pt-12" style="display: flex; flex-direction: column; gap: 2.5rem;">
        <a href="{{ route('gallery.index') }}" class="inline-block w-fit text-sm font-semibold text-primary-700 hover:text-primary-900">&larr; Semua album</a>

        @if ($album->description)
            <section aria-label="Tentang album"
                     class="relative w-full overflow-hidden rounded-2xl border border-white/70 bg-white/90 p-6 shadow-lg ring-1 ring-primary-100 backdrop-blur-md sm:p-8">
                <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent-500 to-primary-600" aria-hidden="true"></span>

                <div class="flex items-center gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white shadow-md">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </span>
                    <h2 class="font-display text-xl font-bold text-primary-900">Tentang Album</h2>
                </div>

                <p class="mt-5 whitespace-pre-line text-base leading-7 text-ink/90 sm:text-justify lg:text-lg lg:leading-8">{{ $album->description }}</p>
            </section>
        @endif

        @if ($photos->isNotEmpty())
            <section aria-label="Foto">
                <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($photos as $photo)
                        <li>
                            <a href="{{ $photo->file_url }}" data-lightbox="album"
                               data-caption="{{ $photo->title ?: $album->title }}"
                               class="block aspect-square overflow-hidden rounded-xl bg-primary-50">
                                <img src="{{ $photo->file_url }}" alt="{{ $photo->title ?: $album->title }}" loading="lazy" decoding="async"
                                     class="h-full w-full object-cover transition duration-300 hover:scale-105">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($videos->isNotEmpty())
            <section aria-labelledby="video">
                <h2 id="video" class="font-display text-2xl font-bold text-primary-900">Video</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    @foreach ($videos as $video)
                        <figure>
                            <div class="aspect-video overflow-hidden rounded-xl bg-black">
                                <iframe src="{{ $video->youtube_embed_url }}" title="{{ $video->title ?: 'Video ' . $album->title }}"
                                        class="h-full w-full" loading="lazy" allowfullscreen
                                        allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"></iframe>
                            </div>
                            @if ($video->title)
                                <figcaption class="mt-2 text-sm text-muted">{{ $video->title }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($photos->isEmpty() && $videos->isEmpty())
            <p class="rounded-2xl border border-dashed border-primary-200 bg-white p-10 text-center text-muted">
                Album ini belum berisi foto atau video.
            </p>
        @endif
    </div>

    <x-lightbox />
</x-layouts.app>