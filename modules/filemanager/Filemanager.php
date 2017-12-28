<?php
namespace app\modules\filemanager;

use app\modules\admin\AdminModule;
use app\modules\filemanager\RoxyUtils;

class Filemanager extends AdminModule
{
    public $layout = false;
    public $controllerNamespace = 'app\modules\filemanager\controllers';
    static public $moduleParams;

    public function init()
    {
        parent::init();

        \Yii::configure($this, require __DIR__ . '/config.php'); // загрузка конфигурационного файла модуля
        self::$moduleParams = $this->params;

        $FilesRoot = RoxyUtils::fixPath(RoxyUtils::getFilesPath());

        if(!is_dir($FilesRoot)) {
            @mkdir($FilesRoot, octdec($this->params['DIRPERMISSIONS']));
        }
    }

}
