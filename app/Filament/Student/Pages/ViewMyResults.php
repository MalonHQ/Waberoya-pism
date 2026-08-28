<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use App\Models\StudentProfile;
use App\Models\AcademicYear;
use App\Models\Semester;

class ViewMyResults extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Matokeo Yangu';
    protected static ?string$title = 'Taarifa na Matokeo Yangu';
    protected static ?int $navigationSort = 2; // Inaweka hii kuwa ya pili kwenye menyu

    protected static string $view = 'filament.student.pages.view-my-results';

    public function getViewData(): array
    {
        $user = auth()->user();
        
        $studentProfile = StudentProfile::where('user_id', $user->id)
            ->with(['department', 'results.course'])
            ->first();

        $activeAcademicYear = AcademicYear::where('is_active', true)->first();
        $activeSemester = Semester::where('is_active', true)->first();

        return [
            'studentProfile' => $studentProfile,
            'record' => $studentProfile,
            'results' => $studentProfile ? $studentProfile->results : collect(),
            'activeAcademicYear' => $activeAcademicYear,
            'activeSemester' => $activeSemester,
        ];
    }
}