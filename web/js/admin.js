function delImg(obj, e){

    e.preventDefault();
    if(confirm("Удалить изображение?")){
        var href = $(obj).attr('href');
        var res = false;

        $.ajax({
            type: "POST",
            dataType: "html",
            url: href,
            //data: "id="+id+"&uid="+uid,
            success: function(res){
                //console.log(res);
                if(res)
                    $(obj).parent('.form-img').remove();
                else
                    alert('Ошибка удаления файла');
            }
        });
    }
}

function setImgName(obj, e){

    e.preventDefault();

    var href = $(obj).attr('href');
    var name = $(obj).parents('.form-img').find('.img-name').val();
    var sort = $(obj).parents('.form-img').find('.img-sort').val();
    var role = $(obj).parents('.form-img').find('.img-role select').val();

    $.ajax({
        type: "POST",
        dataType: "html",
        url: href+'&name='+name+'&sort='+sort+'&role='+role,
        //data: "name="+name
        success: function(res){
            if(res){
                alert('Сохранено');
            }

            else
                alert('Ошибка');
        }
    });
}

function setSort(obj, e){

    e.preventDefault();

    var model = $(obj).attr('data-model');
    var id = $(obj).attr('data-id');
    var sort = $(obj).parents('.sort-widget').find('input').val();
    var href = $(obj).attr('href');


    $.ajax({
        type: "POST",
        dataType: "html",
        url: href+'?id='+id+'&sort='+sort+'&model='+model,
        //data: "name="+name
        success: function(res){
            if(res){
                //alert('Сохранено');
                $(obj).parents('.sort-widget').find('input').addClass('save-success');
            }
            else{
                //alert('Ошибка');
                $(obj).parents('.sort-widget').find('input').addClass('save-error');
            }
        }
    });

}



$(document).ready(function () {

    $('.del_img').click(function (e) {
        delImg($(this), e);
    });

    $('.set_name').click(function (e) {
        setImgName($(this), e);
    });

    $('.sort-widget-input').click(function(){
        $(this).select()
    });

    $('.set_sort').click(function (e) {
        setSort($(this), e);
    });
})