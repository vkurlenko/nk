<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <header>
        <?php
        NavBar::begin(['brandImage' => '/tpl/logo.png']);
        echo Nav::widget([
            'items' => [
                ['label' => 'О проекте', 'url' => ['/site/about']],
                ['label' => 'Продукция', 'url' => ['/site/about']],
                ['label' => 'Франчайзинг', 'url' => ['/site/franch']],
                [
                    'label' => 'Где купить',
                    'items' => [
                        ['label' => 'Москва', 'url' => '#', 'options' => ['class' => 'first-item'],],
                        ['label' => 'Санкт-Петербург', 'url' => '#'],
                        ['label' => 'Казань', 'url' => '#'],
                        ['label' => 'Екатеринбург', 'url' => '#'],
                        ['label' => 'Самара', 'url' => '#'],
                        ['label' => 'Калининград', 'url' => '#']
                    ],
                    'options' => ['class' => 'submenu'],
                ],

               /* ['label' => 'Контакты', 'url' => ['/site/about']],*/
            ],
            'options' => ['class' => 'navbar-nav navbar-center'],
        ]);
        NavBar::end();
        ?>
    </header>

    

    <!-- <div class="container main"> -->
    <?php
    echo $content;
    ?>
   <!--  </div> -->
</div>

<footer>

    <div class="laces"></div>

    <div class="section-center  alignment-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-6  align-left footer-menu">
                    <span class="footer-menu-title">Информация</span>
                    <ul class="footer-menu">
                        <li><a href="">Правовая информация</a></li>
                        <li><a href="">Условия участия</a></li>
                        <li><a href="">Кастинги</a></li>
                        <li><a href="">Отправить заявку</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6  align-left footer-menu">
                    <span class="footer-menu-title">Информация</span>
                    <ul class="footer-menu">
                        <li><a href="">Правовая информация</a></li>
                        <li><a href="">Условия участия</a></li>
                        <li><a href="">Кастинги</a></li>
                        <li><a href="">Отправить заявку</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 align-left footer-menu footer-menu-social">
                    <span class="footer-menu-title">Социальные сети</span>
                    <ul class="footer-menu social-menu">
                        <li class="social"><a href=""><img src="/tpl/icons/vk.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/fb.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/tw.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/ok.jpg"></a></li>

                        <li class="social" style="clear:both;"><a href=""><img src="/tpl/icons/in.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/go.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/ms.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/yt.jpg"></a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</footer>

<section id="copyright" class="container section-center">
    Официальный сайт "Народный кондитер". Копирование материалов только с разрешения владельца сайта
</section>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


