<?php
use yii\helpers\Html;
?>

<div class="form-img">
    <a class="btn del_img" title="Удалить?" href="<?=$url_delete?>" data-id="<?=$img->id?>">
        <span class="glyphicon glyphicon-remove"></span>
    </a>

    <?php
    if($fields['sort']):?>
    <input type="text" title="Порядковый номер" placeholder="Порядковый номер" value="<?=$img->sort?>" class="img-sort" size="5">
    <?php
    endif;
    ?>


    <a class="btn set_name"  title="Сохранить?" href="<?=$url_setname?>" data-id="<?=$img->id?>">
        <span class="glyphicon glyphicon-floppy-disk"></span>
    </a>
    <input type="text" title="Название" placeholder="Название" value="<?=$img->name?>" class="img-name">

    <div class="img-cont">
    <?=Html::img($img->getUrl('x200'));?>
    </div>

    <div class="img-role">
        <?php
        if($role && count($role) > 1):?>
        <select>
            <option value="">Назначение картинки</option>
        <?php
            foreach($role as $r => $label):?>
                <option value="<?=$r?>" <?= $img->role == $r ? 'selected':''; ?> ><?=$label?></option>
            <?php
            endforeach;
            ?>
        </select>
        <?php
        elseif($role && count($role) == 1):?>
            <?php
            foreach($role as $r => $v):
            ?>
                <input type="text" value="<?=$r;?>">
            <?php
            endforeach;
            ?>
        <?php
        endif;
        ?>
    </div>
</div>
