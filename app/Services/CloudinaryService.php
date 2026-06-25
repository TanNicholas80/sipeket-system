<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CloudinaryService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'cloudinary');
    }

    public function delete(?string $publicId): void
    {
        if (! $publicId) {
            return;
        }

        $this->disk()->delete($publicId);
    }

    public function url(string $publicId): string
    {
        return $this->disk()->url($publicId);
    }

    private function disk(): Cloud
    {
        /** @var Cloud $disk */
        $disk = Storage::disk('cloudinary');

        return $disk;
    }
}
