var fixedHeader = {
    onScroll: function() {
        $(window).scroll(function() {
            fixedHeader.checkScroll();
        });
    },
    checkScroll: function() {
        if ($(window).scrollTop() > 20) {
            fixedHeader.fixed();
        } else {
            fixedHeader.absolute();
        }
    },
    fixed: function() {
        $('.page-header').addClass('fixed');
    },
    absolute: function() {
        $('.page-header').removeClass('fixed');
    },
    init: function() {
        this.onScroll();
        this.checkScroll();
    }
};

fixedHeader.init();

var responsiveHeader = {
    onResize: function () {
        $(window).resize(function () {
            responsiveHeader.checkWidth();
        });
    },
    checkWidth: function () {
        if (window.innerWidth >= 1024) {
            responsiveHeader.desktop();
        } else {
            responsiveHeader.mobile();
        }
    },
    desktop: function () {
        $('#main_navigation').appendTo('.page-header .page-main');
        $('#main_navigation li.contact > a').addClass('action primary');
    },
    mobile: function () {
        $('#main_navigation').appendTo('#mobile_sidebar');
        $('#main_navigation li.contact > a').removeClass('action primary');
    },
    init: function () {
        this.onResize();
        this.checkWidth();
    }
};

responsiveHeader.init();

$('#menu_icon').click(function() {
    $('body').toggleClass('mobile-sidebar-visible');
});

$('#main_navigation a, a.anchor-link, footer ul.navigation a').click(function (e) {
    e.preventDefault();
    $('body').removeClass('mobile-sidebar-visible');
    var target = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(target).offset().top - 60
    }, 300);
});