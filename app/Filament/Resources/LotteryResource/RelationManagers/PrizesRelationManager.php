<?php

namespace App\Filament\Resources\LotteryResource\RelationManagers;

use App\Forms\Components\QiniuFileUpload;
use App\Forms\Components\WithQiniuUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class PrizesRelationManager extends RelationManager
{
    use WithQiniuUpload;

    protected static string $relationship = 'prizes';

    protected static ?string $recordTitleAttribute = 'lottery_id';

    protected static ?string $label = '奖项';

    protected static ?string $pluralLabel = '奖项';

    public  function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('奖品')
                    ->placeholder('奖品名称')
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->label('奖品总数')
                    ->numeric()
                    ->minValue(0)
                    ->default(1)
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->label('权重')
                    ->helperText(function () {
                        // todo 计算中奖概率
                        return '综合中奖概率为: <b>-</b>';
                    })
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(100)
                    ->required(),
                Forms\Components\TextInput::make('limit_times')
                    ->label('限中次数')
                    ->helperText('0表示不限制')
                    ->numeric()
                    ->minValue(0)
                    ->default(1)
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('类型')
                    ->options([
                        1 => '实物',
                        2 => '虚拟',
                        3 => '积分',
                        4 => '红包',
                    ])
                    ->required()
                    ->disableOptionWhen(fn($value): bool => $value > 3)
                    ->reactive()
                    ->default(1),
                Forms\Components\TextInput::make('type_value')
                    ->label('积分数量')
                    ->default(10)
                    ->numeric()
                    ->minValue(0)
                    ->hidden(fn(callable $get) => $get('type') != 3)
                    ->required(fn(callable $get) => $get('type') == 3),
                Forms\Components\TextInput::make('type_value')
                    ->label('红包金额')
                    ->default(10)
                    ->numeric()
                    ->minValue(0)
                    ->hidden(fn(callable $get) => $get('type') != 4)
                    ->required(fn(callable $get) => $get('type') == 4),
                Forms\Components\Textarea::make('desc')
                    ->label('选项描述')
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                QiniuFileUpload::make('icon')
                    ->label('图片')
                    ->columnSpan([
                        'sm' => 2,
                    ])
                    ->image(),
                Forms\Components\Toggle::make('is_public')
                    ->label('开启')
                    ->default(true),
            ])->columns([
                'sm' => 2,
            ])->columnSpan(2),
        ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('奖品')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('奖品总数')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remain')
                    ->label('剩余奖品'),
                // todo 计算概率
                Tables\Columns\TextColumn::make('rate')
                    ->default('-')
                    ->label('中奖概率'),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('是否公开')->boolean(),
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
