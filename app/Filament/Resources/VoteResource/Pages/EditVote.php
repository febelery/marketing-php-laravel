<?php

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use App\Forms\Components\WithQiniuUpload;
use Filament\Resources\Pages\EditRecord;

class EditVote extends EditRecord
{
    use WithQiniuUpload;

    protected static string $resource = VoteResource::class;
}
