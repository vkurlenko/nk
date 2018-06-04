/* dropdown menu formatting */
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
function insertYouTubeIframe(obj){
    var src = $(obj).attr('data-src');
    var w = $(obj).width();
    var h = $(obj).height();

    if(src){
        var yt_code = '<iframe width="'+w+'" height="'+h+'" src="https://www.youtube.com/embed/'+src+'?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        var to = $(obj).find('.yt-container');
        $(yt_code).appendTo(to);
        $(obj).find('i').remove()
    }
}



$(document).ready(function(){

    setMarginLeft();

    $(window).on('resize', function(){
        setMarginLeft();
        setYouTubeSize();
    });

    $('.yt-cover').click(function () {
        insertYouTubeIframe($(this))
    });

    $('.yt-container').mouseover(function () {
        $(this).find('i').addClass('over')
    }).mouseout(function(){
        $(this).find('i').removeClass('over')
    });

    $('.slider-main').slick({
        lazyLoad: 'ondemand',
        arrows: true,
        autoplay: false,
        autoplaySpeed: 2000,
        nextArrow: '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><img src="/web/tpl/slider_button_next.png" ></a>',
        prevArrow: '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><img src="/web/tpl/slider_button_prev.png" ></a>'
    });


});