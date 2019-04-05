<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

//debug($img);

$this->title = $page_data['title'];;
$this->registerMetaTag(['name' => 'description', 'content' => $page_data['dscr']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page_data['kwd']]);
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container main where">
    <div class="container">

            <?php
            if(\app\controllers\AppController::getOption('where-title-show')){
                echo '<section class="section-center"><h1>'.Html::encode($page_data['h1']).'</h1></section>';
            }
            ?>

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
        //$html .= '<option value="all">Выберите регион</option>';
		
        foreach($cities as $city){

            if(Yii::$app->request->get('city') && Yii::$app->request->get('city') == $city['url_alias']){
                $selected = ' selected ';
                $city_coords = $city['coords'];
                $city_zoom = $city['scale'];
            }
            else
                $selected = '';

            //$html .= '<option value="'.$city['url_alias'].'" '.$selected.'>'.$city['city'].'</option>';
            $html .= '<option value="/'.$page_data['url'].'/'.$city['url_alias'].'" '.$selected.'>'.$city['city'].'</option>';
        }
		
		if(\app\controllers\AppController::getOption('marketcities-show-all')){

            if(Yii::$app->request->get('city') && Yii::$app->request->get('city') == 'all')
                $selected = ' selected ';
            else
                $selected = '';

			$html .= '<option value="/'.$page_data['url'].'/all" '.$selected.'>Все</option>';
		}
			
        $html .= '</select>';

        echo $html;
    }
    ?>
</div>

<?php
$coords = $points;

//debug($coords);
?>

<script src="https://api-maps.yandex.ru/2.1/?apikey=92ef1e5f-a416-44d2-8586-4b72c927d350&lang=ru_RU" type="text/javascript"></script>

<div id="map" style="height: 580px"></div>

<script  type="text/javascript">

    ymaps.ready(function () {

        // иконка метки
        var balloon_pic = '<?= \app\controllers\AppController::getOption('ya-map-point');?>';

        // координаты точек
        var coords = [
            <?php
            $coords = $points;

            foreach($coords as $obj){
                echo '['.$obj['latitude'].'],';
            }
            ?>
        ];

        var zoom_global = <?=\app\controllers\AppController::getOption('ya-map-zoom-global');?>;
        var coords_global = [<?=\app\controllers\AppController::getOption('ya-map-coords-global');?>];


        <?php
        // zoom и координаты центра карты, если точка всего одна
       /* if(count($coords) == 1){
            echo 'var z = '.$coords[0]['scale'].';';
            echo 'var ctr = ['.$coords[0]['latitude'].'];';
        }*/

        /*else*/
        // zoom и координаты центра карты, если город только один
        if(!Yii::$app->request->get('city') && count($cities) == 1){
            echo 'var z = '.$cities[0]['scale'].';';
            echo 'var ctr = ['.$cities[0]['coords'].'];';
        }
        // zoom и координаты центра общей карты
        elseif(!Yii::$app->request->get('city') || Yii::$app->request->get('city') == 'all'){
            echo 'var z = zoom_global;';
            echo 'var ctr = coords_global;';
        }
        // zoom и координаты центра карты, если точек несколько
        else{
           /* echo 'var z = '.$city_zoom ? $city_zoom : '9;';
            echo 'var ctr = ['.$city_coords ? $city_coords : '55.751574, 37.573856];';*/
            echo 'var z = '.$city_zoom.';';
            echo 'var ctr = ['.$city_coords.'];';
        }
        ?>

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

        var myMap = new ymaps.Map('map', {
                center: ctr,
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
            geoObject = [];

        for (var i = 0, len = points.length; i < len; i++) {
            geoObject[i] = new ymaps.Placemark(points[i], getPointData(i), {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: balloon_pic, //'/tpl/point.png',
                // Размеры метки.
                iconImageSize: [30, 42],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-5, -38]
            });

            //map.addOverlay(geoObjects[i]);
        }

        clusterer.add(geoObject);
        myMap.geoObjects.add(clusterer);

        <?php
        if(count($coords) > 1){
            ?>
            /*
            // чтобы карта автоматически масштабировалась под показ всех точек
            myMap.setBounds(clusterer.getBounds(), {
                checkZoomRange: true
            });*/
        <?php
        }
        ?>

        $('.market').click(function(e){

            var obj = myMap.geoObjects.get(1);
            //console.log(myMap.geoObjects.get(1));
            myMap.geoObjects.remove(obj);

            var coords = $(this).data('coords');
            var text = $(this).data('text');

            var pt = new ymaps.Placemark(coords, {
                balloonContentBody: text,
                clusterCaption: 'метка '
            }, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: balloon_pic, //'/tpl/point.png',
                // Размеры метки.
                iconImageSize: [30, 42],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-5, -38]
            });

            //console.log(myMap.geoObjects.getLength());

            myMap.geoObjects.add(pt);
            //console.log(myMap.geoObjects.get(0).length);
            pt.balloon.open();

           /* pt.balloon.close(function (e) {
                var obj = myMap.geoObjects.get(1);
                console.log(myMap.geoObjects.get(1));
                myMap.geoObjects.remove(obj);
            });*/


            return false;
        })


    });
</script>


<div class="container">

    <section class="">

        <?php
//debug($markets);
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
				
				if(Yii::$app->request->get('city') && Yii::$app->request->get('city') != $city['url_alias'] && Yii::$app->request->get('city') != 'all')
					continue;

                $html .= '<li class="city '.$class.'" ><span>'.$city['city'].'</span>';

                if($city['markets']){

                    $html .= '<ul>';

                    foreach($city['markets'] as $market){

                        $title = '<strong>'.$market['name'].'</strong><br>';
                        $text = mb_ereg_replace('[\r\n]', '<br />', $market['text']);
                        $text = str_replace('<br /><br />', '<br />', $text);
                        $text = htmlspecialchars($title.$text);

                        $html .= '<li class="market" data-coords="['.$market['latitude'].']" data-text="'.$text.'">'.$market['short_addr'].'</li>';
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

