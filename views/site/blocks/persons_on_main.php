<?php
use yii\helpers\Html;
use yii\helpers\Url;

$page = \app\controllers\SiteController::getPageDataByUrl('persons');
//debug($page); die;

?>
<section id="project-faces" class="section-center alignment-block">
    <h2>Лица проекта</h2>
    <!--<h2 style="font-family:'HelveticaNeueCyrThin'">Лица проекта</h2>-->

    <!--<p>Знакомьтесь с участниками конкурса на лучший народный торт.</p>-->
    <div class="content">
        <?= $page['anons']?>
    </div>

    <a href="<?= Url::to(['/persons/'])?>">Все участники проекта &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <?php
            $i = 0;
            $img_key = 'photo_on_main';
            foreach($persons_on_main as $person):?>
                <div class="col-sm-6 col-xs-6 face <?= $i % 2 ? 'align-right':'align-left';  ?>">
                    <span><?=$person['name']?></span>
                    <a href="<?=Url::to(['person/'.$person['id']])?>">
                        <?=Html::img($person[$img_key][0], ['alt' => $person[$img_key][1], 'title' => $person[$img_key][1]])?>
                    </a>
                </div>
                <?php
                $i++;
            endforeach;
            ?>

        </div>

    </div>

    <hr>
</section>