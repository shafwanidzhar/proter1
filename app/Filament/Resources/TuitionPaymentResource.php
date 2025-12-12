<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TuitionPaymentResource\Pages;
use App\Filament\Resources\TuitionPaymentResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('Student')
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Forms\Set $set, $state) => $set('user_id', \App\Models\Student::find($state)?->parent_id)),

                Forms\Components\Hidden::make('user_id'),

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

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                Forms\Components\Select::make('status')
                    ->options([
                        'billed' => 'Tagihan Sent',
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('billed')
                    ->required(),

                Forms\Components\FileUpload::make('proof_image')
                    ->image()
                    ->directory('tuition-payments')
                    ->openable()
                    ->visible(fn($state) => $state),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('Student')->searchable(),
                Tables\Columns\TextColumn::make('month'),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('amount')->numeric(decimalPlaces: 0)->prefix('Rp ')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'verified' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        'billed' => 'gray',
                    }),
                Tables\Columns\ImageColumn::make('proof_image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'billed' => 'Tagihan Sent',
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTuitionPayments::route('/'),
            'create' => Pages\CreateTuitionPayment::route('/create'),
            'edit' => Pages\EditTuitionPayment::route('/{record}/edit'),
        ];
    }
}
