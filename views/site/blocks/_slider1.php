<section id="slider1">
    <div class="slider-main">

        <?php
        foreach($gallery as $pic):
        ?>
            <div class="item active">
                <?= \yii\helpers\Html::img($pic->getUrl('847x486')) ?>
                <!--<img src="/web/images/slide1.jpg" alt="">-->
                <div class="carousel-caption-nk">
                    Победитель проекта: Светлана
                </div>
            </div>
        <?php
        endforeach;
        ?>

        <!--<div class="item active">
            <img src="/web/images/slide1.jpg" alt="">
            <div class="carousel-caption-nk">
                Победитель проекта: Светлана
            </div>
        </div>

        <div class="item">
            <img src="/web/images/slide2.jpg" alt="">
            <div class="carousel-caption-nk">
                Победитель проекта: Ирина
            </div>
        </div> -->

    </div>
    <div class="carousel-caption-nk-bg"></div>
    <div class="laces"></div>
</section>

<?php

//debug($gallery);