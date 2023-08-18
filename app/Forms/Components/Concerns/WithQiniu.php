<?php

namespace App\Forms\Components\Concerns;

use Qiniu\Auth;

trait WithQiniu
{
    public function uploadToken($fileInfo): string
    {
        $qiniu = new Auth(config('filesystems.disks.qiniu.access_key'), config('filesystems.disks.qiniu.secret_key'));

        $pathURI = substr(md5(json_encode($fileInfo)), 0, 14) . '-' . $fileInfo['name'];
        $entryURI = sprintf("%s:rosses/%s", config('filesystems.disks.qiniu.bucket'), $pathURI);

        $policy = [
            'mimeLimit' => 'video/mp4;image/jpeg;image/jpg;image/png;video/flv;video/mov;video/avi;video/rmvb;video/quicktime;audio/mpeg',
            'returnBody' => json_encode([
                'key' => '$(key)',
                'path' => config('filesystems.disks.qiniu.domain') . "/ross/{$pathURI}"
            ]),
            //'callbackUrl' => $callbackUrl,
            'callbackBody' => json_encode([
                'key' => '$(key)',
                'hash' => '$(etag)',
                'original_name' => '$(fname)',
                'size' => '$(fsize)',
                'mime' => '$(mimeType)',
                'ext' => '$(ext)',
            ]),
            'saveKey' => "ross/{$pathURI}",
            'callbackBodyType' => 'application/json',
            'scope' => config('filesystems.disks.qiniu.bucket'),
            'fsizeLimit' => 1024 * 1024 * 350, // 250m
        ];

        $safeUrlBase64Encode = function ($str) {
            $find = ['+', '/'];
            $replace = ['-', '_'];
            return str_replace($find, $replace, base64_encode($str));
        };

        if (str_contains($fileInfo['type'], 'image/')) {
            $policy['persistentOps'] = 'imageslim|imageView2/4/w/1920/h/1080|saveas/' . $safeUrlBase64Encode($entryURI);
        } elseif (str_contains($fileInfo['type'], 'video/')) {
            $policy['persistentOps'] = 'avthumb/mp4|saveas/' . $safeUrlBase64Encode($entryURI);
        }
        return $qiniu->uploadToken(config('filesystems.disks.qiniu.bucket'), null, 600, $policy);
    }

    public function finishUpload($name, $path): void
    {
        app('livewire')->updateProperty($this, $name, $path);
    }
}
