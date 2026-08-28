<?php

namespace App\Filament\Lecturer\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Result;

class LecturerResultsStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Unaweza kuchuja matokeo yaliyowekwa na mwalimu huyu kama una column ya lecturer_id au user_id
        $totalResults = Result::count(); 

        return [
            Stat::make('Matokeo yaliyowekwa', $totalResults)
                ->description('Jumla ya alama za wanafunzi zilizowekwa kwenye mfumo')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('success'),
        ];
    }
}