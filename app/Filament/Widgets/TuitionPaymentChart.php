<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TuitionPayment;
use Filament\Support\Colors\Color;

class TuitionPaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Pembayaran Siswa';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $paid = TuitionPayment::where('status', 'verified')->count();
        $unpaid = TuitionPayment::where('status', '!=', 'verified')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Pembayaran',
                    'data' => [$paid, $unpaid],
                    'backgroundColor' => ['#10b981', '#ef4444'],
                ],
            ],
            'labels' => ['Lunas', 'Belum Lunas'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
