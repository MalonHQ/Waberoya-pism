<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use App\Models\StudentProfile;
use App\Models\AcademicYear;
use App\Models\Semester;

class CustomDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard ya Mwanafunzi';
    protected static ?int $navigationSort = 1; // Inaweka hii kuwa ya kwanza kabisa

    protected static string $view = 'filament.student.pages.custom-dashboard';

    public function getViewData(): array
    {
        $user = auth()->user();
        
        $studentProfile = StudentProfile::where('user_id', $user->id)
            ->with(['department'])
            ->first();

        return [
            'studentProfile' => $studentProfile,
            'record' => $studentProfile,
            'activeAcademicYear' => AcademicYear::where('is_active', true)->first(),
            'activeSemester' => Semester::where('is_active', true)->first(),
        ];
    }
}