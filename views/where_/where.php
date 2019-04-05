<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

//debug($img);

$this->title = $page_data['title'];;
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container main">
    <div class="container">
        <section class="section-center">
            <h1><?= Html::encode($page_data['h1']) ?></h1>

        </section>
    </div>

    <section class="section-center">


    </section>

</div>


<div class="where-form">
    Показать магазины в городе:

    <?php
    //debug($cities);
    if($cities){
        $html = '<select class="select-city">';
        $html .= '<option value="all">Все</option>';

        foreach($cities as $city){

            if(Yii::$app->request->get('city') && Yii::$app->request->get('city') == $city['url_alias']){
                $selected = ' selected ';
            }
            else
                $selected = '';

            if($city['city'] == 'Москва')
                $city['city'] .= ' и Московская область';

            $html .= '<option value="'.$city['url_alias'].'" '.$selected.'>'.$city['city'].'</option>';
        }

        $html .= '</select>';

        echo $html;
    }
    ?>
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=92ef1e5f-a416-44d2-8586-4b72c927d350&lang=ru_RU" type="text/javascript">
</script>
<?php
$coords = $points;

//debug($coords);
?>

<div id="map" style="height: 580px"></div>

<script  type="text/javascript">

    ymaps.ready(function () {

        var balloon = '<?= \app\controllers\AppController::getOption('ya-map-point');?>';

        var coords = [
            /*[55.75, 37.50],
            [55.75, 37.71],
            [55.70, 37.70]*/
            <?php
            foreach($coords as $obj){
                echo '['.$obj['latitude'].'],';
            }
            ?>
        ];

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

        var myMap = new ymaps.Map('map', {
                center: [55.751574, 37.573856],
                zoom: 9,
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

        myMap.setBounds(clusterer.getBounds(), {
            checkZoomRange: true
        });
    });
</script>


<div class="container main">

    <section class="">
        <?php
        //debug($cities);

        if($markets){
            $html = '<ul class="markets-city-ul">';
            foreach($markets as $index => $city){

                if(Yii::$app->request->get('city') && Yii::$app->request->get('city') == $city['url_alias']){
                    $class = ' open ';
                    $selected = ' selected ';
                }
                else{
                    $class = '  ';
                    $selected = '';
                }


                if($city['city'] == 'Москва')
                    $city['city'] .= ' и Московская область';

                $html .= '<li class="city '.$class.'" ><span>'.$city['city'].'</span>';

                if($city['markets']){

                    $html .= '<ul>';

                    foreach($city['markets'] as $market){
                        $html .= '<li class="market">'.$market['name'].', '.$market['short_addr'].'</li>';
                    }

                    $html .= '</ul>';
                }

                $html .= '</li>';

            }
            $html .= '</ul>';

            echo $html;
        }
        ?>

    </section>

</div>

