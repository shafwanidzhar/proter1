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
        return [];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        if ($record->status === 'billed' && $record->proof_image) {
            $record->update(['status' => 'pending']);
        }
    }
}
