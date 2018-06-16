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
                console.log(res);
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

    $.ajax({
        type: "POST",
        dataType: "html",
        url: href+'&name='+name+'&sort='+sort,
        //data: "name="+name
        success: function(res){
            if(res)
                alert('Сохранено');
            else
                alert('Ошибка');
        }
    });

   // alert(href+'&name='+name);

}



$(document).ready(function () {

    $('.del_img').click(function (e) {
        delImg($(this), e);
    });

    $('.set_name').click(function (e) {
        setImgName($(this), e);
    });
})