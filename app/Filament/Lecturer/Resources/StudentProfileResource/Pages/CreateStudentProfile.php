<?php

namespace App\Filament\Lecturer\Resources\StudentProfileResource\Pages;

use App\Filament\Lecturer\Resources\StudentProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentProfile extends CreateRecord
{
    protected static string $resource = StudentProfileResource::class;
}
