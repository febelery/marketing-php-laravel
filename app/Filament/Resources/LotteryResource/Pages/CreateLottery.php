<?php

namespace App\Filament\Resources\LotteryResource\Pages;

use App\Filament\Resources\LotteryResource;
use App\Forms\Components\Concerns\WithQiniu;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateLottery extends CreateRecord
{
    use HasWizard, WithQiniu;

    protected static string $resource = LotteryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

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

}
