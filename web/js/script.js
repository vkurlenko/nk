 /*dropdown menu formatting */
function setMarginLeft(){
    var win = $(window);
    var cont = $('.container');
    var brand = $('.navbar-brand img');
    var mleft = (win.width() / 2) - (cont.width() / 2) + brand.width() - 15;

    if(win.width() > 750){
        $('.dropdown-menu > li.first-item').css('margin-left', mleft);
    }
    else
        $('.dropdown-menu > li.first-item').css('margin-left', 0);
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
    var w = $(b).width();
    var h = $(b).height();
   
    if (src) {
        var yt_code = '<iframe width="'+w+'" height="'+h+'" src="https://www.youtube.com/embed/'+src+'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
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


    //return false;
}



$(document).ready(function(){

    // left-margin for dropdown submenu
    setMarginLeft();

    // on window resize
    $(window).on('resize', function(){
        setMarginLeft();
        setYouTubeSize();
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

    /*$('.gallery-nav .item a').click(function(){
        alert('a');
        //viewImg(e, $(this));

        return false;
    })*/

    $('.link img').on('click', function (e) {
        viewImg(e, $(this).parent('.link'));
        return false;
       //$(this).html('test');
    })

    // slider on main_page
    $('.slider-main').slick({        
        mobileFirst: true,
        speed: 1500,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        nextArrow: '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><img src="/web/tpl/slider_button_next.png" ></a>',
        prevArrow: '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><img src="/web/tpl/slider_button_prev.png" ></a>'
    });



   
});

