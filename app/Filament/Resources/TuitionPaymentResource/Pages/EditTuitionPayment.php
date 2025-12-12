<?php

namespace App\Filament\Resources\TuitionPaymentResource\Pages;

use App\Filament\Resources\TuitionPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTuitionPayment extends EditRecord
{
    protected static string $resource = TuitionPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
