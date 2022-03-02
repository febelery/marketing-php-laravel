<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getFilteredTableQuery(): Builder
    {
        return parent::getFilteredTableQuery()->orderByDesc('id');
    }
}
