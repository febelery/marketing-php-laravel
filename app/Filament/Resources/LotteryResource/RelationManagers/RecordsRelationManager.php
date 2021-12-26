<?php

namespace App\Filament\Resources\LotteryResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecordsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $recordTitleAttribute = 'lottery_id';

    protected static ?string $label = '中奖记录';

    protected static ?string $pluralLabel = '中奖记录';

    protected function getCreateFormSchema(): array
    {
        return [];
    }

    protected function getRelationship(): Relation
    {
        return parent::getRelationship()->luckyGuys()->orderBy('id', 'desc');
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    protected function getTableHeaderActions(): array
    {
        return [
            // todo 导出excel
            Tables\Actions\ButtonAction::make('export')
                ->label('导出')
                ->icon('heroicon-o-download')
            //->action(fn($record) => $this->getExportUrl($record))
        ];
    }

    protected function getTableActions(): array
    {
        return [
            $this->getEditLinkTableAction()
                ->label('处理')
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('status')
                ->label('状态')
                ->options([
                    2 => '领取',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prize.name')
                    ->label('奖品')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('兑奖码')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('姓名')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('电话')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('地址')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery')
                    ->label('提取方式'),
                Tables\Columns\BadgeColumn::make('status_text')
                    ->label('状态')
                    ->colors([
                        'warning' => '中奖',
                        'success' => '领取',
                    ])
                    ->default('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('中奖时间')
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [

        ];
    }
}
