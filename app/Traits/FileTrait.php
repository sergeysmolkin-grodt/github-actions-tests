<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function getFileData($file): string
    {
        $fileData = [];
        $fileData['name'] = $file->getClientOriginalName();
        $fileData['ext'] = $file->getClientOriginalExtension();

        return $fileData;
    }

    public function uploadFile($file, string $path = null, string $storage = null): string|false
    {
        // TODO: extend function for profile image
        $folder = $path ?? config('app.profile_image.path');
        $storage = $storage ?? config('app.profile_image.disk');
        $filename = uniqid('', true).'_'.str_replace(' ', '_', $file->getClientOriginalName());

        $path = Storage::disk($storage)->putFileAs($folder, $file, $filename);

        return $path ? $filename : false;
    }
}
