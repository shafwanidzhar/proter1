<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarkAbsentTeachers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark teachers who have not checked in as alpha (absent)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $teachers = \App\Models\User::where('role', 'teacher')->get();

        foreach ($teachers as $teacher) {
            $hasAttendance = $teacher->attendances()->where('date', $today)->exists();

            if (!$hasAttendance) {
                $teacher->attendances()->create([
                    'date' => $today,
                    'status' => 'alpha',
                ]);
                $this->info("Marked {$teacher->name} as alpha.");
            }
        }

        $this->info('Attendance check completed.');
    }
}
