@props(['article'])

@php
    $url = \Illuminate\Support\Facades\Route::has('articles.show') ? route('articles.show', $article->slug) : null;
@endphp

<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-primary-100 bg-white shadow-sm transition hover:shadow-md">
    <div class="aspect-[16/9] overflow-hidden bg-primary-50">
        @if ($article->image_url)
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-4xl text-primary-200" aria-hidden="true">&#9998;</div>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex flex-wrap items-center gap-2 text-xs">
            <span class="rounded-full bg-primary-100 px-3 py-1 font-semibold text-primary-800">{{ $article->category_label }}</span>
            @if ($article->published_date)
                <time datetime="{{ $article->published_at->toDateString() }}" class="text-muted">{{ $article->published_date }}</time>
            @endif
        </div>

        <h3 class="mt-3 font-display text-lg font-bold leading-snug text-primary-900">
            @if ($url)
                <a href="{{ $url }}" class="after:absolute after:inset-0">{{ $article->title }}</a>
            @else
                {{ $article->title }}
            @endif
        </h3>

        @if ($article->excerpt)
            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-muted">{{ $article->excerpt }}</p>
        @endif
    </div>
</article>