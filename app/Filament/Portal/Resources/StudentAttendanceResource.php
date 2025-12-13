<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\StudentAttendanceResource\Pages;
use App\Models\StudentAttendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentAttendanceResource extends Resource
{
    protected static ?string $model = StudentAttendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Absensi Siswa';
    protected static ?string $modelLabel = 'Absensi Siswa';
    protected static ?string $pluralModelLabel = 'Absensi Siswa';


    public static function canCreate(): bool
    {
        return auth()->user()->role === 'teacher';
    }
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user->role === 'teacher') {
            return parent::getEloquentQuery()->whereHas('student', function ($q) use ($user) {
                $q->where('class', $user->class);
            });
        }
        return parent::getEloquentQuery()->whereIn('student_id', \App\Models\Student::where('parent_id', $user->id)->pluck('id'));
    }

    public static function form(Form $form): Form
    {
        $isTeacher = auth()->user()->role === 'teacher';

        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now())
                    ->disabled(!$isTeacher),
                Forms\Components\Select::make('student_id')
                    ->label('Nama Siswa')
                    ->relationship('student', 'name', function (Builder $query) {
                        $user = auth()->user();
                        if ($user->role === 'teacher') {
                            return $query->where('class', $user->class);
                        }
                        return $query;
                    })
                    ->required()
                    ->disabled(!$isTeacher),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'present' => 'Hadir',
                        'permission' => 'Izin',
                        'sick' => 'Sakit',
                        'alpha' => 'Alpha',
                    ])
                    ->required()
                    ->disabled(!$isTeacher),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isTeacher = auth()->user()->role === 'teacher';

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'present' => 'success',
                        'permission' => 'warning',
                        'sick' => 'info',
                        'alpha' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible($isTeacher),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible($isTeacher),
                ]),
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
            'index' => Pages\ListStudentAttendances::route('/'),
            'create' => Pages\CreateStudentAttendance::route('/create'),
            'edit' => Pages\EditStudentAttendance::route('/{record}/edit'),
        ];
    }
}
