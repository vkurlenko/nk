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
        'css/style.css?v=1.5',
    ];
    public $js = [
        'js/slick-master/slick/slick.min.js',
        'js/picturefill.js',
        'js/script.js?v=1.3'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}