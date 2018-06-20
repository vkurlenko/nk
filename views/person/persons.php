<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$page = $page_data;
$this->title = $page['title'];

//debug($persons);
?>

<div class="container main">

    <h1>Лица проекта</h1>

    <section id="project-faces all-faces" class="section-center alignment-block">


        <div class="container-fluid">

            <div class="row">

                <div class="year-list">
                    <ul>
                        <?php
                        if($years){
                            foreach($years as $k => $v):?>
                            <li <?= Yii::$app->request->get('year') == $v['year'] ? 'class="active"' : '';?>><?=Html::a($v['year'], '/persons/'.$v['year']);?></li>
                            <?php
                            endforeach;
                        }
                        ?>
                        <li <?= Yii::$app->request->get('year') ? '' : 'class="active"'; ?>><?=Html::a('Все', '/persons');?></li>
                    </ul>

                </div>

                <?php

                $img_key = 'photo_on_main';
                $city_id = '';
                $i = 0;
                foreach($persons as $city) {

                    foreach($city as $person){

                        if ($city_id != $person['city_id']) {
                            $city_id = $person['city_id'];
                            $i = 0;
                            ?>
                            <div style="clear: both"></div>
                            <div class="city-name">
                                <span ><?= $city_id ?></span>
                                <hr>
                            </div>
                            <?php
                        }

                        ?>
                        <div class="col-sm-6 col-xs-6 face <?= $i % 2 ? 'align-right' : 'align-left'; ?>">
                            <span><?= $person['name'] ?></span>
                            <a href="<?= Url::to(['person/' . $person['id']]) ?>">
                                <?= Html::img($person[$img_key][0], ['alt' => $person[$img_key][1], 'title' => $person[$img_key][1]]) ?>
                            </a>
                            <div style="clear: both"></div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>
            </div>

        </div>

        <hr>
    </section>

