<?php

namespace App\Filament\Resources\VoteResource\RelationManagers;

use App\Forms\Components\QiniuFileUpload;
use App\Forms\Components\WithQiniuUpload;
use App\Models\Vote\Category;
use App\Models\Vote\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    use WithQiniuUpload;

    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'vote_id';

    protected static ?string $label = '选项';

    protected static ?string $pluralLabel = '选项';

    private static int $voteId;


    public  function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->label('选项名称')
                    ->required(),
                Forms\Components\TextInput::make('subtitle')
                    ->label('选项副标题'),
                Forms\Components\TextInput::make('serial_number')
                    ->label('选项序号')
                    ->numeric()
                    ->default(fn(?Item $item) => $item->where('vote_id', self::$voteId)->max('serial_number') + 1)
                    ->required(),
                Forms\Components\TextInput::make('cheat_count')
                    ->default(0)
                    ->numeric()
                    ->default(0)
                    ->label('作弊票数'),
                Forms\Components\BelongsToSelect::make('category_id')
                    ->required(fn(Category $category): bool => $category->where('vote_id', self::$voteId)->count() > 0)
                    ->label('分类')
                    ->relationship('category', 'title')
                    ->relationship('category', 'title', fn($query) => $query->where('vote_id', self::$voteId))
                    ->preload(),
                Forms\Components\RichEditor::make('desc')
                    ->label('选项描述')
                    ->columnSpan([
                        'sm' => 2,
                    ])
                    ->required(),
                QiniuFileUpload::make('images')
                    ->label('图片')
                    ->multiple()
                    ->maxFiles(5)
                    ->columnSpan([
                        'sm' => 2,
                    ])
                    ->required(),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('序号')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->default('-')
                    ->label('分类'),
                Tables\Columns\ImageColumn::make('first_image')
                    ->label('图片'),
                Tables\Columns\TextColumn::make('vote_count')
                    ->label('投票数')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cheat_count')
                    ->label('作弊票数'),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('是否公开')->boolean(),
            ])
            ->filters([
                //
            ]);
    }
}
