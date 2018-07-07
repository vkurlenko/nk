<?php
use yii\helpers\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!--<div class="user-panel">
            <div class="pull-left image">
                <img src="<?/*= $directoryAsset */?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>-->

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Страницы', 'icon' => 'file-code-o', 'url' => ['/admin/pages']],
                    ['label' => 'Лица проекта', 'icon' => 'user-circle', 'url' => ['/admin/persons']],
                    ['label' => 'Жюри', 'icon' => 'user-circle', 'url' => ['/admin/jury']],

                    ['label' => 'Города', 'icon' => 'hospital-o', 'url' => '#',
                        'items' => [
                            ['label' => 'Города участников', 'icon' => '', 'url' => ['/admin/personcities']],
                            ['label' => 'Города производств', 'icon' => '', 'url' => ['/admin/cities']],
                        ]],

                    ['label' => 'Торговые сети', 'icon' => 'trademark', 'url' => ['/admin/brands']],
                    ['label' => 'Продукция', 'icon' => 'user-circle', 'url' => ['/admin/products']],
                    ['label' => 'Видео', 'icon' => 'file-video-o', 'url' => ['#'],
                        'items' => [
                            ['label' => 'Авторский надзор', 'icon' => '', 'url' => ['/admin/svision?type=svision']],
                            ['label' => 'Видео с участниками', 'icon' => '', 'url' => ['/admin/svision?type=video']],
                        ]
                    ],
                    ['label' => 'Меню', 'icon' => 'user-circle', 'url' => ['/admin/menu'],
                        /*'items' => [
                                ['label' => 'Главное меню', 'icon' => '', 'url' => ['/admin/menu?pid=1']],
                                ['label' => 'Нижнее меню (слева)', 'icon' => '', 'url' => ['/admin/menu?pid=2']],
                                ['label' => 'Нижнее меню (справа)', 'icon' => '', 'url' => ['/admin/menu?pid=3']],
                            ]*/
                    ],
                    ['label' => 'Настройки', 'icon' => 'user-circle', 'url' => ['/admin/options']],

                   // ['label' => 'Где купить', 'icon' => 'file-code-o', 'url' => ['/admin/markets']],
                    //['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Инструменты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            ['label' => 'Шаблоны', 'icon' => 'dashboard', 'url' => ['/admin/tpl'],],
                            //http://127.0.0.1/openserver/phpmyadmin/index.php?db=nk
                            /*[
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],*/
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

   <!-- --><?/*= Html::a(
        'Выйти из системы',
        ['/site/logout'],
        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
    ) */?>

</aside>
