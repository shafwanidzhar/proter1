<?php

namespace App\Filament\Portal\Resources\ReportResource\Pages;

use App\Filament\Portal\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReports extends ManageRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
