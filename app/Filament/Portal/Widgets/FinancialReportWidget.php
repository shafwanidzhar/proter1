<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialReportWidget extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'headmaster';
    }

    protected function getStats(): array
    {
        $income = \App\Models\TuitionPayment::where('status', 'approved')->sum('amount');
        $expense = \App\Models\Payroll::sum('amount');
        $net = $income - $expense;

        return [
            Stat::make('Total Pemasukan (SPP)', 'Rp ' . number_format($income, 0, ',', '.'))
                ->description('Total SPP yang sudah lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Pengeluaran (Gaji)', 'Rp ' . number_format($expense, 0, ',', '.'))
                ->description('Total gaji guru')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Pendapatan Bersih', 'Rp ' . number_format($net, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->color($net >= 0 ? 'success' : 'danger'),
        ];
    }
}
