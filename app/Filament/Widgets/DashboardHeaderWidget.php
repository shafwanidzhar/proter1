<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHeaderWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-header-widget';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 0;
}
