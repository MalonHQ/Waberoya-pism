<?php

namespace App\Filament\Lecturer\Resources\StudentProfileResource\Pages;

use App\Filament\Lecturer\Resources\StudentProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentProfiles extends ListRecords
{
    protected static string $resource = StudentProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
