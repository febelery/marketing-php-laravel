<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LotteryResource\Pages;
use App\Filament\Resources\LotteryResource\RelationManagers;
use App\Forms\Components\SettingForm;
use App\Models\Lottery\Lottery;
use App\Models\Vote\Vote;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class LotteryResource extends Resource
{
    protected static ?string $model = Lottery::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle';

    protected static ?string $label = '抽奖';

    protected static ?string $pluralLabel = '抽奖';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('标题')
                        ->required()
                        ->columnSpan([
                            'sm' => 2,
                        ]),
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
                ])->columns([
                    'sm' => 2,
                ]),
            ])->columnSpan(2),
            Forms\Components\Card::make()->schema([
                Forms\Components\Toggle::make('is_public')
                    ->label('开启')
                    ->helperText('开启后，抽奖可以正常展示')
                    ->default(true),
                Forms\Components\Placeholder::make('created_at')
                    ->label('创建时间')
                    ->content(fn(?Lottery $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Forms\Components\Placeholder::make('updated_at')
                    ->label('修改时间')
                    ->content(fn(?Lottery $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

            ])->columnSpan(1),
            Forms\Components\Card::make()->schema([
                Forms\Components\Placeholder::make('设置'),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('daily_limit')
                        ->name('每日抽奖次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(0)
                        ->required(),
                    Forms\Components\TextInput::make('total_limit')
                        ->name('总抽奖次数')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
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
                        ->disableOptionWhen(fn($value): bool => $value > 3)
                        ->default(1),
                    Forms\Components\Select::make('type')
                        ->label('动作')
                        ->options([
                            1 => '默认',
                            2 => '积分',
                            3 => '投票后抽奖',
                            4 => '填写表单后抽奖',
                        ])
                        ->required()
                        ->disableOptionWhen(fn($value): bool => $value > 1)
                        ->reactive()
                        ->default(1),
                    Forms\Components\TextInput::make('type_value')
                        ->label('消耗积分')
                        ->default(10)
                        ->numeric()
                        ->minValue(0)
                        ->hidden(fn(callable $get) => $get('type') != 2)
                        ->required(fn(callable $get) => $get('type') == 2),
                    Forms\Components\Select::make('type_value')
                        ->label('投票')
                        ->options(function (Vote $vote) {
                            $list = $vote->where('end_at', '>=', now())->where('user_id', auth()->id())->orderByDesc('id')->get(['id', 'title']);
                            $options = [];
                            foreach ($list as $value) {
                                $options[$value->id] = $value->title;
                            }
                            return $options;
                        })
                        ->hidden(fn(callable $get) => $get('type') != 3)
                        ->required(fn(callable $get) => $get('type') == 3),
                ]),
                SettingForm::make('setting'),
            ])->columnSpan(2),
        ])->columns(3);
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
            Tables\Columns\BooleanColumn::make('active')
                ->label('进行中'),
            Tables\Columns\TextColumn::make('runtime')
                ->label('运行时间'),
        ])->filters([
            //
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PrizesRelationManager::class,
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
}
