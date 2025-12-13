<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\Widget;

class TeacherAttendanceWidget extends Widget
{
    protected static string $view = 'filament.portal.widgets.teacher-attendance-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->role === 'teacher';
    }

    public function checkIn()
    {
        $user = auth()->user();
        $today = now()->format('Y-m-d');

        if ($user->attendances()->where('date', $today)->exists()) {
            \Filament\Notifications\Notification::make()
                ->title('Already Checked In')
                ->warning()
                ->send();
            return;
        }

        $now = now();
        $lateThreshold = now()->setTime(12, 0, 0); // 12:00 PM
        $startTime = now()->setTime(7, 0, 0); // 07:00 AM

        if ($now->lt($startTime)) {
            \Filament\Notifications\Notification::make()
                ->title('Belum Waktunya Absen')
                ->body('Absensi dimulai pukul 07:00.')
                ->warning()
                ->send();
            return;
        }

        $status = $now->lte($lateThreshold) ? 'present' : 'late';

        $user->attendances()->create([
            'date' => $today,
            'status' => $status,
            'check_in' => $now->format('H:i:s'),
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Check In Successful')
            ->body('Status: ' . ucfirst($status))
            ->success()
            ->send();
    }

    public function hasCheckedIn(): bool
    {
        return auth()->user()->attendances()->where('date', now()->format('Y-m-d'))->exists();
    }

    public function getCheckInTime(): ?string
    {
        $attendance = auth()->user()->attendances()->where('date', now()->format('Y-m-d'))->first();
        return $attendance ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : null;
    }
}
