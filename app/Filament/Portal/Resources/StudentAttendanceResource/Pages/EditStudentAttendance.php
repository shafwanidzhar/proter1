<?php

namespace App\Filament\Portal\Resources\StudentAttendanceResource\Pages;

use App\Filament\Portal\Resources\StudentAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentAttendance extends EditRecord
{
    protected static string $resource = StudentAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
