<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortalStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user->role === 'teacher') {
            $totalStudents = \App\Models\Student::count();
            $attendanceRate = '90%'; // Dummy data for now

            return [
                Stat::make('Total Siswa', $totalStudents)
                    ->description('Total murid aktif')
                    ->icon('heroicon-o-users'),
                Stat::make('Absensi', $attendanceRate)
                    ->description('Kehadiran rata-rata')
                    ->icon('heroicon-o-check-circle'),
                Stat::make('Jadwal Hari Ini', '3 Kelas')
                    ->description('Senin, 8 Des 2025')
                    ->icon('heroicon-o-calendar'),
            ];
        }

        if ($user->role === 'parent') {
            $pendingPayments = \App\Models\TuitionPayment::whereHas('student', function ($q) use ($user) {
                $q->where('parent_id', $user->id);
            })->where('status', 'billed')->sum('amount');

            $description = $pendingPayments > 0 ? 'Menunggu pembayaran' : 'Tidak ada tagihan aktif';
            $color = $pendingPayments > 0 ? 'warning' : 'success';

            return [
                Stat::make('Total Tagihan', 'Rp ' . number_format($pendingPayments, 0, ',', '.'))
                    ->description($description)
                    ->color($color),
            ];
        }

        return [];
    }
}
