<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\components\SortWidget;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use app\modules\admin\models\Options;
use app\modules\admin\components\TextinputWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MarketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Где купить';
$this->params['breadcrumbs'][] = $this->title;


$btn_sort_active = $btn_edit_active = '';

if(Yii::$app->request->get('mode')){
    $mode = Yii::$app->request->get('mode');

    if($mode == 'sort')
        $btn_sort_active = 'btn-primary active';
    else
        $btn_edit_active = 'btn-primary active';
}
else
    $btn_edit_active = 'btn-primary active';
?>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Торговые точки</a></li>
        <li><a href="#tabs-2">Общая карта</a></li>
    </ul>


    <div id="tabs-1">
        <div class="markets-index">

            <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
                <div class="btn-group" role="group" aria-label="...">
                    <p>
                        <?= Html::a('Создать точку', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>

                <!--<div class="btn-group" role="group" aria-label="...">
                    <p>
                        <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                        <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
                    </p>
                </div>-->
            </div>

            <?php
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],

                /*'id',*/
                [
                    'attribute' => 'name',
                    'value' => function($data){
                        return Html::a($data->name, \yii\helpers\Url::to('/admin/markets/update?id='.$data->id));
                    },
                    'format' => 'raw'
                ],
                //'city',
                [
                    'attribute' => 'city',
                    'value' => function($data){
                        $city = $data->city;

                        return Html::a($city, \yii\helpers\Url::to('/admin/markets/update?id='.$data->id));
                    },
                    'format' => 'html'
                ],
                //'is_region',
                'text:ntext',
                //'latitude:ntext',
                //'longitude:ntext',
                //'scale',
                [
                    'attribute' => 'active',
                    'value' => function($data){
                        return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'markets']);
                    },
                    'format' => 'raw'
                ],
                //'sort',

                ['class' => 'yii\grid\ActionColumn'],
            ];

            ?>

            <?php
			$mode = 'sort';
			
            if($mode == 'sort'){

                echo SortableGridView::widget([
                    'dataProvider' => $dataProvider,
                    'sortUrl' => Url::to(['sortItem']),
                    'sortingPromptText' => 'Загрузка ...',
                    'failText' => 'Ошибка сортировки',
                    //'filterModel' => $searchModel,
                    'columns' => $columns,
                ]);
            }
            else
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => $columns,
                ]);
            ?>
        </div>
    </div>
    <div id="tabs-2">
        <script src="https://api-maps.yandex.ru/2.1/?apikey=92ef1e5f-a416-44d2-8586-4b72c927d350&lang=ru_RU" type="text/javascript"></script>

        <?php
        $coords = \app\modules\admin\controllers\MarketsController::getMarkets();
        ?>

        <!-- настройки карты-->
        <div class="option-block">
            <?=\app\modules\admin\components\TextinputWidget::widget(['option_name' => 'ya-map-zoom-global', 'class_name' => 'ya-map-zoom-global'])?>
            <?=\app\modules\admin\components\TextinputWidget::widget(['option_name' => 'ya-map-coords-global', 'class_name' => 'ya-map-coords-global'])?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить карту', ['class' => 'btn btn-success save-options']) ?>
            </div>
        </div>


        <!-- настройки карты-->

        <div id="map" style="height: 580px"></div>

        <script type="text/javascript">

            ymaps.ready(init);

            function init(){
                // иконка метки
                var balloon = '<?= \app\controllers\AppController::getOption('ya-map-point');?>';

                // координаты точек
                var coords = [
                    <?php
                    foreach($coords as $obj){
                        echo '['.$obj['latitude'].'],';
                    }
                    ?>
                ];

                // плашки при клике на метку
                var data = [
                    <?php
                    foreach($coords as $obj){
                        $title = '<strong>'.$obj['name'].'</strong><br>';
                        $text = mb_ereg_replace('[\r\n]', '<br />', $obj['text']);
                        $text = str_replace('<br /><br />', '<br />', $text);

                        echo '[\''.$title.$text.'\'],';
                    }
                    ?>
                ];

                var ctr = [<?php
                    if(\app\controllers\AppController::getOption('ya-map-coords-global'))
                        echo \app\controllers\AppController::getOption('ya-map-coords-global');
                    else
                        echo '55.751574, 37.573856';
                    ?>];

                var z = <?php
                    if(\app\controllers\AppController::getOption('ya-map-zoom-global'))
                        echo \app\controllers\AppController::getOption('ya-map-zoom-global');
                    else
                        echo '9';
                    ?>;

                var myMap = new ymaps.Map('map', {
                        center: ctr, //[55.751574, 37.573856],
                        zoom: z,
                        controls: ['zoomControl']
                    }, {
                        searchControlProvider: 'yandex#search'
                    }),
                    clusterer = new ymaps.Clusterer({
                        // Зададим массив, описывающий иконки кластеров разного размера.
                        /* clusterIcons: [
                             {
                                 href: '/tpl/point.png',
                                 size: [40, 40],
                                 offset: [-20, -20]
                             }],
                         clusterNumbers: [2],
                         clusterIconContentLayout: null*/
                        preset: 'islands#pinkClusterIcons'
                    }),
                    getPointData = function (index) {
                        return {
                            balloonContentBody: data[index][0],
                            clusterCaption: 'метка <strong>' + index + '</strong>'
                        };
                    },
                    points = coords,
                    geoObjects = [];

                for (var i = 0, len = points.length; i < len; i++) {
                    geoObjects[i] = new ymaps.Placemark(points[i], getPointData(i), {
                        // Опции.
                        // Необходимо указать данный тип макета.
                        iconLayout: 'default#image',
                        // Своё изображение иконки метки.
                        iconImageHref: balloon, //'/tpl/point.png',
                        // Размеры метки.
                        iconImageSize: [30, 42],
                        // Смещение левого верхнего угла иконки относительно
                        // её "ножки" (точки привязки).
                        iconImageOffset: [-5, -38]
                    });
                }

                clusterer.add(geoObjects);

                myMap.geoObjects.add(clusterer);
                /*myMap.setBounds(clusterer.getBounds(), {
                    checkZoomRange: true
                });*/

                //Ослеживаем событие изменения области просмотра карты - масштаб и центр карты

                myMap.events.add('boundschange', function (event) {
                    //if (event.get('newZoom') != event.get('oldZoom')) {
                    //savecoordinats();
                    $('.ya-map-zoom-global').val(myMap.getZoom());
                    $('.ya-map-coords-global').val(myMap.getCenter());
                    //}

                });
            }

        </script>
    </div>

</div>





