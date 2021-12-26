<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Game extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static string $view = 'filament.pages.game';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = '游戏库';
}
