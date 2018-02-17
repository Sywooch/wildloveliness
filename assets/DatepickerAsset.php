<?php

namespace app\assets;

use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        //'datepicker/css/bootstrap-datepicker.css',
        'datepicker/css/bootstrap-datepicker.min.css',
        'datepicker/css/datepickercustom.css',
    ];
    public $js = [
        //'datepicker/js/bootstrap-datepicker.js',
        'datepicker/js/bootstrap-datepicker.min.js',
        'datepicker/locales/bootstrap-datepicker.ru.js', // файл перевода на русский
        'datepicker/js/bootstrap-datepicker-init.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}