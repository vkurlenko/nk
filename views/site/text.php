<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use rico\yii2images;
use app\models\Pages;

//debug($img);

$this->title = $data['title'];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container main">
    <div class="container">
        <section class="section-center">
        <h1><?= Html::encode($data['h1']) ?></h1>
        <hr>
        </section>
    </div>

    <?php
    if($img && $img->urlAlias != 'placeHolder'):
    ?>
    <div class="about-img-block">
        <picture>
            <!--<source srcset="/images/about_mini.jpg" media="(max-width: 768px)">-->
            <source srcset="<?='/upload/store/'.$img->filePath?>">
            <img srcset="/images/about.jpg" alt="Народный кондитер">
        </picture>
    </div>
    <?php
    endif;
    ?>

    <section id="about" class="section-center">
        <?=$data['content']?>
    </section>

</div>

<?php
//debug($gallery);



