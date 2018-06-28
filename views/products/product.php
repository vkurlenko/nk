<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;


$this->title = $product['name'];

//debug($product);
?>

<div class="container main">

    <h1><?=$product['name']?></h1>


    <section id="product" class="section-center alignment-block">
        <hr>

        <div class="container-fluid">

            <div class="gallery-view">
                <?php
                $arr = $product['gallery'];
                $first = array_shift($arr);
                ?>
                <?=Html::img('/'.$first['img'])?>
            </div>

            <hr>

            <div class="gallery-nav row">
                <?php
                $i = 0;
                foreach($product['gallery'] as $img):
                ?>
                <div class="item col-xs-4 col-sm-4 col-md-4">
                    <a href="#" class="link <?=!$i ? 'selected' : ''?>">
                        <?=Html::img('/'.$img['img'])?>

                    </a>
                </div>
                <?php
                $i++;
                endforeach;
                ?>
            </div>

            <hr>

            <?php
            if($product['video']):
                ?>

            <h3>Видео торта</h3>

            <hr>

            <div class="video">

                <!--<iframe width="640" src="https://www.youtube.com/embed/<?/*=$product['video']*/?>?autoplay=1" frameborder="0" allowfullscreen></iframe>-->


               <div class="yt-cover yt-start" data-src="<?=$product['video']?>">
                    <img src="<?=$product['cover']?>">
                    <div class="yt-container">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>

            </div>

            <hr>
            <?php
            endif;
            ?>

            <h2>Описание торта</h2>

            <hr>

            <div class="product-descr"><?=$product['descr']?>
            </div>



        </div>

        <hr>
    </section>

