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
                    ['label' => 'Лица проекта', 'icon' => 'file-code-o', 'url' => ['/admin/persons']],
                    ['label' => 'Города', 'icon' => 'file-code-o', 'url' => ['/admin/cities']],
                    ['label' => 'Торговые сети', 'icon' => 'file-code-o', 'url' => ['/admin/brands']],
                    ['label' => 'Создать видео', 'icon' => 'file-code-o', 'url' => ['/admin/svision/create']],
                    ['label' => 'Авторский надзор', 'icon' => 'file-code-o', 'url' => ['/admin/svision?type=svision']],
                    ['label' => 'Видео с участниками', 'icon' => 'file-code-o', 'url' => ['/admin/svision?type=video']],
                    ['label' => 'Где купить', 'icon' => 'file-code-o', 'url' => ['/admin/markets']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Инструменты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            ['label' => 'Шаблоны', 'icon' => 'dashboard', 'url' => ['/admin/tpl'],],
                            //http://127.0.0.1/openserver/phpmyadmin/index.php?db=nk
                            [
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
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
