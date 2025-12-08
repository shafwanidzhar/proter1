<?php

namespace App\Filament\Portal\Resources\TuitionPaymentResource\Pages;

use App\Filament\Portal\Resources\TuitionPaymentResource;
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
