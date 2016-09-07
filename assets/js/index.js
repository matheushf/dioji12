$(function () {

    var $item = $('.carousel .item');
    var $wHeight = $(window).height();

    $('.carousel').carousel({
        interval: 6000,
        pause: "false"
    });

    $item.eq(0).addClass('active');
    $item.height($wHeight);
    $item.addClass('full-screen');

    $('.carousel-inner img').each(function () {
        var $src = $(this).attr('src');
        var $color = $(this).attr('data-color');

        $(this).parent().css({
            'background-image' : 'url(' + $src + ')',
            'background-color' : $color
        });

        // console.log($src);
        $(this).remove();
    });

    $('.carousel-inner .carousel-caption').each(function () {
        $(this).addClass('animated fadeInLeft')
    });

    $(window).on('resize', function () {
        $wHeight = $(window).height();
        $item.height($wHeight);
    });
});
