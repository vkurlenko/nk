<?php
use yii\helpers\Html;
?>

<div class="form-img">

    <a class="btn del_img" title="Удалить?" href="<?=$url_delete?>" data-id="<?=$img->id?>">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <input type="text" title="Порядковый номер" placeholder="Порядковый номер" value="<?=$img->sort?>" class="img-sort" size="5">
    <a class="btn set_name"  title="Сохранить?" href="<?=$url_setname?>" data-id="<?=$img->id?>">
        <span class="glyphicon glyphicon-floppy-disk"></span>
    </a>
    <input type="text" title="Название" placeholder="Название" value="<?=$img->name?>" class="img-name">

    <div class="img-cont">
    <?=Html::img($img->getUrl('x200'));?>
    </div>
</div>
