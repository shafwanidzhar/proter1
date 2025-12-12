<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpenseAnomalyWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $expenses = \App\Models\Expense::all();

                if ($expenses->count() < 2) {
                    return \App\Models\Expense::query()->whereRaw('1 = 0'); // Return empty
                }

                $avg = $expenses->avg('amount');

                // Calculate Standard Deviation
                $variance = $expenses->map(function ($item) use ($avg) {
                    return pow($item->amount - $avg, 2);
                })->avg();

                $stdDev = sqrt($variance);
                $threshold = $avg + (2 * $stdDev);

                return \App\Models\Expense::query()
                    ->where('amount', '>', $threshold)
                    ->orderBy('amount', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('description')->label('Description'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(decimalPlaces: 0)
                    ->prefix('Rp ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('category')->badge(),
            ])
            ->heading('Expense Anomalies (High Value Transactions)');
    }
}
