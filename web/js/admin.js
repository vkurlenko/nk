function delImg(obj, e){

    e.preventDefault();
    if(confirm("Удалить изображение?")){
        var href = $(obj).attr('href');
        var res = false;

        //alert(href);

        $.ajax({
            type: "POST",
            dataType: "html",
            url: href,
            //data: "id="+id+"&uid="+uid,
            success: function(res){
                console.log(res);
                if(res)
                    $(obj).parents('.form-img').remove();
                else
                    alert('Ошибка удаления файла');
            }
        });
    }
}

function setImgParam(obj, e){

    e.preventDefault();

    var href = $(obj).attr('href');
    var name = $(obj).parents('.form-img').find('.img-name').val();
    var sort = $(obj).parents('.form-img').find('.img-sort').val();
    var role = $(obj).parents('.form-img').find('.img-role select').val();
    var url1  = $(obj).parents('.form-img').find('.img-url').val();
    var active  = $(obj).parents('.form-img').find('.img-active').is(":checked");
    //alert(href+'&name='+name+'&sort='+sort+'&role='+role+'&url1='+url1+'&active='+active);

    if(active)
        active = 1;
    else
        active = 0;

    $.ajax({
        type: "POST",
        dataType: "html",
        url: href+'&name='+name+'&sort='+sort+'&role='+role+'&url1='+url1+'&active='+active,
        //data: "name="+name
        success: function(res){
            if(res){
                return true;
            }
            else{
                alert('Ошибка');
                return false;
            }
        }
    });
}
//'app\modules\admin\models\Pages'
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

function massSave(e){

    e.preventDefault();
    var result = true;

    $('.sort-widget').each(function () {
        var sort = $(this).find('input').val();
        var href = $(this).find('a').attr('href');
        var id   = $(this).find('a').attr('data-id');
        var model = $(this).find('a').attr('data-model');

        var obj = $(this);

        $.ajax({
            type: "POST",
            dataType: "html",
            url: href+'?id='+id+'&sort='+sort+'&model='+model,
            success: function(res){
                if(res){
                    $(obj).find('input').addClass('save-success');
                }
                else{
                    $('.mass-save').addClass('save-error');
                    $(obj).find('input').addClass('save-error');
                }
            }
        });
    });

    location.reload();
}

function sbt(){
    alert('submit');
    $('#w0').submit();
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

    $('.mass-save').click(function (e) {
        massSave(e);
        return false;
    });

    $('.form-gallery').sortable( {
        update : function(event, ui) {
            var i = 1;
            $(this).find('.form-img').each(function(){
                $(this).find('.img-sort').attr('value',  i++);
            })
        }
    });

    $('button').click(function (e) {
        if($('.form-gallery').length > 0) {
            //alert('isGallery')
            $('.set_name').each(function(){
                setImgParam($(this), e);
            });
            $('#w0').submit();
        }
        else
            $('#w0').submit();
    })

});