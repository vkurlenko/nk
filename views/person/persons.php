<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $page_data['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);

//debug($persons);
?>

<div class="container main">

    <h1>Лица проекта</h1>

    <section id="project-faces" class="section-center alignment-block">


        <div class="container-fluid">

            <div class="row">

                <div class="year-list">
                    <ul>
                        <?php
                        if($years && count($years) > 1){
                            foreach($years as $k => $v):?>
                            <li <?= Yii::$app->request->get('year') == $v['year'] ? 'class="active"' : '';?>><?=Html::a($v['year'], '/persons/'.$v['year']);?></li>
                            <?php
                            endforeach;
                        }
                        ?>

                        <?php
                        if(count($years) > 1):
                        ?>
                        <li <?= Yii::$app->request->get('year') ? '' : 'class="active"'; ?>><?=Html::a('Все', '/persons');?></li>
                        <?php
                        endif;
                        ?>
                    </ul>

                </div>

                <?php

                $img_key = 'photo_on_main';
                $city_id = '';
                //$i = 0;
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

                        if($person['url_alias'] != '')
                            $person['id'] = $person['url_alias'];
                        ?>
                        <div class="col-sm-6 col-xs-6 face <?= $i % 2 ? 'align-right' : 'align-left'; ?>">
                            <span><?= $person['name'] ?></span>
                            <?/*= $person['url_alias'] */?>



                            <div class="face-wrap">
                                <a href="<?= Url::to(['person/' . $person['id']]) ?>">
                                    <?= Html::img('/'.$person[$img_key][0], ['alt' => $person[$img_key][1], 'title' => $person[$img_key][1]]) ?>
                                    <?php
                                    if($person['winner']):
                                        ?>
                                        <div class="person-winner">
                                            <?=$person['winner_text']?>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </a>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <?php
                        if($i % 2){
                            echo '<div style="clear: both"></div>';
                        }
                        $i++;

                    }
                }
                ?>
            </div>

        </div>

        <hr>
    </section>
</div>
