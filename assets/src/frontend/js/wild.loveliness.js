$(document).ready(function () {

    /***************** Navbar-Collapse && Navbar-Hide ******************/
    $(window).scroll(function () {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }

    });

    /***************** Page Scroll ******************/
    $(function () {
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });

    /***************** Scroll Spy ******************/
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    })

    /***************** Owl Carousel ******************/

    $("#owl-hero").owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        lazyLoad: true,
        autoplay: true,
        autoplayTimeout: 5000,
        //video: true,
        //autoplayHoverPause: true,
        animateOut: 'zoomFadeOut',
        animateIn: 'zoomFadeIn'
    });






/***************** Characteristics owl Carousel ******************/

    var charOwl = $("#owl-characteristics").owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        //navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dotsContainer: '#characteristics-carousel-custom-dots',
        lazyLoad: true,
        autoplay: true,
        autoplayTimeout: 10000,
        animateOut: 'zoomOutLeft',
        animateIn: 'zoomInRight',
        onChanged: centerActiveDot
    });


    $('#characteristics-carousel-custom-dots .owl-dot').click(function () {
      charOwl.trigger('to.owl.carousel', [$(this).index(), 300]);
    });

    function centerActiveDot(){
        var viewportCenter = $("body").innerWidth()/2;
        var activeDot = $('#characteristics-carousel-custom-dots .active');
        


        $('#characteristics-carousel-custom-dots').width($('#characteristics-carousel-custom-dots li').length * 80)

        $('#characteristics-carousel-custom-dots').animate({


                marginLeft: viewportCenter - (activeDot.attr('data-count') * 100 ) + 125 + 'px'
            

            }, 500, function() {
            // Animation complete.
            });
        
        console.log();
        
        
    }


    



    /***************** Full Width Slide ******************/
    var slideHeight = $(window).height();

    $('#owl-hero .item').css('height', slideHeight);

    $(window).resize(function () {
        $('#owl-hero .item').css('height', slideHeight);
    });
    /***************** Owl Carousel Testimonials ******************/

    $("#owl-testi").owlCarousel({

        navigation: false, // Show next and prev buttons
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "backSlide",
        autoPlay: true

    });

    /***************** Countdown ******************/
    $('#fun-facts').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                var $this = $(this);
                $({
                    Counter: 0
                }).animate({
                    Counter: $this.text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).unbind('inview');
        }
    });

    /***************** Wow.js ******************/
    
    new WOW().init();
    
    /***************** Preloader ******************/
    var preloader = $('.preloader');
    $(window).on('load', function() {
        preloader.fadeOut(500, function(){preloader.remove()});
    });

})