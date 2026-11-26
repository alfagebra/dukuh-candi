<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getTitle(): string|Htmlable
    {
        return 'Masuk';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Selamat datang kembali';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Masuk untuk mengelola konten website.';
    }
}