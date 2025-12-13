<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\StudentAttendance;

class TeacherStatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'teacher';
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        $class = $user->class;

        $totalStudents = Student::where('class', $class)->count();

        $todaySchedule = Schedule::where('teacher_id', $user->id)
            ->where('day', now()->locale('id')->dayName)
            ->count();

        $attendanceCount = StudentAttendance::whereHas('student', fn($q) => $q->where('class', $class))
            ->where('date', now()->toDateString())
            ->where('status', 'present')
            ->count();

        $attendanceRate = $totalStudents > 0 ? round(($attendanceCount / $totalStudents) * 100) . '%' : '0%';

        return [
            Stat::make('Total Siswa', $totalStudents)
                ->description('Siswa di kelas ' . $class)
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Jadwal Hari Ini', $todaySchedule . ' Sesi')
                ->description('Sesi mengajar hari ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Absensi', $attendanceCount . ' / ' . $totalStudents)
                ->description('Kehadiran hari ini')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Saldo Kas', 'Rp 500.000') // Placeholder
                ->description('Kas kelas ' . $class)
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}
