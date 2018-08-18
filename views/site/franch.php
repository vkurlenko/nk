<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container main">
    <div class="container">
        <section class="section-center">
        <h1><?= Html::encode($this->title) ?></h1>
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
        echo $this->render('/site/blocks/form-franch', compact('model'));
        ?>

    </section>



</div>


