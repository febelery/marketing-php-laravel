<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        return [
            Card::make('新增用户', '-')
                ->description('-')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('UV', '-')
                ->description('-')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('PV', '-')
                ->description('-')
                ->descriptionColor('danger')
                ->descriptionIcon('heroicon-s-trending-down'),
        ];
    }
}
