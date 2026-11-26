<?php

namespace App\Providers;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Di Vercel semua URL harus https, kalau tidak favicon dan aset
        // diblokir browser sebagai mixed content.
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Semua kolom upload foto di dashboard otomatis dikecilkan di browser
        // (sisi terpanjang maksimal 1600 px, tidak diperbesar) sebelum dikirim
        // ke storage, supaya kuota Supabase Storage tidak cepat habis.
        FileUpload::configureUsing(function (FileUpload $upload): void {
            $upload
                ->automaticallyResizeImagesMode('contain')
                ->automaticallyResizeImagesToWidth('1600')
                ->automaticallyResizeImagesToHeight('1600')
                ->automaticallyUpscaleImagesWhenResizing(false);
        });
    }
}