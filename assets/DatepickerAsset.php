<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        'datepicker/css/bootstrap-datepicker.css',
        //'datepicker/css/bootstrap-datepicker.min.css',
    ];
    public $js = [
        'datepicker/js/bootstrap-datepicker.js',
        'datepicker/locales/bootstrap-datepicker.ru.js', // файл перевода на русский
        'datepicker/js/bootstrap-datepicker-init.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}