<?php

namespace App\Filament\Resources\LotteryResource\Pages;

use App\Filament\Resources\LotteryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLottery extends ViewRecord
{
    protected static string $resource = LotteryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

