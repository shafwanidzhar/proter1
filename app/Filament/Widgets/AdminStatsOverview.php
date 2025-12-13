<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $income = \App\Models\TuitionPayment::where('status', 'verified')->sum('amount');
        $expense = \App\Models\Expense::sum('amount');
        $balance = $income - $expense;

        return [
            Stat::make('Total Students', \App\Models\Student::count())
                ->description('Total registered students')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Total Teachers', \App\Models\User::where('role', 'teacher')->count())
                ->description('Total registered teachers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Saldo Kas Sekolah', 'Rp ' . number_format($balance, 0, ',', '.'))
                ->description('Total Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($balance >= 0 ? 'success' : 'danger'),
        ];
    }
}
