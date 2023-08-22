<?php

namespace App\Filament\Resources;

use App\Forms\Components\QiniuFileUpload;
use App\Forms\Components\SettingForm;
use App\Models\Vote\Vote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '未完成';

    protected static ?string $label = '投票';

    protected static ?string $pluralLabel = '投票';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make()->schema([
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
                    QiniuFileUpload::make('cover')
                        ->label('封面')
                        ->required()
                        ->image()
                        ->columnSpan([
                            'sm' => 2,
                        ]),
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
            Forms\Components\Section::make()->schema([
                Forms\Components\Toggle::make('is_public')
                    ->label('开启')
                    ->helperText('开启后，投票可以正常展示')
                    ->default(true),
                Forms\Components\Placeholder::make('created_at')
                    ->label('创建时间')
                    ->content(fn(?Vote $record): ?string => $record?->created_at->diffForHumans()),
                Forms\Components\Placeholder::make('updated_at')
                    ->label('修改时间')
                    ->content(fn(?Vote $record): ?string => $record?->updated_at->diffForHumans()),
                Forms\Components\Repeater::make('categories')
                    ->label('分类')
                    ->helperText('必须先保存分类才能在投票列表中选择')
                    ->relationship('categories')
                    ->defaultItems(0)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('类目名称')
                            ->required(),
                    ]),
            ])->columnSpan(1),
            Forms\Components\Section::make()->schema([
                Forms\Components\Placeholder::make('限制'),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('daily_limit')
                        ->name('每日投票次数')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required(),
                    Forms\Components\TextInput::make('single_limit')
                        ->name('单项投票次数')
                        ->helperText('0表示不限制')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->required(),
                    Forms\Components\TextInput::make('total_limit')
                        ->name('总投票次数')
                        ->helperText('0表示不限制')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->required(),
                ]),
                SettingForm::make('setting'),
            ])->columnSpan(2),
            Forms\Components\Section::make()->schema([
                Forms\Components\Placeholder::make('显示'),
                Forms\Components\Grid::make()->schema([
                    Forms\Components\Select::make('sort')
                        ->options([
                            '0' => '票数',
                            '1' => '序号',
                        ])
                        ->required()
                        ->default('1')
                        ->label('排序'),
                    Forms\Components\Select::make('template')
                        ->options([
                            '0' => '默认',
                        ])
                        ->required()
                        ->default('0')
                        ->label('模板'),
                    Forms\Components\TextInput::make('column')
                        ->label('列数')
                        ->numeric()
                        ->default(2)
                        ->maxValue(3)
                        ->minValue(1)
                        ->minValue(1)
                        ->maxValue(3),
                    Forms\Components\TextInput::make('button_name')
                        ->label('按钮名称')
                        ->default('投票'),
                ]),

                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Toggle::make('show_countdown')
                        ->label('倒计时')
                        ->helperText('显示倒计时')
                        ->default(true),
                    Forms\Components\Toggle::make('show_search')
                        ->label('搜索')
                        ->helperText('显示搜索')
                        ->default(true),
                    Forms\Components\Toggle::make('show_static')
                        ->label('静态')
                        ->helperText('不显示投票按钮')
                        ->default(false),
                    Forms\Components\TextInput::make('theme_color')
                        ->label('主题色')
                        ->type('color')
                        ->default('#be000a'),
                ]),
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
            Tables\Columns\TextColumn::make('vote_count')
                ->label('总票数'),
            Tables\Columns\TextColumn::make('record_user')
                ->label('参与人数'),
            Tables\Columns\TextColumn::make('view_count')
                ->label('浏览次数'),
            Tables\Columns\BooleanColumn::make('active')
                ->label('进行中'),
            Tables\Columns\TextColumn::make('runtime')
                ->label('运行时间'),
        ])->filters([

        ]);
    }

    public static function getRelations(): array
    {
        return [
            VoteResource\RelationManagers\ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => VoteResource\Pages\ListVotes::route('/'),
            'create' => VoteResource\Pages\CreateVote::route('/create'),
            'edit' => VoteResource\Pages\EditVote::route('/{record}/edit'),
        ];
    }

}
