<?php
//debug($data);
?>
<?php
if($title)
{
    echo $title;
}
?>

<label class="textinput">
    <input type="text" class="<?=$class_name?>" data-model="<?=$model_name?>" data-id="<?=$data->id?>" data-attr="<?=$attr?>" value="<?=$data->value?>">
    <!--<button class="ajax-textinput">Сохранить</button>-->
</label>
