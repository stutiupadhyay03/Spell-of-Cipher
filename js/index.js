$(document).ready(function() {


    $('.fa-bars').click(function() {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('load scroll', function() {
        $('.fa-bars').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if ($(window).scrollTop() > 30) {
            $('.header').css({ 'background': '#92278f', 'box-shadow': '0 .2rem .5rem rgba(0,0,0,.4)', 'position': 'fixed' });
        } else {
            $('.header').css({ 'background': 'none', 'box-shadow': 'none' });
        }
    });

    $('#open1').click(function() {
        $('#p1').css('transform', 'scale(1)');
    })

    $('#close1').click(function() {
        $('#p1').css('transform', 'scale(0)');
    })

    $('#open2').click(function() {
        $('#p2').css('transform', 'scale(1)');
    })

    $('#close2').click(function() {
        $('#p2').css('transform', 'scale(0)');
    })

    $('#open3').click(function() {
        $('#p3').css('transform', 'scale(1)');
    })

    $('#close3').click(function() {
        $('#p3').css('transform', 'scale(0)');
    })

    $('#open4').click(function() {
        $('#p4').css('transform', 'scale(1)');
    })

    $('#close4').click(function() {
        $('#p4').css('transform', 'scale(0)');
    })

    $('#open5').click(function() {
        $('#p5').css('transform', 'scale(1)');
    })

    $('#close5').click(function() {
        $('#p5').css('transform', 'scale(0)');
    })

    $('#open6').click(function() {
        $('#p6').css('transform', 'scale(1)');
    })

    $('#close6').click(function() {
        $('#p6').css('transform', 'scale(0)');
    })


});