<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        return [
            Stat::make('新增用户', '-')
                ->description('-')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('UV', '-')
                ->description('-')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('PV', '-')
                ->description('-')
                ->descriptionColor('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
        ];
    }
}
