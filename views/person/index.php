<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

//debug($person);

if(empty($person)){
    Yii::$app->response->redirect(Url::to(['/persons']));
}


if(!$person['title'])
    $person['title'] = $person['name'].', '.$person['city_id'];

$this->title = $person['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $person['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $person['kwd']]);

//debug($person_nav);
?>

<div class="container main">

    <div class="container">
        <h1>Лица проекта</h1>
    </div>

    <section id="person" class="section-center">
        <hr>
        <div class="container-fluid person-nav">
           <div class="row">


               <div class="col-xs-6 col-sm-2 nav-arrow-prev">
                   <?php
                   if($person_nav['prev']):
                       ?>
                       <a href="/person/<?=$person_nav['prev']?>" class="person-prev" style="text-align:left">&lt;&nbsp;Назад </a>
                   <?php
                   endif;
                   ?>
               </div>

               <div class="col-xs-6 col-sm-2 nav-arrow-next-2">
                   <?php
                   if($person_nav['next']):
                       ?>
                       <a href="/person/<?=$person_nav['next']?>" class="person-next" style="text-align:right"> Вперед&nbsp;&gt;</a>
                   <?php
                   endif;
                   ?>
               </div>

               <div class="col-xs-12 col-sm-8">
                   <h2><?=$person['name']?>, <span><?=$person['city_id']?></span></h2>
               </div>

               <div class="col-xs-6 col-sm-2 nav-arrow-next">
                   <?php
                   if($person_nav['next']):
                       ?>
                       <a href="/person/<?=$person_nav['next']?>" class="person-next" style="text-align:right"> Вперед&nbsp;&gt;</a>
                   <?php
                   endif;
                   ?>
               </div>

           </div>
       </div>


        <div class="container-fluid person-images">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 person-img-1">
                    <?=Html::img('/'.$person['photo_big'][0], ['alt' => $person['photo_big'][1], 'title' => $person['photo_big'][1], 'id' => 'person-img-1'])?>

                    <?php
                    if($person['winner']):
                    ?>
                    <div class="person-text">
                        <?=$person['winner_text']?>
                    </div>
                    <?php
                    endif;
                    ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 person-img-2">
                    <?=Html::img('/'.$person['photo_small'][0], ['alt' => $person['photo_small'][1], 'title' => $person['photo_small'][1]])?>
                    <?=Html::img('/'.$person['photo_cake'][0], ['alt' => $person['photo_cake'][1], 'class'  => 'person-img-cake', 'title' => $person['photo_cake'][1]])?>
                </div>
            </div>
        </div>

    </section>
    <div style="clear: both"></div>
    <?php
    if($person['text']):
    ?>

    <section class="section-center">
        <hr>
        <h2>Об участнике</h2>
        <hr>
        <?=$person['text']?>
        <hr>
    </section>

    <?php
    endif;
    ?>


    <section id="supervision" class="section-center alignment-block">

        <?php
        if($video):
        ?>

        <h2>Видео с <?=$person['name']?></h2>

        <hr>

        <div class="container-fluid">
            <div class="row">

                <?php
                $i = 0;
                foreach($video as $v):
                    if(!$video['size'])
                        $i % 2 ? $align = 'align-right' : $align = 'align-left';
                    else{
                        $align = '';
                        $i = 1;
                    }
                ?>

                <div class="<?= $v['size'] ? 'col-sm-12' : 'col-sm-6'?> video <?= $align;?>">
                    <div class="yt-cover yt-start" data-src="<?='/'.$v['video']?>">
                        <img src="<?='/'.$v['cover']?>">
                        <div class="yt-container">
                            <i class="far fa-play-circle"></i>
                        </div>
                    </div>
                </div>

                <?php
                $i++;
                endforeach;
                ?>


            </div>
        </div>

        <hr>

        <?php
        endif;
        ?>



        <?php
        if($s_video):?>
            <h2>Авторский надзор</h2>

            <hr>

            <div class="container-fluid">

                <div class="row">

                    <?php
                    $i = 0;
                    foreach($s_video as $video):
                        if(!$video['size'])
                            $i % 2 ? $align = 'align-right' : $align = 'align-left';
                        else{
                            $align = '';
                            $i = 1;
                        }
                    ?>

                    <div class="<?= $video['size'] ? 'col-sm-12' : 'col-sm-6'?> video <?= $align;?>">
                        <div class="yt-cover yt-start" data-src="<?='/'.$video['video']?>">
                            <img src="<?='/'.$video['cover']?>">
                            <div class="yt-container">
                                <i class="far fa-play-circle"></i>
                            </div>
                        </div>

                        <span class="video-title"><?=$video['title']?></span>
                        <span class="video-date"><?=$video['date']?></span>
                        <p><?=$video['descr']?></p>
                        <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
                    </div>
                    
                    <?php
                    $i++;
                    endforeach;
                    ?>
                </div>
            </div>

            <hr>
        <?php
        endif;
        ?>



    </section>

</div>

