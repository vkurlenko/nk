<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Лица проекта';
?>

<div class="container main">

    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <section id="person" class="section-center">
        <hr>
        <!--<div class="container-fluid ">
           div class="row flex-container">
               <div class="col-sm-1">
                   <a href="/">Назад</a>
               </div>
               <div class="col-sm-10">

                       <h2>Татьяна, Калининград</h2>

               </div>
               <div class="col-sm-1">
                   <a href="/">Вперед</a>
               </div>
           </div>
       </div>-->

        <div class="person-nav">
            <a href="/" class="person-prev">&lt;&nbsp;Назад</a>
            <h2>Татьяна, Калининград</h2>
            <a href="/" class="person-next">Вперед&nbsp;&gt;</a>
        </div>

        <div class="container-fluid person-images">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 person-img-1">
                    <img src="/images/person1.jpg" width="355">

                    <div class="person-text">
                        Победитель проекта "Кондитер&nbsp;2"
                    </div>


                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 person-img-2">
                    <img src="/images/person2.jpg">

                    <img src="/images/person_cake.jpg">
                    <!--<img src="/tpl/bar1.jpg">-->
                </div>
            </div>
        </div>



    </section>

    <section class="section-center">
        <hr>
        <h2>Биография участника</h2>
        <hr>

        <p>Ренат Агзамов представляет проект "Народный кондитер".<br>
            Участником проекта может стать каждый, кто любит готовить и радовать своих родных и друзей.
        </p>
        <hr>
    </section>

    <section id="supervision" class="section-center alignment-block">
        <h2>Видео с Татьяной</h2>

        <hr>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 video align-left">
                    <div class="yt-cover yt-start" data-src="BrQ17Yqbe70">
                        <img src="/images/6456.jpg">
                        <div class="yt-container">
                            <i class="far fa-play-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 video align-right">
                    <div class="yt-cover yt-start" data-src="BrQ17Yqbe70">
                        <img src="/images/6456.jpg">
                        <div class="yt-container">
                            <i class="far fa-play-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h2>Авторский надзор</h2>

        <hr>

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12 video">
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

</div>

