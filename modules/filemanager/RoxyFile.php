<?php

namespace app\modules\filemanager;

use app\helpers\DevHelper;
use ZipArchive;


class RoxyFile {
    static public function CheckWritable($dir){
        $ret = false;
        if(self::CreatePath($dir)){
            $dir = self::FixPath($dir.'/');
            $testFile = 'writetest.txt';
            $f = @fopen($dir.$testFile, 'w', false);
            if($f){
                fclose($f);
                $ret = true;
                @unlink($dir.$testFile);
            }
        }

        return $ret;
    }
    static function CanUploadFile($filename){
        $forbiddenUploaud = Filemanager::$moduleParams['FORBIDDEN_UPLOADS'];
        $allowedUploads = Filemanager::$moduleParams['ALLOWED_UPLOADS'];

        $ret = false;
        $forbidden = array_filter(preg_split('/[^\d\w]+/', strtolower($forbiddenUploaud)));
        $allowed = array_filter(preg_split('/[^\d\w]+/', strtolower($allowedUploads)));
        $ext = RoxyFile::GetExtension($filename);
        if((empty($forbidden) || !in_array($ext, $forbidden)) && (empty($allowed) || in_array($ext, $allowed)))
            $ret = true;
        return $ret;
    }
    static function ZipAddDir($path, $zip, $zipPath){
        $d = opendir($path);
        $zipPath = str_replace('//', '/', $zipPath);
        if($zipPath && $zipPath != '/'){
            $zip->addEmptyDir($zipPath);
        }
        while(($f = readdir($d)) !== false){
            if($f == '.' || $f == '..')
                continue;
            $filePath = $path.'/'.$f;
            if(is_file($filePath)){
                $zip->addFile($filePath, ($zipPath?$zipPath.'/':'').$f);
            }
            elseif(is_dir($filePath)){
                self::ZipAddDir($filePath, $zip, ($zipPath?$zipPath.'/':'').$f);
            }
        }
        closedir($d);
    }
    static function ZipDir($path, $zipFile, $zipPath = ''){
        $zip = new ZipArchive();
        $zip->open($zipFile, ZIPARCHIVE::CREATE);
        self::ZipAddDir($path, $zip, $zipPath);
        $zip->close();
    }
    static function IsImage($fileName){
        $ret = false;
        $ext = strtolower(self::GetExtension($fileName));
        if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'jpe' || $ext == 'png' || $ext == 'gif' || $ext == 'ico')
            $ret = true;
        return $ret;
    }
    static function IsFlash($fileName){
        $ret = false;
        $ext = strtolower(self::GetExtension($fileName));
        if($ext == 'swf' || $ext == 'flv' || $ext == 'swc' || $ext == 'swt')
            $ret = true;
        return $ret;
    }
    /**
     * Returns human formated file size
     *
     * @param int $filesize
     * @return string
     */
    static function FormatFileSize($filesize){
        $ret = '';
        $unit = 'B';
        if($filesize > 1024){
            $unit = 'KB';
            $filesize = $filesize / 1024;
        }
        if($filesize > 1024){
            $unit = 'MB';
            $filesize = $filesize / 1024;
        }
        if($filesize > 1024){
            $unit = 'GB';
            $filesize = $filesize / 1024;
        }

        $ret = round($filesize, 2).' '.$unit;
        return $ret;
    }
    /**
     * Returns MIME type of $filename
     *
     * @param string $filename
     * @return string
     */
    static function GetMIMEType($filename){
        $type = 'application/octet-stream';
        $ext = self::GetExtension($filename);

        switch(strtolower($ext)){
            case 'jpg':  $type = 'image/jpeg';break;
            case 'jpeg': $type = 'image/jpeg';break;
            case 'gif':  $type = 'image/gif';break;
            case 'png':  $type = 'image/png';break;
            case 'bmp':  $type = 'image/bmp';break;
            case 'tiff': $type = 'image/tiff';break;
            case 'tif':  $type = 'image/tiff';break;
            case 'pdf':  $type = 'application/pdf';break;
            case 'rtf':  $type = 'application/msword';break;
            case 'doc':  $type = 'application/msword';break;
            case 'xls':  $type = 'application/vnd.ms-excel'; break;
            case 'zip':  $type = 'application/zip'; break;
            case 'swf':  $type = 'application/x-shockwave-flash'; break;
            default: $type = 'application/octet-stream';
        }

        return $type;
    }

    /**
     * Replaces any character that is not letter, digit or underscore from $filename with $sep
     *
     * @param string $filename
     * @param string $sep
     * @return string
     */
    static function CleanupFilename($filename, $sep = '_'){
        $str = '';
        if(strpos($filename,'.')){
            $ext = self::GetExtension($filename) ;
            $name = self::GetName($filename);
        }
        else{
            $ext = '';
            $name = $filename;
        }
        if(mb_strlen($name) > 32)
            $name = mb_substr($name, 0, 32);
        $str = str_replace('.php', '', $str);
        $str = mb_ereg_replace("[^\\w]", $sep, $name);

        $str = mb_ereg_replace("$sep+", $sep, $str).($ext?'.'.$ext:'');

        return $str;
    }

    /**
     * Returns file extension without dot
     *
     * @param string $filename
     * @return string
     */
    static function GetExtension($filename) {
        $ext = '';

        if(mb_strrpos($filename, '.') !== false)
            $ext = mb_substr($filename, mb_strrpos($filename, '.') + 1);

        return strtolower($ext);
    }

    /**
     * Returns file name without extension
     *
     * @param string $filename
     * @return string
     */
    static function GetName($filename) {
        $name = '';
        $tmp = mb_strpos($filename, '?');
        if($tmp !== false)
            $filename = mb_substr ($filename, 0, $tmp);
        $dotPos = mb_strrpos($filename, '.');
        if($dotPos !== false)
            $name = mb_substr($filename, 0, $dotPos);
        else
            $name = $filename;

        return $name;
    }
    static function GetFullName($filename) {
        $tmp = mb_strpos($filename, '?');
        if($tmp !== false)
            $filename = mb_substr ($filename, 0, $tmp);
        $filename = basename($filename);

        return $filename;
    }
    static public function FixPath($path){
        $path = mb_ereg_replace('[\\\/]+', '/', $path);
        return $path;
    }
    /**
     * creates unique file name using $filename( " - Copy " and number is added if file already exists) in directory $dir
     *
     * @param string $dir
     * @param string $filename
     * @return string
     */
    static function MakeUniqueFilename($dir, $filename){
        $temp = '';
        $dir .= '/';
        $dir = self::FixPath($dir.'/');
        $ext = self::GetExtension($filename);
        $name = self::GetName($filename);
        $name = self::CleanupFilename($name);
        $name = mb_ereg_replace(' \\- Copy \\d+$', '', $name);
        if($ext)
            $ext = '.'.$ext;
        if(!$name)
            $name = 'file';

        $i = 0;
        do{
            $temp = ($i > 0? $name." - Copy $i": $name).$ext;
            $i++;
        }while(file_exists($dir.$temp));

        return $temp;
    }
    /**
     * creates unique directory name using $name( " - Copy " and number is added if directory already exists) in directory $dir
     *
     * @param string $dir
     * @param string $name
     * @return string
     */
    static function MakeUniqueDirname($dir, $name){
        $temp = '';
        $dir = self::FixPath($dir.'/');
        $name = mb_ereg_replace(' - Copy \\d+$', '', $name);
        if(!$name)
            $name = 'directory';

        $i = 0;
        do{
            $temp = ($i? $name." - Copy $i": $name);
            $i++;
        }while(is_dir($dir.$temp));

        return $temp;
    }
}