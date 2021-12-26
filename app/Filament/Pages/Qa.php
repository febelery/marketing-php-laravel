<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class Qa extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.qa';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = '答题';

}
