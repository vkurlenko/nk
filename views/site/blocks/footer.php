<?php

$left_menu = \app\controllers\AppController::getOption('foot-menu-1');

?>
<footer>

    <div class="laces"></div>

    <div class="footer-wrap">

    <div class="section-center section-footer  alignment-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-6  align-left footer-menu">
                    <span class="footer-menu-title"><?=\app\controllers\AppController::getOption('foot-menu-1-title')?></span>

                    <?php
                    $arr = \app\controllers\SiteController::getMenu(\app\controllers\AppController::getOption('foot-menu-1'));

                    if($arr):?>
                    <ul class="footer-menu">
                        <?php
                        foreach($arr as $k => $v):
                        ?>
                        <li><a href="<?=$v['url']?>"><?=$v['title']?></a></li>
                        <?
                        endforeach;
                        ?>
                    </ul>
                    <?
                    endif;
                    ?>

                    <!--<span class="footer-menu-title">Информация</span>
                    <ul class="footer-menu">
                        <li><a href="">Правовая информация</a></li>
                        <li><a href="">Условия участия</a></li>
                        <li><a href="">Кастинги</a></li>
                        <li><a href="">Отправить заявку</a></li>
                    </ul>-->

                </div>
                <div class="col-md-4 col-sm-4 col-xs-6  align-left footer-menu">

                    <span class="footer-menu-title"><?=\app\controllers\AppController::getOption('foot-menu-2-title')?></span>

                    <?php
                    $arr = \app\controllers\SiteController::getMenu(\app\controllers\AppController::getOption('foot-menu-2'));

                    if($arr):?>
                        <ul class="footer-menu">
                            <?php
                            foreach($arr as $k => $v):
                                ?>
                                <li><a href="<?=$v['url']?>"><?=$v['title']?></a></li>
                            <?
                            endforeach;
                            ?>
                        </ul>
                    <?
                    endif;
                    ?>
                    <!--<span class="footer-menu-title">Информация</span>
                    <ul class="footer-menu">
                        <li><a href="">Правовая информация</a></li>
                        <li><a href="">Условия участия</a></li>
                        <li><a href="">Кастинги</a></li>
                        <li><a href="">Отправить заявку</a></li>
                    </ul>-->
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 align-left footer-menu footer-menu-social">
                    <!--
                    <ul class="footer-menu social-menu">
                        <li class="social"><a href=""><img src="/tpl/icons/vk.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/fb.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/tw.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/ok.jpg"></a></li>

                        <li class="social" style="clear:both;"><a href=""><img src="/tpl/icons/in.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/go.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/ms.jpg"></a></li>
                        <li class="social"><a href=""><img src="/tpl/icons/yt.jpg"></a></li>
                    </ul>-->
                    <span class="footer-menu-title"><?=\app\controllers\AppController::getOption('foot-menu-3-title')?></span>
                    <?php
                    $arr = \app\controllers\SiteController::getMenu(\app\controllers\AppController::getOption('foot-menu-3'));

                    if($arr):?>
                        <ul class="footer-menu  social-menu">
                            <?php
                            $i = 0;
                            foreach($arr as $k => $v):
                                ?>
                                <li class="social" <?php if($i > 3) {echo 'style="clear:both;"'; $i = 0;}?>>
                                    <a href="<?=$v['url']?>" target="_blank">
                                        <?php
                                        if($v['class'])
                                            echo \yii\helpers\Html::img(\app\controllers\AppController::getOption('icon_'.$v['class']), ['width' => 35]);
                                        ?>
                                    </a>
                                </li>
                            <?
                            $i++;
                            endforeach;
                            ?>
                        </ul>
                    <?
                    endif;
                    ?>

                </div>
            </div>
        </div>
    </div>
    </div>
</footer>

<section id="copyright" class="container section-center">
    <!--Официальный сайт "Народный кондитер". Копирование материалов только с разрешения владельца сайта-->
    <?=\app\controllers\AppController::getOption('copyright')?>
</section>

<hr class="hr-bottom">