<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Markets */
/* @var $form yii\widgets\ActiveForm */

debug($model->name);
?>

<div class="markets-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid group">

        <div class="row">

            <div class="col-md-6 ">

                <?= $form->field($model, 'active')->checkbox([1, 0]); ?>

                <div class="">

                    <?/*= $form->field($model, 'city')->textInput() */?>

                    <?
                    //фомируем список
                    $listdata = \app\modules\admin\models\MarketsCities::find()
                        ->select(['city'])
                        ->orderBy(['sort' => SORT_ASC])
                        //->indexBy('id')
                        ->asArray()
                        ->all();

                    $arr = [];
                    foreach($listdata as $city => $v){
                        $arr[] = $v['city'];
                    }
                    //debug($arr);
                    ?>

                    <?= $form->field($model, 'city')->widget(\yii\jui\AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' => $arr,
                        ],
                    ]) ?>

                     <?= $form->field($model, 'name')->textInput(['style' => 'width:100%']) ?>

                    <?/*= $form->field($model, 'url_alias')->textInput()  */?>

                    <?= $form->field($model, 'short_addr')->textInput(['maxlength' => true, 'style' => 'width:100%'])  ?>

                    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
                </div>
            </div>

            <div class="col-md-6 ">

                <div class="group">
                   <?= $form->field($model, 'latitude')->textInput() ?>

                <?/*= $form->field($model, 'longitude')->textInput() */?>

                <input type="text" id="ya-search">
                <input type="button" id="ya-search-btn" value="Найти по адресу">

                <p></p>

                <input type="button" id="ya-remove" value="Удалить точку">

                <input type="button" id="ya-add" value="Добавить точку">

                <?= $form->field($model, 'scale')->textInput() ?>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid group">

        <div class="row">

            <!--<div class="col-md-3 ">
                
            </div>-->

            <div class="col-md-12 ">
                <div id="ya-map">
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

                            $('#markets-latitude').val(center)
                        }

                        function setDraged(myPlacemark){
                            myPlacemark.events.add('dragend', function(e) {
                                // Получение ссылки на объект, который был передвинут.
                                var thisPlacemark = e.get('target');
                                // Определение координат метки
                                var coords = thisPlacemark.geometry.getCoordinates();

                                $('#markets-latitude').val(coords)
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

                                $('#markets-latitude').val(coords);
                                $('#markets-scale').val(myMap.getZoom());

                                setDraged(myPlacemark)
                            });
                        }

                        function removePoint(myMap){
                            myMap.geoObjects.removeAll();
                            $('#markets-latitude').val('');
                        }

                        function init(){

                            <?php
                            if($model->latitude){
                                echo 'var coords = ['.$model->latitude.'];';
                            }
                            else
                                echo 'var coords = [55.76, 37.64];';

                            if($model->scale){
                                echo 'var z = '.$model->scale.';';
                            }
                            else
                                echo 'var z = 10;';
                            ?>

                            var myMap = new ymaps.Map("map", {
                                center: coords,
                                zoom: z,
                                controls: ['zoomControl']
                            });


                            var myPlacemark = new ymaps.Placemark(coords, {}, {
                                draggable: true, // Метку можно перемещать.
                            });

                            myMap.geoObjects.add(myPlacemark);

                            setDraged(myPlacemark);

                            /* удаление всех меток */
                            $('#ya-remove').click(function(){
                                removePoint(myMap);
                                //myMap.geoObjects.removeAll();
                            })
                            /* удаление всех меток */


                            /* добавить метку в центр области карты */
                            $('#ya-add').click(function(){
                                setPoint(myMap)
                            })
                            /* /добавить метку в центр области карты */


                            /* поиск по адресу */
                            $('#ya-search-btn').click(function()
                            {
                                var string = $('#ya-search').val()

                                if(string){
                                    findPoint(ymaps, myMap, string)
                                }
                            })
                            /* /поиск по адресу */

                            //Ослеживаем событие изменения области просмотра карты - масштаб и центр карты
                            myMap.events.add('boundschange', function (event) {
                                if (event.get('newZoom') != event.get('oldZoom')) {
                                    //savecoordinats();
                                    $('#markets-scale').val(myMap.getZoom());
                                }

                            });
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>








    <?/*= $form->field($model, 'active')->textInput() */?>

   <!-- --><?/*= $form->field($model, 'sort')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
