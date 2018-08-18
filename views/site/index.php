<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use app\controllers\PersonController;
use app\controllers\AppController;

$page = $page_data;
$this->title = $page['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['kwd']]);
?>

<?= $this->render('/site/blocks/_slider1', compact('gallery')) ?>

<div class="container main">

<section id="promo" class="section-center">
    <h1><?=$page['h1']?></h1>
    <!--<h1 style="font-family:'HelveticaNeueCyrLight'">Народный кондитер</h1>-->

    <?=$page['anons']?>

    <a href="/about">Подробнее &gt;</a>

    <hr>
</section>

    <?php
    if(AppController::getOption('persons_on_main')){
        echo $this->render('/site/blocks/persons_on_main', compact('persons_on_main'));
    }
    ?>

    <?php
    if(AppController::getOption('svision_on_main')){
        echo $this->render('/site/blocks/svision_on_main', compact('s_vision'));
    }
    ?>

    <?php
    if(AppController::getOption('take_part_on_main')){
        echo $this->render('/site/blocks/take_part_on_main');
    }
    ?>

</div>



