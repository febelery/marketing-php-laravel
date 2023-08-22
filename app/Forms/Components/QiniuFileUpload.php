<?php

namespace App\Forms\Components;

use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class QiniuFileUpload extends FileUpload
{
    protected string $view = 'filament.components.file-upload';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(static function (BaseFileUpload $component, string|array|null $state): void {
            $checkArrState = json_decode($state, true);
            if ($checkArrState != null) {
                $state = $checkArrState;
            }
            $files = collect(Arr::wrap($state))
                ->mapWithKeys(static fn(string $file): array => [((string)Str::uuid()) => $file])
                ->all();

            $component->state($files ?? []);
        });
    }

    public function getUploadedFiles(): ?array
    {
        $urls = [];
        $state = $this->getState() ?? [];
        if (!is_array($state)) {
            $state = [$state];
        }

        foreach ($state as $fileKey => $file) {
            $urls[$fileKey] = [
                'name' => 'ross.png',
                'size' => 1024,
                'type' => 'image/png',
                'url' => $file
            ];
        }

        return $urls;
    }

}
