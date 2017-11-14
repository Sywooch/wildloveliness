<?php

namespace app\modules\filemanager\controllers;

use app\helpers\DevHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\filemanager\RoxyFile;
use app\modules\filemanager\RoxyUtils;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'getjsonconfig',
                            'getjsonlang',
                            'getdirtree',
                            'getfileslist',
                            'createdir'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'getjsonconfig' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetjsonconfig(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \Yii::$app->controller->module->params;
    }

    public function actionGetjsonlang(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return file_get_contents( __DIR__ . '/../lang/'.\Yii::$app->controller->module->params['LANG'].'.json', true);
    }




    //
    // DIRECTORIES
    //

    public function actionGetdirtree(){
        $type = (empty($_GET['type']) ? '' : strtolower($_GET['type']));
        if ($type != 'image' && $type != 'flash')
            $type = '';
        echo "[\n";
        $tmp = $this->getFilesNumber(RoxyUtils::fixPath(RoxyUtils::getFilesPath()), $type);
        echo '{"p":"' . mb_ereg_replace('"', '\\"', RoxyUtils::getFilesPath()) . '","f":"' . $tmp['files'] . '","d":"' . $tmp['dirs'] . '"}';
        $this->GetDirs(RoxyUtils::getFilesPath(), $type);
        echo "\n]";
    }



    public function getFilesNumber($path, $type){
        $files = 0;
        $dirs = 0;

        $tmp = RoxyUtils::listDirectory($path);

        foreach ($tmp as $ff){
            if($ff == '.' || $ff == '..')
                continue;
            elseif(is_file($path.'/'.$ff) && ($type == '' || ($type == 'image' && RoxyFile::IsImage($ff)) || ($type == 'flash' && RoxyFile::IsFlash($ff))))
                $files++;
            elseif(is_dir($path.'/'.$ff))
                $dirs++;
        }

        return array('files'=>$files, 'dirs'=>$dirs);
    }

    public function GetDirs($path, $type){
        $ret = $sort = array();
        $files = RoxyUtils::listDirectory(RoxyUtils::fixPath($path), 0);
        foreach ($files as $f){
            $fullPath = $path.'/'.$f;
            if(!is_dir(RoxyUtils::fixPath($fullPath)) || $f == '.' || $f == '..')
                continue;
            $tmp = $this->getFilesNumber(RoxyUtils::fixPath($fullPath), $type);
            $ret[$fullPath] = array('path'=>$fullPath,'files'=>$tmp['files'],'dirs'=>$tmp['dirs']);
            $sort[$fullPath] = $f;
        }
        natcasesort($sort);
        foreach ($sort as $k => $v) {
            $tmp = $ret[$k];
            echo ',{"p":"'.mb_ereg_replace('"', '\\"', $tmp['path']).'","f":"'.$tmp['files'].'","d":"'.$tmp['dirs'].'"}';
            $this->GetDirs($tmp['path'], $type);
        }
    }

    public function actionCreatedir(){
        //verifyAction('CREATEDIR');
        //checkAccess('CREATEDIR');

        $path = trim(empty($_POST['d'])?'':$_POST['d']);
        $name = trim(empty($_POST['n'])?'':$_POST['n']);
        RoxyUtils::verifyPath($path);

        if(is_dir(RoxyUtils::fixPath($path))){
            if(mkdir(RoxyUtils::fixPath($path).'/'.$name, octdec(DIRPERMISSIONS)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(t('E_CreateDirFailed').' '.basename($path));
        }
        else
            echo  RoxyUtils::getErrorRes(t('E_CreateDirInvalidPath'));
    }



    //
    // FILES
    //

    public function actionGetfileslist(){
        //verifyAction('FILESLIST');
        //checkAccess('FILESLIST');

        $path = (empty($_POST['d'])? RoxyUtils::getFilesPath(): $_POST['d']);
        $type = (empty($_POST['type'])?'':strtolower($_POST['type']));
        if($type != 'image' && $type != 'flash')
            $type = '';
        RoxyUtils::verifyPath($path);

        $files = RoxyUtils::listDirectory(RoxyUtils::fixPath($path), 0);
        natcasesort($files);
        $str = '';
        echo '[';
        foreach ($files as $f){
            $fullPath = $path.'/'.$f;
            if(!is_file(RoxyUtils::fixPath($fullPath)) || ($type == 'image' && !RoxyFile::IsImage($f)) || ($type == 'flash' && !RoxyFile::IsFlash($f)))
                continue;
            $size = filesize(RoxyUtils::fixPath($fullPath));
            $time = filemtime(RoxyUtils::fixPath($fullPath));
            $w = 0;
            $h = 0;
            if(RoxyFile::IsImage($f)){
                $tmp = @getimagesize(RoxyUtils::fixPath($fullPath));
                if($tmp){
                    $w = $tmp[0];
                    $h = $tmp[1];
                }
            }
            $str .= '{"p":"'.mb_ereg_replace('"', '\\"', $fullPath).'","s":"'.$size.'","t":"'.$time.'","w":"'.$w.'","h":"'.$h.'"},';
        }
        $str = mb_substr($str, 0, -1);
        echo $str;
        echo ']';
    }


}
