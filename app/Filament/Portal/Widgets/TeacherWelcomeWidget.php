<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\Widget;

class TeacherWelcomeWidget extends Widget
{
    protected static string $view = 'filament.portal.widgets.teacher-welcome-widget';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->role === 'teacher';
    }
}
