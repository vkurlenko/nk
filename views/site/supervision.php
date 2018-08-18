<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
?>

<div class="container main">

<div class="container">
    <section class="section-center">
    <h1><?= Html::encode($this->title) ?></h1>
        <hr>
    </section>
</div>



<section id="supervision" class="section-center alignment-block">

    <?php
    //debug($svision);
    ?>

    <p>Мы тщательно контролируем качество нашей продукции. Наши победители часто бывают на производстве и следят за соблюдением рецептуры</p>

    <hr>

    <div class="container-fluid">

        <div class="row">

            <?php
            $i = 0;
            foreach($svision as $video):

                if(!$video['size'])
                    $i % 2 ? $align = 'align-right' : $align = 'align-left';
                else{
                    $align = '';
                    $i = 1;
                }
                ?>

                <div class="<?= $video['size'] ? 'col-sm-12' : 'col-sm-6'?> video <?= $align;?>">
                    <div class="yt-cover yt-start" data-src="<?=$video['video']?>" data-source="<?=$video['source']?>">
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


    <hr>

</section>


</div>
