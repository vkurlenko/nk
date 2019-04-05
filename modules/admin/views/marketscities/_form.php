<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MarketsCities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markets-cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid group">

        <div class="row">

            <div class="col-md-6 ">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

                <?/*= $form->field($model, 'is_region')->checkbox([1, 0]); */?>

                <?= $form->field($model, 'url_alias')->textInput(['maxlength' => true]) ?>

                <?/*= $form->field($model, 'sort')->textInput() */?>

                <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
                <?= $form->field($model, 'first')->checkbox([0, 1]); ?>
            </div>

            <div class="col-md-6 ">
                <?= $form->field($model, 'coords')->textInput() ?>
                <?= $form->field($model, 'scale')->textInput() ?>
            </div>
        </div>
    </div>

    <div id="ya-map">

        <?php
        $points = \app\controllers\WhereController::getMarkets($model->url_alias);
        //debug($points);
        ?>

        <script src="https://api-maps.yandex.ru/2.1/?apikey=92ef1e5f-a416-44d2-8586-4b72c927d350&lang=ru_RU" type="text/javascript">
        </script>

        <div id="map" style="height: 580px"></div>

        <script type="text/javascript">


            ymaps.ready(init);

            function setPoint(myMap){
                removePoint(myMap)

                var center = myMap.getCenter();
                var new_center = [center[0].toFixed(4), center[1].toFixed(4)];

                var myPlacemark = new ymaps.Placemark(new_center, {}, {
                    draggable: true, // Метку можно перемещать.
                });

                myMap.geoObjects.add(myPlacemark);

                setDraged(myPlacemark)

                $('#marketscities-coords').val(center)
            }

            function setDraged(myPlacemark){
                myPlacemark.events.add('dragend', function(e) {
                    // Получение ссылки на объект, который был передвинут.
                    var thisPlacemark = e.get('target');
                    // Определение координат метки
                    var coords = thisPlacemark.geometry.getCoordinates();

                    $('#marketscities-coords').val(coords)
                });
            }

            function findPoint(ymaps, myMap, string){
                removePoint(myMap)

                var myGeocoder = ymaps.geocode(string);

                myGeocoder.then(function(res) {

                    var firstGeoObject = res.geoObjects.get(0),
                        coords = firstGeoObject.geometry.getCoordinates(),
                        bounds = firstGeoObject.properties.get('boundedBy');

                    // Масштабируем карту на область видимости геообъекта.
                    myMap.setBounds(bounds, {
                        // Проверяем наличие тайлов на данном масштабе.
                        checkZoomRange: true
                    });

                    var myPlacemark = new ymaps.Placemark(coords, {}, {
                        draggable: true, // Метку можно перемещать.
                    });

                    myMap.geoObjects.add(myPlacemark);

                    $('#marketscities-coords').val(coords);

                    $('#marketscities-scale').val(myMap.getZoom());

                    setDraged(myPlacemark)
                });
            }

            function removePoint(myMap){
                myMap.geoObjects.removeAll();
                $('#marketscities-coords').val('');
            }

            function init(){

                // иконка метки
                var balloon = '<?= \app\controllers\AppController::getOption('ya-map-point');?>';

                // координаты точек этого региона
                var points = [
                    <?php
                    //$coords = $points;
                    foreach($points as $obj)
                        echo '['.$obj['latitude'].'],';
                    ?>
                ];

                <?php
                // координаты центра карты
                if($model->coords)
                    echo 'var coords = ['.$model->coords.'];';
                else
                    echo 'var coords = [55.76, 37.64];';

                // масштаб карты
                if($model->scale){
                    echo 'var z = '.$model->scale.';';
                }
                else
                    echo 'var z = 10;';
                ?>

                var myMap = new ymaps.Map("map", {
                    center: coords,
                    // Уровень масштабирования. Допустимые значения:
                    // от 0 (весь мир) до 19.
                    zoom: z,
                    controls: ['zoomControl']
                }, {}),
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

                    geoObjects = [];

                    for (var i = 0, len = points.length; i < len; i++) {
                        geoObjects[i] = new ymaps.Placemark(points[i], {}, {
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


                //Ослеживаем событие изменения области просмотра карты - масштаб и центр карты

                myMap.events.add('boundschange', function (event) {
                    //if (event.get('newZoom') != event.get('oldZoom')) {
                        //savecoordinats();
                        $('#marketscities-scale').val(myMap.getZoom());
                        $('#marketscities-coords').val(myMap.getCenter());
                    //}

                });
            }
        </script>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
