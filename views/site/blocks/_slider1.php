<section id="slider1">
    <div class="slider-main">

        <?php
        $i = 1;
        foreach($gallery as $pic):
        ?>
            <div class="item">
                <?= \yii\helpers\Html::img($pic->getPath('847x486')) ?>
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