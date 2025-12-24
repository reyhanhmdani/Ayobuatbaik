<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Optimize and upload image.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory  (e.g., 'programs', 'berita', 'sliders')
     * @param  int|null  $maxWidth
     * @param  int  $quality
     * @return string  $path
     */
    public static function uploadAndOptimize($file, $directory, $maxWidth = 1000, $quality = 80)
    {
        // 1. Setup Image Manager (v3)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // 2. Resize if too large
        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // 3. Generate name and path (force .webp)
        $filename = Str::random(40) . '.webp';
        $fullPath = $directory . '/' . $filename;

        // 4. Encode as WebP and Save to Storage
        $encoded = $image->toWebp($quality);
        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }
}
