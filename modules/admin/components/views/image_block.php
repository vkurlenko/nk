<?php
use yii\helpers\Url;

$img = $model->getImage();
$url_delete     = Url::toRoute([$modelName.'/deleteimg', 'page_id' => $model->id, 'img_id' => $img->id]);
$url_setname    = Url::toRoute([$modelName.'/setnameimg', 'page_id' => $model->id, 'img_id' => $img->id]);

require 'tpl.php';
?>
