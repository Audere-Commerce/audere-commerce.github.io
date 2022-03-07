define(['jquery'], function($) {
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

    let lastScroll = 0;

    var fixedHeader = {
        onScroll: function() {
            $(window).scroll(function() {
                fixedHeader.checkScroll();
            });
        },
        checkScroll: function() {
            const currentScroll = window.pageYOffset;

            if ($(window).scrollTop() > 150) {
                fixedHeader.fixed();

                if (currentScroll > lastScroll) {
                    // down
                    $('.page-header').removeClass('scrolling-up');
                } else if (currentScroll < lastScroll) {
                    // up
                    $('.page-header').addClass('scrolling-up');

                }

                lastScroll = currentScroll;
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

    if ($('body').hasClass('cms-index-index')) {
        fixedHeader.init();

        $('a.anchor-link').click(function (e) {
            e.preventDefault();
            $('body').removeClass('mobile-sidebar-visible');
            var target = $(this).data('target');
            var url = $(this).attr('href');

            changeHashWithoutScrolling(target);

            $('html, body').animate({
                scrollTop: $('#' + target).offset().top
            }, 300);
        });

        function changeHashWithoutScrolling(url) {
            const id = url.replace(/^.*#/, '')
            const elem = document.getElementById(id);
            elem.id = `${id}-tmp`
            window.location.hash = id
            elem.id = id
        }
    }

    $('.modal-window .close').click(function (e) {
        e.preventDefault();
        $(this).parents('.modal-wrapper').removeClass('visible');
        $('body').removeClass('modal-active');
    });
    $('.modal-open').click(function (e) {
        e.preventDefault();
        var target = $(this).data('type');
        $('.modal-wrapper[data-type="' + target + '"]').addClass('visible');
        $('body').addClass('modal-active');
    });
});
