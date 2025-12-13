<?php

namespace App\Filament\Portal\Resources\StudentResource\Pages;

use App\Filament\Portal\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
