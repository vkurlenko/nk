<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
//$this->params['breadcrumbs'][] = $this->title;

//debug($jury);

?>
<div class="container main">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <section id="jury" class="section-center">
        <div class="container-fluid">
            <hr>
            <?php
            $i = 0;
            foreach($jury as $m):
            ?>

            <div class="col-xs-6 col-sm-6 col-md-4">

                <div class="j-img">
                    <?=Html::img($m['photo'])?>
                </div>
                <span class="j-name"><?=$m['name']?></span>
                <p class="j-descr"><?=$m['descr']?></p>

            </div>

            <?php
            $d = $i % 2;
            if($d)
                echo '<div class="clear-2"></div>';

            $d = $i % 3;
            if($d == 2)
                echo '<div class="clear-3"></div>';

            $i++;
            endforeach;
            ?>

        </div>

        <hr>
    </section>
</div>



