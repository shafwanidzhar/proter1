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
        return auth()->check() && auth()->user()->role === 'parent';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('student_name')
                    ->label('Student')
                    ->formatStateUsing(fn($record) => $record->student->name)
                    ->readOnly(),

                Forms\Components\TextInput::make('month')
                    ->readOnly(),

                Forms\Components\TextInput::make('year')
                    ->readOnly(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly(),

                Forms\Components\Placeholder::make('status_display')
                    ->label('Status')
                    ->content(fn($record) => $record->status),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('Student'),
                Tables\Columns\TextColumn::make('month'),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('amount')->numeric(decimalPlaces: 0)->prefix('Rp '),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'verified' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        'billed' => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('pay')
                    ->label('Pay Now')
                    ->icon('heroicon-o-credit-card')
                    ->color('primary')
                    ->visible(fn($record) => $record->status === 'billed' || $record->status === 'rejected')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Apakah anda yakin ingin membayar tagihan ini? Status akan langsung berubah menjadi Lunas.')
                    ->action(function ($record) {
                        $record->update(['status' => 'verified']);

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Berhasil')
                            ->body('Terima kasih, pembayaran anda telah berhasil.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check() && auth()->user()->role === 'parent') {
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
            'edit' => Pages\EditTuitionPayment::route('/{record}/edit'),
        ];
    }
}
