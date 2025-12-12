<?php

namespace App\Filament\Resources\TuitionPaymentResource\Pages;

use App\Filament\Resources\TuitionPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTuitionPayments extends ListRecords
{
    protected static string $resource = TuitionPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
