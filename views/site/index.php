<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\models\Pages;

$this->title = 'Народный кондитер';

$page = Pages::findOne(1);
$gallery = $page->getImages();

?>

<?= $this->render('/site/blocks/_slider1', compact('gallery')) ?>


<div class="container main">




<section id="promo" class="section-center">
    <h1>Народный кондитер</h1>
    <!--<h1 style="font-family:'HelveticaNeueCyrLight'">Народный кондитер</h1>-->

    <p>Ренат Агзамов представляет проект "Народный кондитер".<br>
        Участником проекта может стать каждый, кто любит готовить и радовать своих родных и друзей.
    </p>
    <a href="#">Подробнее &gt;</a>

    <hr>
</section>

<section id="project-faces" class="section-center alignment-block">
    <h2>Лица проекта</h2>
    <!--<h2 style="font-family:'HelveticaNeueCyrThin'">Лица проекта</h2>-->

    <p>Знакомьтесь с участниками конкурса на лучший народный торт.</p>

    <a href="<?= Url::to(['person'])?>">Все участники проекта &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-6 col-xs-6 face align-left">
                <span>Марго</span>
                <a href="/web/site/person/">
                    <img src="/images/face1.jpg" width="350">
                </a>
            </div>
            <div class="col-sm-6 col-xs-6 face align-right">
                <span>Люсинэ</span>
                <a href="/web/site/person/">
                    <img src="/images/face2.jpg" width="350">
                </a>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6 face align-left">
                <span>Марго</span>
                <a href="/web/site/person/">
                    <img src="/images/face3.jpg" width="350">
                </a>
            </div>
            <div class="col-sm-6 col-xs-6 face align-right">
                <span>Люсинэ</span>
                <a href="/web/site/person/">
                    <img src="/images/face4.jpg" width="350">
                </a>
            </div>

        </div>

    </div>

    <hr>
</section>

<section id="supervision" class="section-center alignment-block">
    <h2>Авторский надзор</h2>

    <p>Авторы тортов постоянно контролируют качество на местах</p>

    <a href="/web/site/supervision/">Все видео &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-6 video align-left">

                <div class="yt-cover yt-start" data-src="BrQ17Yqbe70" id="BrQ17Yqbe70">
                    <img src="/images/6456.jpg">
                    <div class="yt-container">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>

                <span class="video-title">Маша Иванова в Самаре</span>
                <span class="video-date">10 сентября, 2018</span>
                <p>Маша посетила производство тортов на фабрике "Конфети", качество на высоте!</p>
                <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
            </div>

            <div class="col-sm-6 video align-right">
                <div class="yt-cover yt-start" data-src="BrQ17Yqbe70">
                    <img src="/images/6456.jpg">
                    <div class="yt-container">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>
                <span class="video-title">Маша Иванова в Самаре</span>
                <span class="video-date">10 сентября, 2018</span>
                <p>Маша посетила производство тортов на фабрике "Конфети", качество на высоте!</p>
                <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
            </div>

        </div>
    </div>
    <hr>
</section>
<section id="takepart" class="section-center">
    <h2>Стать участником</h2>

    <p>Вы можете стать участником следующего конкурса</p>

    <button><span class="btn-title">Заполните анкету для кастинга</span><!-- <span class="arrow-rt"><img src="/tpl/arrow_tr.png"></span> --></button>

    <hr>
</section>

