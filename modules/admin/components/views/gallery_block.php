<?php
use yii\helpers\Url;
use yii\db\ActiveRecord;
use rico\yii2images\models\Image;
?>

<div class="form-gallery">

    <?php
    $gallery = $model->getImages();
    $gallery2 = [];
    $arr = Image::find()->asArray()->where(['itemId' => $model->id])->orderBy(['sort' => SORT_ASC])->all();

    //debug($arr);

    foreach($arr as $row){
        foreach($gallery as $img){
            if($img->id == $row['id']){
                $gallery2[] = $img;
            }
        }
    }

    foreach($gallery2 as $img){
    //foreach($arr as $img){
        $url_delete     = Url::toRoute(['pages/deleteimg', 'page_id' => $model->id, 'img_id' => $img->id]);
        $url_setname    = Url::toRoute(['pages/setnameimg', 'page_id' => $model->id, 'img_id' => $img->id]);
        require 'tpl.php';
    }
    ?>

</div>