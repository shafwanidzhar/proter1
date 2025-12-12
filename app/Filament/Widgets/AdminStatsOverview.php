<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', \App\Models\Student::count())
                ->description('Total registered students')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Total Teachers', \App\Models\User::where('role', 'teacher')->count())
                ->description('Total registered teachers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
