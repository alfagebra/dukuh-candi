<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardGreeting extends Widget
{
    protected static ?int $sort = -10;

    protected string $view = 'widgets.dashboard-greeting';

    protected int | string | array $columnSpan = 'full';
}