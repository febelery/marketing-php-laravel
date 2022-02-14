<?php

namespace App\Forms\Components;

use Qiniu\Auth;

trait WithQiniuUpload
{
    public function uploadToken(array $fileInfo): string
    {
        $qiniu = new Auth(config('filesystems.disks.qiniu.access_key'), config('filesystems.disks.qiniu.secret_key'));

        $saveKey = sprintf("ross/%s/%s", substr(md5(json_encode($fileInfo)), 0, 16), $fileInfo['name']);
        $path = $saveKey ? sprintf("https://wximg.chuanbaoguancha.cn/%s", $saveKey) : 'https://wximg.chuanbaoguancha.cn/$(key)';

        $policy = [
            'mimeLimit' => 'video/mp4;image/jpeg;image/jpg;image/png;video/flv;video/mov;video/avi;video/rmvb;video/quicktime;audio/mpeg',
            'returnBody' => json_encode([
                'key' => '$(key)',
                'path' => $path
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
            'saveKey' => $saveKey,
            'callbackBodyType' => 'application/json',
            'scope' => config('filesystems.disks.qiniu.bucket'),
            'fsizeLimit' => 1024 * 1024 * 350, // 250m
        ];

        return $qiniu->uploadToken(config('filesystems.disks.qiniu.bucket'), null, 600, $policy);
    }

    public function finishUploadByQiniu($name, $path)
    {
        $this->syncInput($name, $path);
    }

}
