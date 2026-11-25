<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Official;
use App\Models\Profile;
use App\Models\Umkm;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        $build = fn () => [
            'umkms' => $this->homeUmkms(),
            'articles' => Article::latestPublished()->limit(3)->get(),
            'events' => Event::published()->upcoming()->limit(3)->get(),
            'officials' => Official::active()->limit(8)->get(),
            // Album terbaru yang sudah terbit (satu cover per album).
            'albums' => GalleryAlbum::published()
                ->with('items')
                ->orderBy('sort_order')
                ->orderByDesc('documentation_date')
                ->limit(3)
                ->get(),
        ];

        // Di server produksi data beranda disimpan 2 menit supaya tidak
        // query database berkali-kali. Di komputer lokal selalu data terbaru.
        $data = app()->isProduction()
            ? Cache::remember('home.data', now()->addMinutes(2), $build)
            : $build();

        return view('home', ['profile' => Profile::cached()] + $data);
    }

    public function profile()
    {
        return view('profile', [
            'profile' => Profile::cached(),
            'officials' => Official::active()->get(),
        ]);
    }

    public function culture()
    {
        return view('culture', [
            'profile' => Profile::cached(),
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'profile' => Profile::cached(),
        ]);
    }

    /** UMKM unggulan; kalau belum ada yang ditandai, tampilkan UMKM terbit apa adanya. */
    private function homeUmkms()
    {
        $umkms = Umkm::published()->featured()->orderBy('sort_order')->limit(3)->get();

        if ($umkms->isEmpty()) {
            $umkms = Umkm::published()->orderBy('sort_order')->limit(3)->get();
        }

        return $umkms;
    }
}