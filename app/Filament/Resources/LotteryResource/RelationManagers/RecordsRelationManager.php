<?php

namespace App\Filament\Resources\LotteryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $title = '中奖记录';

    public function getRelationship(): Relation
    {
        return parent::getRelationship()->luckyGuys()->orderBy('id', 'desc');
    }

    protected function getTableHeaderActions(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prize.title')
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
                Tables\Columns\TextColumn::make('mobile')
                    ->label('电话')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('地址')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery')
                    ->label('提取方式'),
                Tables\Columns\TextColumn::make('status_text')
                    ->label('状态')
                    ->badge()
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
}
