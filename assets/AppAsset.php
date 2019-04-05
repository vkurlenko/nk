<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fonts.css',
        'js/slick-master/slick/slick.css',
        'js/slick-master/slick/slick-theme.css',
        'fonts/web-fonts-with-css/css/fontawesome-all.min.css',
        'js/jQueryFormStyler-master/dist/jquery.formstyler.css',
        'js/jQueryFormStyler-master/dist/jquery.formstyler.theme.css',
        'css/style.css?v=1.7',
        //'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css'
    ];
    public $js = [
        'js/slick-master/slick/slick.min.js',
        'js/picturefill.js',
        //'https://api-maps.yandex.ru/2.1/?apikey=92ef1e5f-a416-44d2-8586-4b72c927d350&lang=ru_RU',
        //'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js',
        'js/jQueryFormStyler-master/dist/jquery.formstyler.min.js',
        'js/script.js?v=1.4'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset',
    ];
}
