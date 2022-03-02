<?php

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use App\Models\Vote\Vote;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions;
use Illuminate\Database\Eloquent\Builder;
use function route;

class ListVotes extends ListRecords
{
    protected static string $resource = VoteResource::class;

    protected function getFilteredTableQuery(): Builder
    {
        return parent::getFilteredTableQuery()->orderByDesc('id');
    }

    protected function getTableActions(): array
    {
        return [
            Actions\LinkAction::make('edit')
                ->url(fn(Vote $record): string => route('filament.resources.votes.edit', $record))
                ->requiresConfirmation()
                ->label('编辑'),
            //Actions\LinkAction::make('delete')
            //    ->color('danger')
            //    ->action(fn(?Vote $record) => $record->delete())
            //    ->label('删除')
            //    ->requiresConfirmation(),
            // todo 显示链接
            Actions\LinkAction::make('show_url')
                ->color('secondary')
                ->url(fn(Vote $record): string => "https://www.baidu.com/s?wd={$record->id}")
                ->openUrlInNewTab()
                ->label('链接'),
        ];
    }


}
