<?php

namespace app\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        'backend/css/admin.css',
    ];
    public $js = [

    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}