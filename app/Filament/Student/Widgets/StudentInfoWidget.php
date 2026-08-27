<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\Widget;
use App\Models\StudentProfile;
use App\Models\AcademicYear;
use App\Models\Semester;

class StudentInfoWidget extends Widget
{
    protected static string $view = 'filament.student.widgets.student-info-widget';
    protected static ?int $sort = 2; 

    // Hii inafanya widget icheze kwenye safu nzima (full width) chini ya Welcome
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = auth()->user();
        // Hapa tumebadilisha kutoka 'course' kwenda 'department' kulingana na database yako
        $studentProfile = StudentProfile::where('user_id', $user->id)->with('department')->first();

        $activeAcademicYear = AcademicYear::where('is_active', true)->first();
        $activeSemester = Semester::where('is_active', true)->first();

        return [
            'studentProfile' => $studentProfile,
            'activeAcademicYear' => $activeAcademicYear,
            'activeSemester' => $activeSemester,
        ];
    }
}