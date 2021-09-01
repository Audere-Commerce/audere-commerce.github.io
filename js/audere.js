var responsiveHeader = {
    onResize: function () {
        $(window).resize(function () {
            responsiveHeader.checkWidth();
        });
    },
    checkWidth: function () {
        if (window.innerWidth >= 1240) {
            responsiveHeader.desktop();
        } else {
            responsiveHeader.mobile();
        }
    },
    desktop: function () {
        $('#main_navigation').appendTo('.page-header .page-main').find('li.button > a').addClass('action primary');
    },
    mobile: function () {
        $('#main_navigation').appendTo('#mobile_sidebar').find('li.button > a').removeClass('action primary');
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

$('#main_navigation a, a.anchor-link, footer ul.navigation a').click(function (e) {
    e.preventDefault();
    $('body').removeClass('mobile-sidebar-visible');
    var target = $(this).attr('href');

    var headerSize;

    if (window.innerWidth >= 1240) {
        headerSize = 90;
    } else if (window.innerWidth >= 768) {
        headerSize = 84;
    } else {
        headerSize = 73;
    }

    changeHashWithoutScrolling(target);

    $('html, body').animate({
        scrollTop: $(target).offset().top - headerSize
    }, 300);
});

function changeHashWithoutScrolling(hash) {
    const id = hash.replace(/^.*#/, '')
    const elem = document.getElementById(id)
    elem.id = `${id}-tmp`
    window.location.hash = hash
    elem.id = id
}