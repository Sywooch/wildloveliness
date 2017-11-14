<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 10.11.2017
 * Time: 23:34
 */

namespace app\modules\filemanager;


class RoxyImage{
    public static function GetImage($path){
        $img = null;
        $ext = RoxyFile::GetExtension(basename($path));
        switch($ext){
            case 'png':
                $img = imagecreatefrompng($path);
                break;
            case 'gif':
                $img = imagecreatefromgif($path);
                break;
            default:
                $img = imagecreatefromjpeg($path);
        }



        return $img;
    }
    public static function OutputImage($img, $type, $destination = '', $quality = 90){
        if(is_string($img))
            $img = self::GetImage ($img);
        switch(strtolower($type)){
            case 'png':
                imagepng($img, $destination);
                break;
            case 'gif':
                imagegif($img, $destination);
                break;
            default:
                imagejpeg($img, $destination, $quality);
        }
    }

    public static function SetAlpha($img, $path) {
        $ext = RoxyFile::GetExtension(basename($path));
        if($ext == "gif" || $ext == "png"){
            imagecolortransparent($img, imagecolorallocatealpha($img, 0, 0, 0, 127));
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }

        return $img;
    }

    public static function Resize($source, $destination, $width = '150',$height = 0, $quality = 90) {
        $tmp = getimagesize($source);
        $w = $tmp[0];
        $h = $tmp[1];
        $r = $w / $h;

        if($w <= ($width + 1) && (($h <= ($height + 1)) || (!$height && !$width))){
            if($source != $destination)
                self::OutputImage($source, RoxyFile::GetExtension(basename($source)), $destination, $quality);
            return;
        }

        $newWidth = $width;
        $newHeight = floor($newWidth / $r);
        if(($height > 0 && $newHeight > $height) || !$width){
            $newHeight = $height;
            $newWidth = intval($newHeight * $r);
        }

        $thumbImg = imagecreatetruecolor($newWidth, $newHeight);
        $img = self::GetImage($source);

        $thumbImg = self::SetAlpha($thumbImg, $source);

        imagecopyresampled($thumbImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);

        self::OutputImage($thumbImg, RoxyFile::GetExtension(basename($source)), $destination, $quality);
    }
    public static function CropCenter($source, $destination, $width, $height, $quality = 90) {
        $tmp = getimagesize($source);
        $w = $tmp[0];
        $h = $tmp[1];
        if(($w <= $width) && (!$height || ($h <= $height))){
            self::OutputImage(self::GetImage($source), RoxyFile::GetExtension(basename($source)), $destination, $quality);
        }
        $ratio = $width / $height;
        $top = $left = 0;

        $cropWidth = floor($h * $ratio);
        $cropHeight = floor($cropWidth / $ratio);
        if($cropWidth > $w){
            $cropWidth = $w;
            $cropHeight = $w / $ratio;
        }
        if($cropHeight > $h){
            $cropHeight = $h;
            $cropWidth = $h * $ratio;
        }

        if($cropWidth < $w){
            $left = floor(($w - $cropWidth) / 2);
        }
        if($cropHeight < $h){
            $top = floor(($h- $cropHeight) / 2);
        }

        self::Crop($source, $destination, $left, $top, $cropWidth, $cropHeight, $width, $height, $quality);
    }
    public static function Crop($source, $destination, $x, $y, $cropWidth, $cropHeight, $width, $height, $quality = 90) {
        $thumbImg = imagecreatetruecolor($width, $height);
        $img = self::GetImage($source);

        $thumbImg = self::SetAlpha($thumbImg, $source);

        imagecopyresampled($thumbImg, $img, 0, 0, $x, $y, $width, $height, $cropWidth, $cropHeight);

        self::OutputImage($thumbImg, RoxyFile::GetExtension(basename($source)), $destination, $quality);
    }
}