<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    public static function upload($imageFile,$folderName) {
        $fileName = uniqid(rand().'_');
        $extension = $imageFile->extension();
        $fileNameStore = $fileName.'.'.$extension;

        $manager = new ImageManager(new Driver());
        $img = $manager->read($imageFile);
        $resizeImage = $img->resize(1920,1080)->encode();

        Storage::put('public/'.$folderName.'/'.$fileNameStore,$resizeImage);
        return $fileName;
    }
}