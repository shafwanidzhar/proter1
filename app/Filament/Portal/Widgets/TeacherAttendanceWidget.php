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
        $lateThreshold = now()->setTime(8, 0, 0); // 08:00 AM
        $status = $now->gt($lateThreshold) ? 'late' : 'present';

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
