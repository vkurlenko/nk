<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use app\controllers\PersonController;

$page = $page_data;
$this->title = $page['title'];
?>

<?= $this->render('/site/blocks/_slider1', compact('gallery')) ?>

<div class="container main">

<section id="promo" class="section-center">
    <h1><?=$page['h1']?></h1>
    <!--<h1 style="font-family:'HelveticaNeueCyrLight'">Народный кондитер</h1>-->

    <?=$page['anons']?>

    <a href="/about">Подробнее &gt;</a>

    <hr>
</section>

<section id="project-faces" class="section-center alignment-block">
    <h2>Лица проекта</h2>
    <!--<h2 style="font-family:'HelveticaNeueCyrThin'">Лица проекта</h2>-->

    <p>Знакомьтесь с участниками конкурса на лучший народный торт.</p>

    <a href="<?= Url::to(['/persons/'])?>">Все участники проекта &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <?php
            $i = 0;
            $img_key = 'photo_on_main';
            foreach($persons_on_main as $person):?>
                <div class="col-sm-6 col-xs-6 face <?= $i % 2 ? 'align-right':'align-left';  ?>">
                    <span><?=$person['name']?></span>
                    <a href="<?=Url::to(['person/'.$person['id']])?>">
                        <?=Html::img($person[$img_key][0], ['alt' => $person[$img_key][1], 'title' => $person[$img_key][1]])?>
                    </a>
                </div>
            <?php
            $i++;
            endforeach;
            ?>

        </div>

    </div>

    <hr>
</section>


<section id="supervision" class="section-center alignment-block">
    <h2>Авторский надзор</h2>

    <?php
    //debug($s_vision);
    ?>

    <p>Авторы тортов постоянно контролируют качество на местах</p>

    <a href="#">Все видео &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <?php
            $i = 0;
            foreach($s_vision as $video):
                ?>

                <div class="<?= $video['size'] ? 'col-sm-12' : 'col-sm-6'?> video <?= $i % 2 ? 'align-right' : 'align-left';?>">
                    <div class="yt-cover yt-start" data-src="<?=$video['video']?>">
                        <img src="<?=$video['cover']?>">
                        <div class="yt-container">
                            <i class="far fa-play-circle"></i>
                        </div>
                    </div>

                    <span class="video-title"><?=$video['title']?></span>
                    <span class="video-date"><?=$video['date']?><!--10 сентября, 2018--></span>
                    <p><?=$video['descr']?></p>
                    <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
                </div>

                <?php
                $i++;
            endforeach;
            ?>
        </div>
    </div>

    <!--<div class="container-fluid">

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
    </div>-->
    <hr>
</section>

<section id="takepart" class="section-center">
    <h2>Стать участником</h2>

    <p>Вы можете стать участником следующего конкурса</p>

    <button><span class="btn-title">Заполните анкету для кастинга</span><!-- <span class="arrow-rt"><img src="/tpl/arrow_tr.png"></span> --></button>

    <hr>
</section>

