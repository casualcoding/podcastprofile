<?php

namespace App\Services;

use Image;
use Log;

class ImageDownloadService
{
    /**
    * Saves an image to /public/images and returns the image url, or an empty
    * string if the operation failed (e.g. if the original image url returned
    * 404 not found)
    *
    * @param  string  $url
    * @param  string  $filename
    * @param  integer $width
    * @param  integer $height
    * @return the image url
    */
    public function saveImage($url, $filename, $width, $height)
    {
        $public_path = '/images/' . $filename . '.jpg';
        $path = __DIR__ . '/../../public' . $public_path;

        if ($url == null) {
            return '';
        }

        try {
            // stream the file using fopen
            file_put_contents($path, fopen($url, 'r'));
        } catch (\Exception $e) {
            try {
                // try downloading the whole file into memory
                file_put_contents($path, file_get_contents($url));
            } catch (\Exception $e) {
                // file doesn't seem to exist
                return '';
            }
        }

        $img = Image::make($path, array(
            'width' => $width,
            'height' => $height,
            'crop' => true
        ));
        $img->save($path);

        // free memory explicitely, since this is executed in a queue
        $img->destroy();

        Log::info('Memory usage after job: '.memory_get_usage());

        return $public_path;
    }
}
