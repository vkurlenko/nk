<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$meta = ['title', 'kwd', 'dscr', 'h1'];

foreach($meta as $k){
    if(!$city[$k])
        $city[$k] = $page_data[$k];
}


$this->title = $city['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $city['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $city['kwd']]);

?>
<div class="container main">
    <div class="container">
        <h1><?= Html::encode($city['h1']) ?></h1>
    </div>

    <section id="markets" class="section-center">
        <div class="container-fluid">

            <div class="markets-city-herb">
                <?= Html::img($city['herb']);?>
            </div>

            <h2 class="markets-city-name"><?=$city['name']?></h2>

           <!-- <h3>Где можно купить наши торты</h3>-->

            <p><?=$city['text']?></p>

            <div class="flex-container">
            <?php
            if($city['logos']){
                foreach($city['logos'] as $logo):?>
                    <div class="markets-city-brand">
                        <?=Html::a(Html::img($logo['img']), $logo['url'], ['target'=>'_blank'])?>
                    </div>
                <?php
                endforeach;
            }
            ?>
            </div>

            <div class="markets-city-content content">
                <?php
                if($city['content']){
                    echo $city['content'];
                }
                ?>
            </div>





        </div>
    </section>
</div>



