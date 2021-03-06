<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use rico\yii2images;
use app\models\Pages;

$this->title = 'О проекте';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container main">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <hr>

    </div>

    <?php
    $page = Pages::findOne(2);

    //debug($page->getImage());
    $img = $page->getImage();
    $gallery = $page->getImages();

    //echo Html::img($img->getUrl());

    foreach($gallery as $pic){
        echo Html::img('/upload/store/'.$pic->filePath);
    }

    ?>

    <div class="about-img-block">
       <!-- <img class="about-img" data-mini="/images/about_mini.jpg" data-original="/images/about.jpg" src="/images/about.jpg">-->
        <picture>
            <source srcset="/images/about_mini.jpg" media="(max-width: 768px)">
            <source srcset="/images/about.jpg">
            <img srcset="/images/about.jpg" alt="Народный кондитер">
        </picture>
    </div>

    <section id="about" class="section-center">
        <h2>О проекте "Народный кондитер"</h2>
        <hr>
        <p>
        Разнообразный и богатый опыт рамки и место обучения кадров позволяет выполнять важные задания по разработке форм развития. Таким образом начало повседневной работы по формированию позиции представляет собой интересный эксперимент проверки систем массового участия. Равным образом консультация с широким активом обеспечивает широкому кругу (специалистов) участие в формировании направлений прогрессивного развития. Товарищи! новая модель организационной деятельности требуют определения и уточнения модели развития.
        </p>
        <h3>Цели проекта</h3>
        <p>
        Задача организации, в особенности же консультация с широким активом требуют определения и уточнения систем массового участия. Повседневная практика показывает, что консультация с широким активом влечет за собой процесс внедрения и модернизации дальнейших направлений развития. Идейные соображения высшего порядка, а также постоянный количественный рост и сфера нашей активности требуют определения и уточнения систем массового участия. С другой стороны сложившаяся структура организации влечет за собой процесс внедрения и модернизации модели развития.
        </p>
        <hr>
    </section>
</div>



