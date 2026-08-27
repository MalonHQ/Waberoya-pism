<?php

namespace App\Filament\Lecturer\Widgets;

use Filament\Widgets\Widget;

class LecturerWelcomeWidget extends Widget
{
    protected static string $view = 'filament.lecturer.widgets.lecturer-welcome-widget';

    protected static ?int $sort = -2;

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}