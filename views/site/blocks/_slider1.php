<?php
use yii\helpers\Html;
?>
<section id="slider1">
    <div class="slider-main" data-slick='{"autoplay": <?=\app\controllers\AppController::getOption('slider_auto_play') ?  'true' :  'false'?>, "autoplaySpeed": <?=\app\controllers\AppController::getOption('slider_delay')?>}'>

        <?php
        $i = 1;
        foreach($gallery as $pic):
        ?>
            <div class="item">
                <?= $pic['url'] ? Html::a(Html::img($pic->getPath('847x486')), $pic['url']) : Html::img($pic->getPath('847x486')) ?>
                <div class="carousel-caption-nk">
                    <?=$pic['name']?>
                </div>
            </div>
        <?php
        endforeach;
        ?>

    </div>
    <div class="carousel-caption-nk-bg"></div>
    <div class="laces"></div>
</section>

<?php

//debug($gallery);