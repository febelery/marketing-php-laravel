<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecordsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $recordTitleAttribute = 'form_id';

    protected static ?string $label = '填写记录';

    protected static ?string $pluralLabel = '填写记录';

    protected static ?array $fields;

    protected function getCreateFormSchema(): array
    {
        return [];
    }

    protected function getRelationship(): Relation
    {
        $ship = parent::getRelationship()->orderBy('id', 'desc');
        static::$fields = $ship->getParent()->fields;

        return $ship;
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
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
        ]);
    }

    public static function table(Table $table): Table
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
                $columns[] = Tables\Columns\BooleanColumn::make(sprintf("record->%s", $field->key))
                    ->label($field->title);
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

    public static function getPages(): array
    {
        return [

        ];
    }
}
