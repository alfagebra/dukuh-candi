<x-layouts.app :title="$album->title" :description="$album->description" :image="$album->cover_url">
    <x-page-header eyebrow="Galeri" :title="$album->title"
        :subtitle="$album->documentation_date?->locale('id')->translatedFormat('j F Y')" />

    <div class="mx-auto max-w-6xl space-y-14 px-4 pt-12">
        <a href="{{ route('gallery.index') }}" class="inline-block text-sm font-semibold text-primary-700 hover:text-primary-900">&larr; Semua album</a>

        @if ($album->description)
            <p class="max-w-3xl whitespace-pre-line text-lg leading-relaxed">{{ $album->description }}</p>
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