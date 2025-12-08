<?php

namespace App\Filament\Portal\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TeacherScheduleWidget extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'teacher';
    }

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Dummy query since we don't have a Schedule model
                \App\Models\Student::query()->limit(3)
            )
            ->heading('Jadwal Mengajar')
            ->columns([
                Tables\Columns\TextColumn::make('class')->label('Kelas')->default('TK A'),
                Tables\Columns\TextColumn::make('subject')->label('Mata Pelajaran')->default('Matematika'),
                Tables\Columns\TextColumn::make('time')->label('Waktu')->default('08:00 - 09:00'),
            ]);
    }
}
