<?php

namespace app\assets;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        'frontend/css/main.css',
        'frontend/plugins/owl-carousel/owl.carousel.css',
        'frontend/plugins/owl-carousel/owl.theme.css',
        'frontend/plugins/owl-carousel/owl.transitions.css',
        'frontend/plugins/Lightbox/dist/css/lightbox.css',
        'frontend/plugins/Icons/et-line-font/style.css',
        'frontend/plugins/animate.css/animate.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'
    ];
    public $js = [
        'frontend/js/custom.js',
        'frontend/plugins/owl-carousel/owl.carousel.min.js',
        //'frontend/js/jquery.easing.min.js',
        //'frontend/plugins/waypoints/jquery.waypoints.min.js',
        //'frontend/plugins/countTo/jquery.countTo.js',
        'frontend/plugins/inview/jquery.inview.min.js',
        'frontend/plugins/Lightbox/dist/js/lightbox.min.js',
        'frontend/plugins/WOW/dist/wow.min.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}