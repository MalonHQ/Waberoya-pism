<?php

namespace App\Filament\Lecturer\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LecturerResultsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Matokeo yaliyowekwa', '120')
                ->description('Jumla ya alama za wanafunzi ulizoingiza')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('success'),
        ];
    }
}