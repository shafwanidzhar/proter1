<?php

namespace App\Filament\Portal\Resources\TuitionPaymentResource\Pages;

use App\Filament\Portal\Resources\TuitionPaymentResource;
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
