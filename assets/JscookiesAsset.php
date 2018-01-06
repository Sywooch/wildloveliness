<?php

namespace app\assets;

use yii\web\AssetBundle;

class JscookiesAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $js = [
        'jscookies/js/js-cookies.js',
    ];
}