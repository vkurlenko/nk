<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use rico\yii2images;
use app\models\Pages;

//debug($img);

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
//$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container main">
        <div class="container">
            <section class="section-center">
                <h1><?= Html::encode($page_data['h1']) ?></h1>
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
            <?=$page_data['content']?>

            <?php
            //if($page_data['url'] == 'casting')
            echo $this->render('/site/blocks/form-casting', compact('model'));
            ?>

        </section>

    </div>

<?php
//debug($gallery);



