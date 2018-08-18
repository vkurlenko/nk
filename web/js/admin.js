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

function delOneImg(obj, e){
    //alert('delOneImg');
    e.preventDefault();
    if(confirm("Удалить изображение?")){
        var href = $(obj).attr('href');
        var res = false;

       // alert(href);

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

function setCheckbox(obj, e){
    //e.preventDefault();

    var model = $(obj).attr('data-model');
    var field = $(obj).attr('data-attr');
    var id = $(obj).attr('data-id');
    var status = $(obj).is(':checked');

    if(status)
        status = 1;
    else
        status = 0;

    $.ajax({
        type: "POST",
        dataType: "html",
        url: '/admin/'+model+'/set-checkbox?model_name='+model+'&field='+field+'&id='+id+'&status='+status,
        //data: "name="+name
        success: function(res){
            if(res){
                //alert('Сохранено');
                $(obj).addClass('save-success');
            }
            else{
                //alert('Ошибка');
                $(obj).addClass('save-error');
            }

            console.log(res);

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
    //alert('submit');
    $('#w0').submit();
}

/*function parseQueryString(queryString) {
    if (!queryString) {
        return false;
    }

    let queries = queryString.split("&"), params = {}, temp;

    for (let i = 0, l = queries.length; i < l; i++) {
        temp = queries[i].split('=');
        if (temp[1] !== '') {
            params[temp[0]] = temp[1];
        }
    }
    return params;
}*/




$(document).ready(function () {

    $('.del_img').click(function (e) {
        delImg($(this), e);
    });

    $('.del_one_img').click(function (e) {
        delOneImg($(this), e);
        return false;
    });

    /*$('.set_name').click(function (e) {
        setImgName($(this), e);
    });*/

    $('.sort-widget-input').click(function(){
        $(this).select()
    });

    $('.set_sort').click(function (e) {
        setSort($(this), e);
    });

    $('.ajax-checkbox').click(function (e) {
        setCheckbox($(this), e);
    })

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

            $('.set_name').each(function(){
                //alert('click')
                setImgParam($(this), e);
            });

            //$('#w0').submit();
            sbt();
        }
        else
            //$('#w0').submit();
            sbt();

        return false;
    })

    if($('#menu-url').val() == 'new_url') {
        $('.new-url').attr({
            'disabled': false,
            'style': 'display:inline'
        })
    }
    else {
        $('.new-url').attr({
            'disabled': true,
            'style': 'display:none'
        })
    }

    $('#menu-url').on('change', function(e){
        //alert($(this).val());
        if($(this).val() == 'new_url')
            $('.new-url').attr({
                'disabled': false,
                'style': 'display:inline'
            });
        else
            $('.new-url').attr({
                'disabled': true,
                'style': 'display:none'
            });

    })

    $('#person-city').on('change', function (e) {

        var year = '';
        var city = '';

        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

            if(results == null)
                return null;
            else
                return results[1] || 0;
        }

        if(!$.urlParam('year'))
            year = 'all';
        else
            year = $.urlParam('year');

        if($(this).val())
            city = $(this).val();


        window.location.replace(document.location.pathname + '?year='+ year +'&city=' + city);
       /* console.log("document.URL : "+document.URL);
        console.log("document.location.href : "+document.location.href);
        console.log("document.location.origin : "+document.location.origin);
        console.log("document.location.hostname : "+document.location.hostname);
        console.log("document.location.host : "+document.location.host);
        console.log("document.location.pathname : "+document.location.pathname);*/

       // var params = parseQueryString(queryString)

    })

});