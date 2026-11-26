<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/profil', [PageController::class, 'profile'])->name('profile');
Route::get('/budaya', [PageController::class, 'culture'])->name('culture');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

Route::get('/debug-env', function () {
    return [
        's3_key_set'     => filled(env('S3_KEY')),
        'config_key_set' => filled(config('filesystems.disks.s3.key')),
        'bucket'         => config('filesystems.disks.s3.bucket'),
        'endpoint'       => config('filesystems.disks.s3.endpoint'),
    ];
});