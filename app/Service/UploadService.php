<?php
namespace App\Service;

class UploadService {
    public static function handleUploadImage($image, $path = 'upload/images') {
        return self::doUpload($image, $path);
    }

    public static function handleUploadFile($file, $path = 'upload/files') {
        return self::doUpload($file, $path);
    }

    private static function doUpload($fileUpload, $path) {
        if (!is_null($fileUpload)) {
            $file_name = strtotime("now") . "_" . rand() . "." . $fileUpload->getClientOriginalExtension();
            $fileUpload->move(public_path($path), $file_name);
            return "/public/$path/".$file_name;
        }
    }
}