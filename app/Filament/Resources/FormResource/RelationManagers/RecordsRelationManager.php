<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $recordTitleAttribute = 'form_id';

    protected static ?string $label = '填写记录';

    protected static ?string $pluralLabel = '填写记录';


    public function getRelationship(): Relation
    {
        $ship = parent::getRelationship()->orderBy('id', 'desc');

        return $ship;
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
        ]);
    }

    public function table(Table $table): Table
    {
        $columns = [];
        foreach (static::$fields as $field) {
            if ($field->type == 'image' || $field->type == 'multi_image') {
                $columns[] = Tables\Columns\ImageColumn::make(sprintf("record->%s", $field->key))
                    ->label($field->title)
                    ->getStateUsing(fn($record) => $record->record[$field->key][0]);
            } elseif ($field->type == 'video') {
                $columns[] = Tables\Columns\ViewColumn::make(sprintf("record->%s", $field->key))
                    ->label($field->title)
                    ->getStateUsing(fn($record) => $record->record[$field->key][0])
                    ->view('filament.components.video');
            } elseif ($field->type == 'switch') {
                $columns[] = Tables\Columns\IconColumn::make(sprintf("record->%s", $field->key))
                    ->label($field->title)->boolean();
            }else {
                $columns[] = Tables\Columns\TextColumn::make(sprintf("record->%s", $field->key))
                    ->label($field->title)
                    ->searchable();
            }
        }

        return $table
            ->columns($columns)
            ->filters([
                //
            ]);
    }
}
