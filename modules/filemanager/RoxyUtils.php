<?php

namespace app\modules\filemanager;

use Yii;
use app\helpers\DevHelper;

class RoxyUtils {

    static public function fixPath($path){
        $path = $_SERVER['DOCUMENT_ROOT'].'/'.$path;
        $path = str_replace('\\', '/', $path);
        $path = RoxyFile::FixPath($path);
        return $path;
    }

    static public function t($key){
        global $LANG;
        if(empty($LANG)){
            $file = 'ru.json';
            $langPath = RoxyFile::FixPath(Yii::getAlias('@app/modules/filemanager/lang/'));//'../lang/';
            if(Filemanager::$moduleParams['LANG']){
                if(LANG == 'auto'){
                    $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
                    if(is_file($langPath.$lang.'.json'))
                        $file = $lang.'.json';
                }
                elseif(is_file($langPath.LANG.'.json'))
                    $file = LANG.'.json';
            }
            $file = $langPath.$file;

            //DevHelper::preArray($file,1);

            $LANG = json_decode(file_get_contents($file), true);
        }
        if(!$LANG[$key])
            $LANG[$key] = $key;

        return $LANG[$key];
    }

//    static public function fixPath($path){
//        $ret = false;
//        if(mb_strpos($path.'/', RoxyUtils::getFilesPath()) === 0)
//            $ret = true;
//
//        return $ret;
//    }

//    function checkPath($path){
//        $ret = false;
//        if(mb_strpos($path.'/', RoxyUtils::getFilesPath()) === 0)
//            $ret = true;
//
//        return $ret;
//    }

//    static public function verifyAction($action){
//        if(!defined($action) || !constant($action))
//            exit;
//        else{
//            $confUrl = constant($action);
//            $qStr = mb_strpos($confUrl, '?');
//            if($qStr !== false)
//                $confUrl = mb_substr ($confUrl, 0, $qStr);
//            $confUrl = \Yii::$app->controller->module->params['BASE_PATH'].'/'.$confUrl;
//            $confUrl = RoxyFile::FixPath($confUrl);
//            $thisUrl = dirname(__FILE__).'/'.basename($_SERVER['PHP_SELF']);
//            $thisUrl = RoxyFile::FixPath($thisUrl);
//
//
//            if($thisUrl != $confUrl){
//                echo "$confUrl $thisUrl";
//                exit;
//            }
//        }
//    }

//    static public function verifyPath($path){
//        if(!RoxyUtils::checkPath($path)){
//            echo RoxyUtils::getErrorRes("Access to $path is denied").' '.$path;
//            exit;
//        }
//    }

    static public function gerResultStr($type, $str = ''){
        return '{"res":"'.  addslashes($type).'","msg":"'.  addslashes($str).'"}';
    }

    static public function getSuccessRes($str = ''){
        return RoxyUtils::gerResultStr('ok', $str);
    }

    static public function getErrorRes($str = ''){
        return RoxyUtils::gerResultStr('error', $str);
    }

    static public function getFilesPath(){
        $ssPathKey = Filemanager::$moduleParams['SESSION_PATH_KEY'];
        $filesRoot = Filemanager::$moduleParams['FILES_ROOT'];
        $basePath = Filemanager::$moduleParams['BASE_PATH'];
        $ret = (isset($_SESSION[$ssPathKey]) && $_SESSION[$ssPathKey] != '' ? $_SESSION[$ssPathKey] : $basePath.'/'.$filesRoot);
        if($ret === $basePath.'/'){
            $ret = RoxyFile::FixPath(Yii::getAlias('@webroot').'/uploads');
            $tmp = $_SERVER['DOCUMENT_ROOT'];
            if(mb_substr($tmp, -1) == '/' || mb_substr($tmp, -1) == '\\')
                $tmp = mb_substr($tmp, 0, -1);
            $ret = str_replace(RoxyFile::FixPath($tmp), '', $ret);
        }
        return $ret;
    }

    static function listDirectory($path){
        $ret = @scandir($path);
        if($ret === false){
            $ret = array();
            $d = opendir($path);
            if($d){
                while(($f = readdir($d)) !== false){
                    $ret[] = $f;
                }
                closedir($d);
            }
        }
        return $ret;
    }

    public function prepareZipDir(){
        $basePath = Filemanager::$moduleParams['BASE_PATH'];
        $zipDirName = Filemanager::$moduleParams['ZIP_DIR_NAME'];
        // создаем временную папку для архивов если ее нет
        // если папка существует, удаляем в ней все старые архивы
        $zipDir = RoxyUtils::fixPath($basePath.'/'.$zipDirName);
        if(!is_dir($zipDir)) {
            mkdir($zipDir);
        } else {
            array_map('unlink', glob($zipDir."/*.zip"));
        }
        return $zipDir;
    }



}