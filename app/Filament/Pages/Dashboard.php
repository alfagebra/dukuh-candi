<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return 'Dashboard';
    }

    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }
}