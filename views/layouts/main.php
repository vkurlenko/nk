<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\controllers\SiteController;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/web/favicon.ico'])]);?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <header>
        <?php
        $arr = SiteController::makeMainMenu();

        NavBar::begin(['brandImage' => '/tpl/logo.png']);

        echo Nav::widget([
            'items' => $arr,
            'options' => ['class' => 'navbar-nav navbar-center'],
        ]);
        NavBar::end();
        ?>
    </header>

    

    <!-- <div class="container main"> -->
    <?php
    echo $content;
    ?>
   <!--  </div> -->
</div>

<?= $this->render('/site/blocks/footer') ?>

<section id="copyright" class="container section-center">
    Официальный сайт "Народный кондитер". Копирование материалов только с разрешения владельца сайта
</section>

<hr class="hr-bottom">

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>


