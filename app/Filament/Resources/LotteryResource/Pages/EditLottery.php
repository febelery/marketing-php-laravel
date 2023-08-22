<?php

namespace App\Filament\Resources\LotteryResource\Pages;

use App\Filament\Resources\LotteryResource;
use App\Forms\Components\Concerns\WithQiniu;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Filament\Resources\Pages\EditRecord;

class EditLottery extends EditRecord
{
    use HasWizard, WithQiniu;

    protected static string $resource = LotteryResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('配置')
                ->schema([
                    Section::make()->schema(LotteryResource::getLotterySchema())->columns(),
                ]),

            Step::make('prizes')
                ->label('奖项')
                ->schema([
                    Section::make()->schema(LotteryResource::getPrizeSchema()),
                ]),
        ];
    }

    protected function hasSkippableSteps(): bool
    {
        return true;
    }


}
