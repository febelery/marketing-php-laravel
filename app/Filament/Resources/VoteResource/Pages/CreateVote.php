<?php

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use App\Forms\Components\WithQiniuUpload;
use Filament\Resources\Pages\CreateRecord;
use function auth;

class CreateVote extends CreateRecord
{
    use WithQiniuUpload;

    protected static string $resource = VoteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}



