<?php

namespace App\Filament\Portal\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.portal.widgets.welcome-widget';

    protected int|string|array $columnSpan = 'full';
}
