<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use App\Models\StudentProfile;

class ViewMyResults extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Matokeo Yangu';
    protected static ?string $title = 'Taarifa na Matokeo Yangu';

    protected static string $view = 'filament.student.pages.view-my-results';

    public function getViewData(): array
    {
        $user = auth()->user();
        // Tunachota StudentProfile pamoja na department na matokeo yake
        $studentProfile = StudentProfile::where('user_id', $user->id)
            ->with(['department', 'results.course'])
            ->first();

        return [
            'studentProfile' => $studentProfile,
            'record' => $studentProfile,
            'results' => $studentProfile ? $studentProfile->results : collect(),
        ];
    }
}