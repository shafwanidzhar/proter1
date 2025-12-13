<?php

namespace App\Filament\Portal\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Schedule;

class TeacherScheduleWidget extends BaseWidget
{
    protected static ?string $heading = 'Jadwal Mengajar';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->role === 'teacher';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Schedule::where('teacher_id', auth()->id())
            )
            ->columns([
                Tables\Columns\TextColumn::make('class')->label('Kelas'),
                Tables\Columns\TextColumn::make('subject')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('time')
                    ->label('Waktu')
                    ->getStateUsing(fn(Schedule $record) => \Carbon\Carbon::parse($record->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($record->end_time)->format('H:i')),
            ]);
    }
}
