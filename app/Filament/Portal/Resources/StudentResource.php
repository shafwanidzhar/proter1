<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Students';
    protected static ?string $modelLabel = 'Students';
    protected static ?string $pluralModelLabel = 'Students';

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'teacher';
    }


    public static function canViewAny(): bool
    {
        return auth()->user()->role !== 'parent';
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user->role === 'teacher') {
            return parent::getEloquentQuery()->where('class', $user->class);
        }
        return parent::getEloquentQuery()->where('parent_id', $user->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name', fn($query) => $query->where('role', 'parent'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('class')
                    ->default(fn() => auth()->user()->role === 'teacher' ? auth()->user()->class : null)
                    ->readOnly(fn() => auth()->user()->role === 'teacher')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Orang Tua')->searchable(),
                Tables\Columns\TextColumn::make('class'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
