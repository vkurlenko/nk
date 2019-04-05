<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

if(!empty($cat)){
    $page_data['title'] .= ' "'.$cat['name'].'"';
    $page_data['h1'] = $cat['name'];
}

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);

//debug($products);
?>

<div class="container main">

    <h1><?=$page_data['h1']?></h1>


    <section id="products" class="section-center alignment-block">

        <div class="container-fluid">

            <div class="row">

                <hr>
                <?=$page_data['anons']?>
                <div style="clear:both;"></div>

                <div class="wrap1">

                <?php
                $i = 0;
                foreach($products as $product):?>

                    <?php
                    if($product['size']){
                        $col_size = 'col-sm-12 big-size';
                        $align = '';
                        $i = 1;
                    }
                    else{
                        $col_size = 'col-sm-6 col-xs-6';
                        $align = $i % 2 ? 'align-right' : 'align-left';
                    }
                    array_multisort (array_column($product['gallery'], 'sort'), SORT_ASC, $product['gallery']);

                    $first = array_shift($product['gallery']);

                    ?>

                    <div class="product <?= $col_size?> <?= $align ?> <?= $i ?>">
                        <span><?=Html::a($product['name'], '/product/' . $product['url_alias'])?><?/*= $product['name'] */?></span>
                        <a href="<?= Url::to(['product/' . $product['url_alias']]) ?>">
                            <?=Html::img('/'.$first['img'])?>
                        </a>
                        <p class="product-price"><?=$product['price'] ? $product['price'].'&nbsp;'.\app\controllers\AppController::getOption('currency') : ''?></p>
                    </div>

                <?php
                //echo $product['size'];
                if($i % 2)
                    echo '</div><div style="clear: both"></div><hr><div class="wrap1">';
                $i++;
                endforeach;
                ?>
                <div style="clear:both;"></div>
                <?=$page_data['content']?>



            </div>

        </div>

    </section>

</div>