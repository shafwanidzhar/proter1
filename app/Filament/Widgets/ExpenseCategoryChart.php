<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Expense;

class ExpenseCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Pengeluaran per Kategori';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Expense::selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran',
                    'data' => array_values($data),
                    'backgroundColor' => ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
