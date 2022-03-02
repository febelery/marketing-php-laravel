<?php

namespace App\Filament\Resources\LotteryResource\Pages;

use App\Filament\Resources\LotteryResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLotteries extends ListRecords
{
    protected static string $resource = LotteryResource::class;

    protected function getFilteredTableQuery(): Builder
    {
        return parent::getFilteredTableQuery()->orderByDesc('id');
    }
}
