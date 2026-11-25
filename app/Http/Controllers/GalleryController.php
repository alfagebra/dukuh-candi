<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private const STEP = 6;

    public function index(Request $request)
    {
        $limit = min(max((int) $request->query('tampil', self::STEP), self::STEP), 60);

        $items = GalleryAlbum::published()
            ->with('items')
            ->orderBy('sort_order')
            ->orderByDesc('documentation_date')
            ->limit($limit + 1)
            ->get();

        return view('gallery-index', [
            'albums' => $items->take($limit),
            'hasMore' => $items->count() > $limit,
            'limit' => $limit,
            'nextLimit' => $limit + self::STEP,
        ]);
    }

    public function show(string $slug)
    {
        $album = GalleryAlbum::published()->with('items')->where('slug', $slug)->firstOrFail();

        return view('gallery-show', [
            'album' => $album,
            'photos' => $album->items->where('type', GalleryItem::TYPE_PHOTO)->values(),
            'videos' => $album->items
                ->where('type', GalleryItem::TYPE_VIDEO)
                ->filter(fn (GalleryItem $item) => $item->youtube_embed_url)
                ->values(),
        ]);
    }
}