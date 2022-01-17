<?php

namespace App\Forms\Components;

use Filament\Forms\Components\FileUpload;

class QiniuFileUpload extends FileUpload
{
    protected string $view = 'filament.components.file-upload';

    public function getUploadedFileUrl(string $fileKey): ?string
    {
        $files = $this->getState();

        return $files[$fileKey] ?? null;
    }
}
