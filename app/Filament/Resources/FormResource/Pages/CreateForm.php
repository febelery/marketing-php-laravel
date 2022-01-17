<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Forms\Components\WithQiniuUpload;
use Filament\Resources\Pages\CreateRecord;

class CreateForm extends CreateRecord
{
    use WithQiniuUpload;

    protected static string $resource = FormResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
