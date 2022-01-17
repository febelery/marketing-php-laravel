<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Forms\Components\WithQiniuUpload;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    use WithQiniuUpload;

    protected static string $resource = FormResource::class;
}
