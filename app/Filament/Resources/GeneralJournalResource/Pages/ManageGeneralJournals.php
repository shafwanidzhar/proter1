<?php

namespace App\Filament\Resources\GeneralJournalResource\Pages;

use App\Filament\Resources\GeneralJournalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGeneralJournals extends ManageRecords
{
    protected static string $resource = GeneralJournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
