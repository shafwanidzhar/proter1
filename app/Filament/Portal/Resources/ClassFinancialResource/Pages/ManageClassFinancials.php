<?php

namespace App\Filament\Portal\Resources\ClassFinancialResource\Pages;

use App\Filament\Portal\Resources\ClassFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClassFinancials extends ManageRecords
{
    protected static string $resource = ClassFinancialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
