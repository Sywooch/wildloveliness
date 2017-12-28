<?php

namespace app\modules\filemanager\assets;

use yii\web\AssetBundle;

class FilemanagerAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/filemanager/assets/src';

    public $css = [
        'css/filemanager.css',
        'css/imgareaselect.css'
    ];
    public $js = [
        'js/jquery-dateFormat.min.js',
        'js/custom.js',
        'js/jquery.knob.js',
        'js/mini-main.js',
        'js/jquery.imgareaselect.min.js',
        'js/crop-image.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}



