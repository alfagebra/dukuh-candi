<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private const STEP = 6;

    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $category = is_string($category) && array_key_exists($category, Article::CATEGORIES)
            ? $category
            : null;

        $limit = min(max((int) $request->query('tampil', self::STEP), self::STEP), 60);

        $items = Article::latestPublished()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->limit($limit + 1)
            ->get();

        return view('articles-index', [
            'articles' => $items->take($limit),
            'category' => $category,
            'hasMore' => $items->count() > $limit,
            'limit' => $limit,
            'nextLimit' => $limit + self::STEP,
        ]);
    }

    public function show(string $slug)
    {
        $article = Article::published()->where('slug', $slug)->firstOrFail();

        // Artikel terkait: kategori yang sama dulu, kalau tidak ada pakai artikel terbaru lainnya.
        $related = Article::latestPublished()
            ->where('category', $article->category)
            ->whereKeyNot($article->id)
            ->limit(3)
            ->get();

        if ($related->isEmpty()) {
            $related = Article::latestPublished()->whereKeyNot($article->id)->limit(3)->get();
        }

        return view('articles-show', compact('article', 'related'));
    }
}