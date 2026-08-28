<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;
use App\Models\StudentProfile;
use App\Models\Result;

class LecturerStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumla ya Masomo', Course::count())
                ->description('Masomo yote kwenye mfumo')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('success'),

            Stat::make('Wanafunzi Waliosajiliwa', StudentProfile::count())
                ->description('Wanafunzi wote hai')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Matokeo Yaliyowekwa', Result::count())
                ->description('Jumla ya alama zilizorekodiwa')
                ->descriptionIcon('heroicon-o-clipboard-document-check')
                ->color('warning'),
        ];
    }
}