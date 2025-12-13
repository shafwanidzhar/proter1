<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Jadwal Belajar';

    public static function canViewAny(): bool
    {
        return auth()->user()->role !== 'parent';
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'teacher';
    }


    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user->role === 'teacher') {
            return parent::getEloquentQuery()->where('teacher_id', $user->id);
        }
        return parent::getEloquentQuery()->whereIn('class', \App\Models\Student::where('parent_id', $user->id)->pluck('class'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ])
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->format('H:i')
                    ->native(false)
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->format('H:i')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->label('Mata Pelajaran')
                    ->required(),
                Forms\Components\Hidden::make('teacher_id')
                    ->default(fn() => auth()->id()),
                Forms\Components\TextInput::make('class')
                    ->label('Kelas')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day')
                    ->label('Hari')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru')
                    ->searchable(),
                Tables\Columns\TextColumn::make('class')
                    ->label('Kelas')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
        ];
    }
}
