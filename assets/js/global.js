$(function () {

    $(".mask-telefone").mask("(99) ?9?9999-9999");

    var $item = $('.carousel .item');
    var $wHeight = $(window).height();

    $('.carousel').carousel({
        interval: 8000,
        pause: "false"
    });

    $item.eq(0).addClass('active');
    $item.height($wHeight);
    $item.addClass('full-screen');

    $('.carousel-inner img').each(function () {
        var $src = $(this).attr('src');
        var $color = $(this).attr('data-color');

        $(this).parent().css({
            'background-image': 'url(' + $src + ')',
            'background-color': $color
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


    // Setar a cor do menu selecionado
    var path = window.location.pathname;

    $(".wrapper-navigation").find('li').each(function () {
        // Se for a index
        if (path == '/') {
            $(this).addClass('active');
            return false;
        }

        if ($(this).find('a').attr('href') == path)
            $(this).addClass('active');

    });

    // Elementos visíveis
    declararArea();
    $(window).scroll(function () {
        $.each(area, function (index, value) {
            var data_item = $(area[index]).attr('data-item');
            item = (data_item) ? $('[data-item="' + data_item + '"]') : area;

            var visible = isScrolledIntoView(item[0]);

            if (visible)
                $(area[index]).addClass('animated fadeInLeft');
        });
    });

    $(".btn-enviar").click(function (e) {
        e.preventDefault();

        var dados = $("form").serialize();

        $("#resposta").html('Sua sugestão foi enviada com sucesso.');
        $("#modal_respota").modal();

        $.ajax({
            type: 'POST',
            url: 'acoes.php?acao=salvar_sugestao',
            data: {
                dados: dados
            },
            success: function (data) {}
        });

        document.getElementById('form').reset();
    });

});

function isScrolledIntoView(el) {
    var elemTop = el.getBoundingClientRect().top;
    var elemBottom = el.getBoundingClientRect().bottom;
    var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight || elemTop <= window.innerHeight);

    return isVisible;
}