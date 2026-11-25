@php
    $shareLink = 'https://wa.me/?text=' . rawurlencode($article->title . ' ' . url()->current());
@endphp

<x-layouts.app :title="$article->seo_title" :description="$article->seo_description" :image="$article->image_url">
    <article class="mx-auto max-w-3xl px-4 pt-10">
        <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-900">&larr; Semua artikel</a>

        <header class="mt-6">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('articles.index', ['kategori' => $article->category]) }}"
                   class="rounded-full bg-primary-100 px-3 py-1 font-semibold text-primary-800 hover:bg-primary-200">{{ $article->category_label }}</a>
                @if ($article->published_date)
                    <time datetime="{{ $article->published_at->toDateString() }}" class="text-muted">{{ $article->published_date }}</time>
                @endif
            </div>

            <h1 class="mt-4 font-display text-3xl font-bold leading-tight text-primary-900 sm:text-4xl">{{ $article->title }}</h1>

            @if ($article->excerpt)
                <p class="mt-4 text-lg leading-relaxed text-muted">{{ $article->excerpt }}</p>
            @endif
        </header>

        @if ($article->image_url)
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" decoding="async" fetchpriority="high"
                 class="mt-8 aspect-[16/9] w-full rounded-2xl object-cover">
        @endif

        <div class="prose-dukuh mt-8">
            {!! $article->content_html !!}
        </div>

        <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-primary-100 pt-6">
            <span class="text-sm font-semibold text-primary-900">Bagikan:</span>
            <a href="{{ $shareLink }}" target="_blank" rel="noopener"
               class="rounded-full border border-primary-700 px-4 py-2 text-sm font-semibold text-primary-800 transition hover:bg-primary-100">
                WhatsApp
            </a>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 pt-16">
            <x-section-heading title="Artikel Lainnya" />
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    <x-article-card :article="$item" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>