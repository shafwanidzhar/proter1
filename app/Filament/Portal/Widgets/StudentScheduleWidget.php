<?php

namespace App\Filament\Portal\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Schedule;
use App\Models\Student;

class StudentScheduleWidget extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'parent';
    }

    protected static ?string $heading = 'Jadwal Mengajar';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Schedule::whereIn('class', Student::where('parent_id', auth()->id())->pluck('class'))
            )
            ->columns([
                Tables\Columns\TextColumn::make('day')->label('Hari'),
                Tables\Columns\TextColumn::make('start_time')->time('H:i')->label('Mulai'),
                Tables\Columns\TextColumn::make('end_time')->time('H:i')->label('Selesai'),
                Tables\Columns\TextColumn::make('subject')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('teacher.name')->label('Guru'),
                Tables\Columns\TextColumn::make('class')->label('Kelas'),
            ]);
    }
}
