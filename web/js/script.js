 /*dropdown menu formatting */
function setMarginLeft(){
   /*
   var win = $(window);
    var cont = $('.container');
    var brand = $('.navbar-brand img');

    var i = new Image();
    i.onload = function(){
        var mleft = (win.width() / 2) - (cont.width() / 2) + brand.width() - 15;

        if(win.width() > 750){
            $('.dropdown-menu > li.first-item').css('margin-left', mleft);
        }
        else
            $('.dropdown-menu > li.first-item').css('margin-left', 0);
    }
    i.src = $(brand).attr('src');
    */

    //var a = $('.navbar-nav li:first');
    var a = $('.navbar-nav li:nth-child(2)');
    var offset = a.offset();
    var win = $(window);

    if(win.width() > 750){
        $('.dropdown-menu > li.first-item').css('margin-left', offset.left + 5);
    }
    else
        $('.dropdown-menu > li.first-item').css('margin-left', 0);
}

/* phone position on main menu */
function setPhonePos()
{
    var a = $('.navbar-collapse');
    var offset = a.offset();    //

    var right = offset.left - 15;
    //alert(right)

    $('#navbar-phone').css({
        'right': right/*,
        'display' : 'block'*/
    }).fadeIn(300);
}


/* youtube IFRAME formatting */
function setYouTubeSize(){
    $('.yt-container').each(function () {
        var w = $(this).width();
        var h = $(this).height();

        $(this).find('iframe').attr({
            'width' : w,
            'height': h
        })
    })
}


/* youtube iframe insert by click */
function insertYouTubeIframe(e, obj){
    var b = $(obj).parents('.video').find('.yt-cover');

    var src = $(b).attr('data-src');
    var source = $(b).attr('data-source');
    var w = $(b).width();
    var h = $(b).height();

    if (src) {
        switch(source){
            case 'rutube' :
                var yt_code = '<iframe width="' + w + '" height="' + h + '" src="//rutube.ru/play/embed/'+src+'?autoStart=true" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
                break;

            default:
                var yt_code = '<iframe width="'+w+'" height="'+h+'" src="https://www.youtube.com/embed/'+src+'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
                break;
        }
        var to = $(b).find('.yt-container');
        to.html(yt_code);
        e.preventDefault();
    }
    
    return false;
}

function viewImg(e, obj){
    var src = $(obj).find('img').attr('src');
    var view = $('.gallery-view').find('img');
    $('.item a').removeClass('selected')
    $(obj).addClass('selected');

    $(view).fadeOut(300, function(){
        $(this).attr('src', src);
        $(this).fadeIn(500);
    })
}

function personNames(){
    $('.face, .product').each(function(){
        if($(this).hasClass('align-left') && $(this).next('div').hasClass('align-right')){

            var obj_left = $(this).find('span');
            var obj_right = $(this).next('div').find('span');

            var h_left = $(obj_left).height();
            var h_right = $(obj_right).height();

            if(h_left > h_right)
                $(obj_right).height(h_left)
            else
                $(obj_left).height(h_right)
        }
    })
}



$(document).ready(function(){

    setPhonePos();

    // left-margin for dropdown submenu

    personNames();



    // on window resize
    $(window).on('resize', function(){
        setPhonePos();
        setMarginLeft();
        setYouTubeSize();
        personNames();
    });

    // youtube start
    $('.yt-start').click(function (e){
        insertYouTubeIframe(e, $(this));       
    });

    // youtube icon
    $('.yt-container').mouseover(function () {
        $(this).find('i').addClass('over')
    }).mouseout(function(){
        $(this).find('i').removeClass('over')
    });



    $('.link img').on('click', function (e) {
        viewImg(e, $(this).parent('.link'));
        return false;
    })

    // slider on main_page

    $('.slider-main').slick({        
        mobileFirst: true,
        speed: 1500,
        arrows: true,
        /*autoplay: false,*/
        nextArrow: '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><img src="/web/tpl/slider_button_next.png" ></a>',
        prevArrow: '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><img src="/web/tpl/slider_button_prev.png" ></a>'
    });
    $('#slider1').fadeIn()

    $('#phone-mask').click(function(){

        var action = $(this).attr('data-action')

        if(action == 'false'){
            $("#franchform-phone, #castingform-phone").inputmask({ mask: "+7 (999) 999-99-99"});
            $(this).removeClass('nomask');
            action = 'true';
        }
        else{
            $("#franchform-phone, #castingform-phone").inputmask('remove');
            $(this).addClass('nomask');
            action = 'false';
        }

        $(this).attr('data-action', action);

        return false;
    })

    setMarginLeft();

    /* список городов */
    $("li.city span").click(function() {
        $(this).next('ul').toggle( "fast", function() {
            if($(this).parent('li').hasClass('open')){
                $(this).parent('li').removeClass('open')
            }
            else
                $(this).parent('li').addClass('open')

        });
    });
    /* /список городов */

    /* выбор города */
    $('.select-city').change(function (e) {
       var city = $(this).val();

        $(location).attr('href', city);

    })
    /* /выбор города */


    //$('.select-city').selectpicker();
    //$('.select-city').styler();



});

