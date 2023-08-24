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
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class LotteryResource extends Resource
{
    protected static ?string $model = Lottery::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = '抽奖';

    protected static ?string $label = '抽奖';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Forms\Components\Section::make()
                //    ->schema(static::getLotterySchema()),
                Forms\Components\Section::make()
                    ->schema(static::getPrizeSchema()),
            ]);
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
            Tables\Columns\IconColumn::make('active')
                ->boolean()
                ->label('进行中'),
            Tables\Columns\TextColumn::make('end_at')
                ->label('结束时间'),
        ])->filters([

        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\Action::make('地址')
                ->requiresConfirmation()
                ->icon('heroicon-o-link')
                ->modalHeading('前端页面地址')
                ->color('success')
                ->modalDescription('可复制链接在新窗口打开预览')
                ->modalContent(fn($record) => new HtmlString(env('FRONT_URL') . '/#/lottery/' . $record->uuid))
                ->modalSubmitActionLabel('看了'),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('奖项')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('prizes')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('title')->label('奖品名称'),
                                Infolists\Components\TextEntry::make('total')->label('奖品总数'),
                                Infolists\Components\TextEntry::make('remain')->label('剩余奖品'),
                                Infolists\Components\ImageEntry::make('image')->label('图片')->openUrlInNewTab(),
                                Infolists\Components\TextEntry::make('created_at')->label('创建时间'),
                            ])->columns(5),

                    ])
                    ->collapsible(),
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
            'view' => Pages\ViewLottery::route('/{record}'),
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
                        ->name('最大中奖次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required(),
                    Forms\Components\TextInput::make('lucky_rate')
                        ->name('中奖概率')
                        ->helperText('0为必不中奖,100为必中奖')
                        ->numeric()
                        ->default(20)
                        ->minValue(1)
                        ->maxValue(100)
                        ->required(),
                    Forms\Components\TextInput::make('cost_integral')
                        ->name('积分抽奖')
                        ->helperText('抽奖花费川观新闻积分(默认不填)')
                        ->nullable()
                        ->numeric()
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

                ]),
            ])->columnSpan(2),
            //SettingForm::make('setting')->columnSpan('full'),
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
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('奖品')
                                ->placeholder('奖品名称')
                                ->columnSpan(['lg' => 2])
                                ->required(),
                            Forms\Components\TextInput::make('total')
                                ->label('奖品总数')
                                ->numeric()
                                ->minValue(0)
                                ->default(1)
                                ->columns(1)
                                ->required(),
                            Forms\Components\TextInput::make('weight')
                                ->label('权重')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(100)
                                ->columns(1),
                            Forms\Components\TextInput::make('lucky_limit')
                                ->label('最大中奖次数')
                                ->numeric()
                                ->minValue(0)
                                ->columns(1)
                                ->default(1),
                            Forms\Components\Select::make('type')
                                ->label('类型')
                                ->options([
                                    1 => '实物',
                                    2 => '积分',
                                    3 => '红包',
                                ])
                                ->required()
                                ->disableOptionWhen(fn($value): bool => $value > 1)
                                ->reactive()
                                ->columns(1)
                                ->default(1),
                            Forms\Components\TextInput::make('type_value')
                                ->label('积分数量')
                                ->default(10)
                                ->numeric()
                                ->minValue(0)
                                ->columns(1)
                                ->hidden(fn(callable $get) => $get('type') != 2)
                                ->required(fn(callable $get) => $get('type') == 2),
                            Forms\Components\TextInput::make('type_value')
                                ->label('红包金额')
                                ->default(10)
                                ->numeric()
                                ->minValue(0)
                                ->hidden(fn(callable $get) => $get('type') != 3)
                                ->required(fn(callable $get) => $get('type') == 3),
                            Forms\Components\Textarea::make('desc')
                                ->label('描述')
                                ->columnSpan(3),
                        ])->columnSpan(['lg' => 3])->columns(3),
                    Forms\Components\Section::make()->schema([
                        QiniuFileUpload::make('image')
                            ->label('图片')
                            ->imageResizeMode('cover')
                            ->helperText('图片为正方形效果最佳')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '4:3',
                                '1:1',
                            ])
                            ->openable()
                            ->image(),

                    ])->columnSpan(['lg' => 2]),
                ])->columns(5)
        ];
    }

}
