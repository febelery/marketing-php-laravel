<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LotteryResource\Pages;
use App\Filament\Resources\LotteryResource\RelationManagers;
use App\Forms\Components\QiniuFileUpload;
use App\Forms\Components\SettingForm;
use App\Models\Lottery\Lottery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LotteryResource extends Resource
{
    protected static ?string $model = Lottery::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $label = '抽奖';

    protected static ?string $pluralLabel = '抽奖';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        //Forms\Components\Section::make()
                        //    ->schema(static::getLotterySchema())
                        //    ->columns(2),

                        //Forms\Components\Section::make('奖项')
                        //    ->schema(static::getPrizeSchema()),
                    ])
                    ->columnSpan(['lg' => fn(?Lottery $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_public')
                            ->label('开启')
                            ->helperText('开启后，抽奖可以正常展示')
                            ->default(true),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('创建时间')
                            ->content(fn(?Lottery $record): ?string => $record?->created_at->diffForHumans()),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('修改时间')
                            ->content(fn(?Lottery $record): ?string => $record?->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(1)
                    ->hidden(fn(?Lottery $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID'),
            Tables\Columns\TextColumn::make('title')
                ->label('标题')
                ->searchable(),
            Tables\Columns\TextColumn::make('remain_prize')
                ->label('剩余奖品'),
            Tables\Columns\TextColumn::make('record_user')
                ->label('参与人数'),
            Tables\Columns\TextColumn::make('view_count')
                ->label('浏览次数'),
            Tables\Columns\IconColumn::make('active')
                ->boolean()
                ->label('进行中'),
            Tables\Columns\TextColumn::make('end_at')
                ->label('结束时间'),
        ])->filters([

        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLotteries::route('/'),
            'create' => Pages\CreateLottery::route('/create'),
            'edit' => Pages\EditLottery::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }


    public static function getLotterySchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('标题')
                ->required()
                ->columnSpan(2),
            Forms\Components\DateTimePicker::make('start_at')
                ->displayFormat('Y-m-d H:i:s')
                ->label('开始时间')
                ->default(now())
                ->required(),
            Forms\Components\DateTimePicker::make('end_at')
                ->displayFormat('Y-m-d H:i:s')
                ->label('结束时间')
                ->default(now()->addDays(2))
                ->required(),
            Forms\Components\RichEditor::make('desc')
                ->label('描述')
                ->required()
                ->columnSpan([
                    'sm' => 2,
                ]),

            Forms\Components\Section::make()->schema([
                Forms\Components\Placeholder::make('设置'),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('daily_limit')
                        ->name('每日抽奖次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->reactive()
                        //->afterStateUpdated(fn($state, callable $set) => $set('total_limit', $state))
                        ->required(),
                    Forms\Components\TextInput::make('total_limit')
                        ->name('总抽奖次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required(),
                    Forms\Components\TextInput::make('lucky_limit')
                        ->name('中奖次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required(),
                    Forms\Components\TextInput::make('lucky_rate')
                        ->name('中奖概率')
                        ->helperText('0为必不中奖,100为必中奖')
                        ->numeric()
                        ->default(10)
                        ->minValue(1)
                        ->maxValue(100)
                        ->required(),
                    Forms\Components\TextInput::make('daily_share_limit')
                        ->name('每日分享增加次数')
                        ->helperText('通过分享能增加的抽奖次数')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Forms\Components\TextInput::make('total_share_limit')
                        ->name('总共分享增加次数')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Forms\Components\Select::make('template')
                        ->label('模板')
                        ->options([
                            1 => '大转盘',
                            2 => '九宫格',
                            3 => '老虎机',
                            4 => '翻牌机',
                            5 => '砸金蛋',
                            6 => '刮刮卡',
                        ])
                        ->required()
                        ->reactive()
                        ->disableOptionWhen(fn($value): bool => $value > 5)
                        ->default(1),
                    Forms\Components\Select::make('type')
                        ->label('类型')
                        ->options([
                            1 => '默认',
                            2 => '积分',
                        ])
                        ->required()
                        ->disableOptionWhen(fn($value): bool => $value > 2)
                        ->reactive()
                        ->default(1),
                    Forms\Components\TextInput::make('type_value')
                        ->label('消耗积分')
                        ->default(10)
                        ->numeric()
                        ->minValue(0)
                        ->hidden(fn(callable $get) => $get('type') != 2)
                        ->required(fn(callable $get) => $get('type') == 2),
                ]),
                //SettingForm::make('setting'),
            ])->columnSpan(2),
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('创建时间')
                        ->content(fn(?Lottery $record): ?string => $record?->created_at->diffForHumans()),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('修改时间')
                        ->content(fn(?Lottery $record): ?string => $record?->updated_at?->diffForHumans()),
                ])
                ->columnSpan('full')
                ->hidden(fn(?Lottery $record) => $record === null),
        ];
    }

    public static function getPrizeSchema(): array
    {
        return [
            Forms\Components\Repeater::make('prizes')
                ->label('奖项')
                ->relationship()
                ->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('奖品')
                            ->placeholder('奖品名称')
                            ->columnSpan(5)
                            ->required(),
                        Forms\Components\TextInput::make('total')
                            ->label('奖品总数')
                            ->numeric()
                            ->minValue(0)
                            ->default(1)
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\TextInput::make('weight')
                            ->label('权重')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(100)
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\TextInput::make('limit_times')
                            ->label('最大中奖次数')
                            ->numeric()
                            ->minValue(0)
                            ->default(1)
                            ->columnSpan(3)
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
                            ->columnSpan(3)
                            ->default(1),
                        Forms\Components\TextInput::make('type_value')
                            ->label('积分数量')
                            ->default(10)
                            ->numeric()
                            ->minValue(0)
                            ->columnSpan(3)
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
                            ->columnSpan(8),
                        QiniuFileUpload::make('icon')
                            ->label('图片')
                            ->columnSpan(6)
                            ->openable()
                            ->image(),
                        //Forms\Components\Toggle::make('is_public')
                        //    ->label('开启')
                        //    ->default(true),
                    ])->columns(20),
                ])
        ];
    }

}
