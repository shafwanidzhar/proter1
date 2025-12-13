<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\TuitionPayment;

class ParentStatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'parent';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Anak', Student::where('parent_id', auth()->id())->count())
                ->description('Jumlah anak terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Total Pembayaran', 'Rp ' . number_format(TuitionPayment::whereHas('student', fn($q) => $q->where('parent_id', auth()->id()))->where('status', 'verified')->sum('amount'), 0, ',', '.'))
                ->description('Total pembayaran lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Total Tagihan', 'Rp ' . number_format(TuitionPayment::whereHas('student', fn($q) => $q->where('parent_id', auth()->id()))->where('status', 'billed')->sum('amount'), 0, ',', '.'))
                ->description(TuitionPayment::whereHas('student', fn($q) => $q->where('parent_id', auth()->id()))->where('status', 'billed')->count() > 0 ? 'Tagihan belum dibayar' : 'Tidak ada tagihan aktif')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color(TuitionPayment::whereHas('student', fn($q) => $q->where('parent_id', auth()->id()))->where('status', 'billed')->count() > 0 ? 'danger' : 'success'),
        ];
    }
}
