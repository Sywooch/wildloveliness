<?php

namespace app\assets;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        // FONTS
        'https://fonts.googleapis.com/css?family=Kaushan+Script', // Kaushan Font
        'https://fonts.googleapis.com/css?family=Open+Sans:400,300,700',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', // Font-Awesome

        // OWL-CAROUSEL
        'frontend/plugins/owl-carousel/assets/owl.carousel.min.css',
        'frontend/plugins/owl-carousel/assets/owl.theme.default.min.css',


        'frontend/plugins/Lightbox/dist/css/lightbox.css',
        'frontend/plugins/Icons/et-line-font/style.css',

        'frontend/css/animate.css',
        'frontend/css/main.css'
    ];
    public $js = [
        'frontend/plugins/owl-carousel/owl.carousel.min.js',

        'frontend/plugins/WOW/dist/wow.min.js',

        'frontend/js/jquery.easing.min.js',
        'frontend/plugins/waypoints/jquery.waypoints.min.js',
        'frontend/plugins/waypoints.shortcuts/inview.min.js',
        'frontend/plugins/countTo/jquery.countTo.js',
        'frontend/plugins/inview/jquery.inview.min.js',
        'frontend/plugins/Lightbox/dist/js/lightbox.min.js',


        'frontend/js/wild.loveliness.js', // custom Wild Loveliness JavaScript

    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}