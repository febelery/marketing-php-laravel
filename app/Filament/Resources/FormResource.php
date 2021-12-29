<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Forms\Components\SettingForm;
use App\Models\Form\Form as FormModal;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class FormResource extends Resource
{
    protected static ?string $model = FormModal::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = '表单';

    protected static ?string $pluralLabel = '表单';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('标题')
                        ->required()
                        ->columnSpan([
                            'sm' => 5,
                        ]),
                    Forms\Components\DateTimePicker::make('start_at')
                        ->displayFormat('Y-m-d H:i:s')
                        ->label('开始时间')
                        ->default(now())
                        ->required()
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    Forms\Components\DateTimePicker::make('end_at')
                        ->displayFormat('Y-m-d H:i:s')
                        ->label('结束时间')
                        ->default(now()->addDays(2))
                        ->required()
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    Forms\Components\TextInput::make('total_limit')
                        ->name('参与次数')
                        ->helperText('0为不限制')
                        ->numeric()
                        ->default(1)
                        ->minValue(0)
                        ->required(),
                    Forms\Components\FileUpload::make('cover')
                        ->label('封面')
                        ->image()
                        ->columnSpan([
                            'sm' => 5,
                        ]),
                    Forms\Components\RichEditor::make('desc')
                        ->label('简介')
                        ->columnSpan([
                            'sm' => 5,
                        ]),
                ])->columns([
                    'sm' => 5,
                ]),
                Forms\Components\Card::make()->schema([
                    SettingForm::make('setting'),
                ]),
                Forms\Components\Card::make()->schema([
                    Forms\Components\Placeholder::make('字段'),
                    Forms\Components\Repeater::make('fields')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->label('类型')
                                ->options([
                                    'input' => '输入框',
                                    'textarea' => '文本域',
                                    'radio' => '单选框',
                                    'checkbox' => '多选框',
                                    'select' => '下拉框',
                                    'date' => '日期',
                                    'datetime' => '日期时间',
                                    'time' => '时间',
                                    'image' => '单图',
                                    'multi_image' => '多图',
                                    'video' => '视频',
                                    'file' => '文件',
                                    'rich' => '富文本',
                                ])
                                ->required()
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->reactive()
                                ->lazy()
                                ->default('input'),
                            Forms\Components\TextInput::make('title')
                                ->label('标题')
                                ->required()
                                ->maxValue(30)
                                ->reactive()
                                ->afterStateUpdated(fn($state, callable $set) => $set('key', substr(md5(trim($state)), 0, 8)))
                                ->columnSpan([
                                    'sm' => 5,
                                ]),
                            Forms\Components\Checkbox::make('required')
                                ->columnSpan([
                                    'md' => 2,
                                ])
                                ->label('必填')
                                ->default(true),
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\Select::make('rule')
                                        ->options([
                                            'id_card' => '身份证',
                                            'phone' => '手机',
                                            'email' => '邮箱',
                                            'url' => '网址',
                                            'numeric' => '数字',
                                            'length' => '长度',
                                        ])
                                        ->columnSpan([
                                            'md' => 3,
                                        ])
                                        ->reactive()
                                        ->label('验证规则'),
                                    Forms\Components\TextInput::make('min')
                                        ->columnSpan([
                                            'md' => 2,
                                        ])
                                        ->when(fn(callable $get) => $get('rule') === 'length')
                                        ->numeric()
                                        ->label('最小值'),
                                    Forms\Components\TextInput::make('max')
                                        ->columnSpan([
                                            'md' => 2,
                                        ])
                                        ->when(fn(callable $get) => $get('rule') === 'length')
                                        ->numeric()
                                        ->label('最大值'),
                                ])
                                ->when(fn(callable $get) => in_array($get('type'), ['input', 'textarea']))
                                ->columnSpan([
                                    'md' => 10,
                                ])
                                ->columns([
                                    'md' => 10,
                                ]),
                            Forms\Components\Group::make([
                                Forms\Components\TagsInput::make('options')
                                    ->label('选项')
                                    ->columnSpan([
                                        'md' => 5,
                                    ])
                                    ->helperText('当类型为单选多选下拉框时填写')
                                    ->placeholder('输入回车后输入下一个选项')
                                    ->required(fn(callable $get) => in_array($get('type'), ['select', 'radio', 'checkbox']))
                                    ->when(fn(callable $get) => in_array($get('type'), ['select', 'radio', 'checkbox'])),
                            ])->columnSpan([
                                'md' => 10,
                            ])->columns([
                                'md' => 10,
                            ])
                        ])
                        ->dehydrated()
                        ->defaultItems(1)
                        ->disableLabel()
                        ->createItemButtonLabel('添加字段')
                        ->columns([
                            'md' => 10,
                        ])
                        ->required(),
                ]),
            ])->columnSpan(3),
            Forms\Components\Card::make()->schema([
                Forms\Components\Toggle::make('is_public')
                    ->label('开启')
                    ->helperText('开启后，表单可以正常填写')
                    ->default(true),
                Forms\Components\Placeholder::make('created_at')
                    ->label('创建时间')
                    ->content(fn(?FormModal $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Forms\Components\Placeholder::make('updated_at')
                    ->label('修改时间')
                    ->content(fn(?FormModal $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
            ])->columnSpan(1),
        ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')
                ->label('标题')
                ->searchable()
                ->sortable(),
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
            RelationManagers\RecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
