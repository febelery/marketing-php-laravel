<?php

namespace App\Filament\Resources\LotteryResource\Pages;

use App\Filament\Resources\LotteryResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;


class ListLotteries extends ListRecords
{
    protected static string $resource = LotteryResource::class;

    public function getFilteredTableQuery(): Builder
    {
        return parent::getFilteredTableQuery()->orderByDesc('id');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
