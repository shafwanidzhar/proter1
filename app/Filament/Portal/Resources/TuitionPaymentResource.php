<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\TuitionPaymentResource\Pages;
use App\Filament\Portal\Resources\TuitionPaymentResource\RelationManagers;
use App\Models\TuitionPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TuitionPaymentResource extends Resource
{
    protected static ?string $model = TuitionPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()->role, ['parent', 'headmaster']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name', function ($query) {
                        // If parent, only show their students
                        if (auth()->user()->role === 'parent') {
                            return $query->where('parent_id', auth()->id());
                        }
                        return $query;
                    })
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),
                Forms\Components\Select::make('month')
                    ->options([
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->default(date('Y'))
                    ->required(),
                Forms\Components\FileUpload::make('proof_image')
                    ->image()
                    ->directory('tuition-proofs'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->visible(fn() => auth()->user()->role !== 'parent'), // Parent cannot change status
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('Murid'),
                Tables\Columns\TextColumn::make('amount')->money('IDR'),
                Tables\Columns\TextColumn::make('month'),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\ImageColumn::make('proof_image'),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->role === 'parent') {
            // Show payments for students belonging to this parent
            $query->whereHas('student', function ($q) {
                $q->where('parent_id', auth()->id());
            });
        }

        return $query;
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
            'index' => Pages\ListTuitionPayments::route('/'),
            'create' => Pages\CreateTuitionPayment::route('/create'),
            'edit' => Pages\EditTuitionPayment::route('/{record}/edit'),
        ];
    }
}
