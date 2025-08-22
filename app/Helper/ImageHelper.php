<?php
namespace App\Helper;
use Image;
use App\Helper\LoggerHelper;

class ImageHelper
{
    /**
     * Undocumented function
     *
     * @param [type] $image
     * @param [type] $destination
     * @return boolean
     */
    public static function upload($image, $destination):bool{
        $path = dirname($destination);
        $filename =basename($destination);
        if(!is_dir($path))
            mkdir($path, 0777, true);
        $image->move($path, $filename);
        return true;
    }

    public static function resize($src, $destination, $width, $height, $aspectRatio = true){

        $img = Image::make($src);

        $path = dirname($destination);
        if(!is_dir($path))
            mkdir($path, 0777, true);
        $canvas = Image::canvas($width, $height, '#CCCCCC');
        $img->resize($width, $height, function($constraint) {

            $constraint->aspectRatio();

        });
        $canvas->insert($img, "center");
        $canvas->save($destination);

    }

    public static function remove($fileName){

        if(file_exists($fileName)){
            @unlink($fileName);
        }
    }

    public static function getUrl($imagePath, $imageType = ""){

        $path = [];
        $path[] = $imageType ? $imageType:"src";
        $path[] = $imagePath;
        return url("/api/images/".implode("/", $path));
    }



    public static function getFile($imagePath, $imageType = "src"){
        try{
            $srcPath = public_path("/images/$imagePath");
            $filePath = $imageType && $imageType != "src" ? public_path("/images/$imageType/$imagePath"): $srcPath;
            LoggerHelper::debug("Start - ".json_encode(func_get_args()));
            if(!file_exists($srcPath))
                return null;

            LoggerHelper::debug("File exists - $srcPath");
            if(file_exists($filePath))
                return $filePath;

            LoggerHelper::debug("Not Exists - $filePath");
            $dimension = self::getImageTypeResolution($imageType);

            LoggerHelper::debug("Image Type Dimensions - ".json_encode($dimension));
            if(!$dimension)
                return null;

            list($width, $height) = $dimension;

            ImageHelper::resize($srcPath, $filePath, $width, $height);
            LoggerHelper::debug("Resized - $filePath");
            return $filePath;

        }catch(\Throwable $t){
            LoggerHelper::error($t->getMessage());
            return null;
        }
    }

    public static function getImageTypeResolution($imageType){

        switch($imageType){
            case "2x":
            case "thumbnails":
                return [300, 300];
            case "3x":
                return [100, 100];
            default:
                return [];
        }
    }


}
