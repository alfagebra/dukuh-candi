<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    private const STEP = 6;

    public function index(Request $request)
    {
        $limit = min(max((int) $request->query('tampil', self::STEP), self::STEP), 60);

        // Ambil satu lebih banyak untuk tahu apakah masih ada yang belum tampil.
        $items = Umkm::published()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit($limit + 1)
            ->get();

        return view('umkm-index', [
            'umkms' => $items->take($limit),
            'hasMore' => $items->count() > $limit,
            'limit' => $limit,
            'nextLimit' => $limit + self::STEP,
        ]);
    }

    public function show(string $slug)
    {
        $umkm = Umkm::published()->with('photos')->where('slug', $slug)->firstOrFail();

        return view('umkm-show', [
            'umkm' => $umkm,
            'profile' => Profile::cached(),
        ]);
    }
}