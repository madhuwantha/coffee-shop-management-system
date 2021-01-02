AOS.init({duration:800,easing:'slide'});(function($){"use strict";$(window).stellar({responsive:true,parallaxBackgrounds:true,parallaxElements:true,horizontalScrolling:false,hideDistantElements:false,scrollProperty:'scroll'});var fullHeight=function(){$('.js-fullheight').css('height',$(window).height());$(window).resize(function(){$('.js-fullheight').css('height',$(window).height());});};fullHeight();var loader=function(){setTimeout(function(){if($('#ftco-loader').length>0){$('#ftco-loader').removeClass('show');}},1);};loader();$.Scrollax();var carousel=function(){$('.home-slider').owlCarousel({loop:true,autoplay:true,margin:0,animateOut:'fadeOut',animateIn:'fadeIn',nav:true,dots:false,autoplayHoverPause:false,items:1,navText:["<span class='ion-ios-arrow-back'></span>","<span class='ion-ios-arrow-forward'></span>"],responsive:{0:{items:1},600:{items:1},1000:{items:1}}});$('.carousel-testimony').owlCarousel({center:true,loop:true,items:1,margin:30,stagePadding:0,nav:false,navText:['<span class="ion-ios-arrow-back">','<span class="ion-ios-arrow-forward">'],responsive:{0:{items:1},600:{items:2},1000:{items:3}}});};carousel();$('nav .dropdown').hover(function(){var $this=$(this);$this.addClass('show');$this.find('> a').attr('aria-expanded',true);$this.find('.dropdown-menu').addClass('show');},function(){var $this=$(this);$this.removeClass('show');$this.find('> a').attr('aria-expanded',false);$this.find('.dropdown-menu').removeClass('show');});$('#dropdown04').on('show.bs.dropdown',function(){console.log('show');});var scrollWindow=function(){$(window).scroll(function(){var $w=$(this),st=$w.scrollTop(),navbar=$('.ftco_navbar'),sd=$('.js-scroll-wrap');if(st>150){if(!navbar.hasClass('scrolled')){navbar.addClass('scrolled');}}
if(st<150){if(navbar.hasClass('scrolled')){navbar.removeClass('scrolled sleep');}}
if(st>350){if(!navbar.hasClass('awake')){navbar.addClass('awake');}
if(sd.length>0){sd.addClass('sleep');}}
if(st<350){if(navbar.hasClass('awake')){navbar.removeClass('awake');navbar.addClass('sleep');}
if(sd.length>0){sd.removeClass('sleep');}}});};scrollWindow();var counter=function(){$('#section-counter').waypoint(function(direction){if(direction==='down'&&!$(this.element).hasClass('ftco-animated')){var comma_separator_number_step=$.animateNumber.numberStepFactories.separator(',')
$('.number').each(function(){var $this=$(this),num=$this.data('number');console.log(num);$this.animateNumber({number:num,numberStep:comma_separator_number_step},7000);});}},{offset:'95%'});}
counter();var contentWayPoint=function(){var i=0;$('.ftco-animate').waypoint(function(direction){if(direction==='down'&&!$(this.element).hasClass('ftco-animated')){i++;$(this.element).addClass('item-animate');setTimeout(function(){$('body .ftco-animate.item-animate').each(function(k){var el=$(this);setTimeout(function(){var effect=el.data('animate-effect');if(effect==='fadeIn'){el.addClass('fadeIn ftco-animated');}else if(effect==='fadeInLeft'){el.addClass('fadeInLeft ftco-animated');}else if(effect==='fadeInRight'){el.addClass('fadeInRight ftco-animated');}else{el.addClass('fadeInUp ftco-animated');}
el.removeClass('item-animate');},k*50,'easeInOutExpo');});},100);}},{offset:'95%'});};contentWayPoint();var OnePageNav=function(){$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click',function(e){e.preventDefault();var hash=this.hash,navToggler=$('.navbar-toggler');$('html, body').animate({scrollTop:$(hash).offset().top},700,'easeInOutExpo',function(){window.location.hash=hash;});if(navToggler.is(':visible')){navToggler.click();}});$('body').on('activate.bs.scrollspy',function(){console.log('nice');})};OnePageNav();$('.image-popup').magnificPopup({type:'image',closeOnContentClick:true,closeBtnInside:false,fixedContentPos:true,mainClass:'mfp-no-margins mfp-with-zoom',gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]},image:{verticalFit:true},zoom:{enabled:true,duration:300}});$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({disableOn:700,type:'iframe',mainClass:'mfp-fade',removalDelay:160,preloader:false,fixedContentPos:false});$('#book_date').datepicker({'format':'m/d/yyyy','autoclose':true});$('#book_time').timepicker();})(jQuery);


/*

(function ($) {
    "use strict";

    /!*==================================================================
    [ Load page ]*!/
    try {
        $(".animsition").animsition({
            inClass: 'fade-in',
            outClass: 'fade-out',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            loading: true,
            loadingParentElement: 'html',
            loadingClass: 'animsition-loading-1',
            loadingInner: '<div class="loader05"></div>',
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: [ 'animation-duration', '-webkit-animation-duration'],
            overlay : false,
            overlayClass : 'animsition-overlay-slide',
            overlayParentElement : 'html',
            transition: function(url){ window.location.href = url; }
        });
    } catch(er) {console.log(er);}


    /!*==================================================================
    [ Back to top ]*!/
    try {
        var windowH = $(window).height()/2;

        $(window).on('scroll',function(){
            if ($(this).scrollTop() > windowH) {
                $("#myBtn").addClass('show-btn-back-to-top');
            } else {
                $("#myBtn").removeClass('show-btn-back-to-top');
            }
        });

        $('#myBtn').on("click", function(){
            $('html, body').animate({scrollTop: 0}, 300);
        });
    } catch(er) {console.log(er);}


    /!*==================================================================
    [ Fixed menu ]*!/
    try {
        var posNav = $('.wrap-main-nav').offset().top;
        var menuDesktop = $('.container-menu-desktop');
        var mainNav = $('.main-nav');
        var lastScrollTop = 0;
        var st = 0;

        $(window).on('scroll',function(){
            fixedHeader();
        });

        $(window).on('resize',function(){
            fixedHeader();
        });

        $(window).on('load',function(){
            fixedHeader();
        });

        var fixedHeader = function() {
            st = $(window).scrollTop();

            if(st > posNav + mainNav.outerHeight()) {
                $(menuDesktop).addClass('fix-menu-desktop');
            }
            else if(st <= posNav) {
                $(menuDesktop).removeClass('fix-menu-desktop');
            }

            if (st > lastScrollTop){
                $(mainNav).removeClass('show-main-nav');
            }
            else {
                $(mainNav).addClass('show-main-nav');
            }

            lastScrollTop = st;
        };

    } catch(er) {console.log(er);}

    /!*==================================================================
    [ Menu mobile ]*!/
    try {
        $('.btn-show-menu-mobile').on('click', function(){
            $(this).toggleClass('is-active');
            $('.menu-mobile').slideToggle();
        });

        var arrowMainMenu = $('.arrow-main-menu-m');

        for(var i=0; i<arrowMainMenu.length; i++){
            $(arrowMainMenu[i]).on('click', function(){
                $(this).parent().find('.sub-menu-m').slideToggle();
                $(this).toggleClass('turn-arrow-main-menu-m');
            })
        }

        $(window).on('resize',function(){
            if($(window).width() >= 992){
                if($('.menu-mobile').css('display') === 'block') {
                    $('.menu-mobile').css('display','none');
                    $('.btn-show-menu-mobile').toggleClass('is-active');
                }

                $('.sub-menu-m').each(function(){
                    if($(this).css('display') === 'block') {
                        $(this).css('display','none');
                        $(arrowMainMenu).removeClass('turn-arrow-main-menu-m');
                    }
                });

            }
        });
    } catch(er) {console.log(er);}


    /!*==================================================================
    [ Respon tab01 ]*!/
    try {
        $('.tab01').each(function(){
            var tab01 = $(this);
            var navTabs = $(this).find('.nav-tabs');
            var dropdownMenu = $(tab01).find('.nav-tabs>.nav-item-more .dropdown-menu');
            var navItem = $(tab01).find('.nav-tabs>.nav-item');

            var navItemSize = [];
            var size = 0;
            var wNavItemMore = 0;

            $(window).on('load', function(){
                navItem.each(function(){
                    size += $(this).width();
                    navItemSize.push(size);
                });

                responTab01();
            });

            $(window).on('resize', function(){
                responTab01();
            })

            var responTab01 = function() {
                if(navTabs.width() <= navItemSize[navItemSize.length - 1] + 1) {
                    $(tab01).find('.nav-tabs>.nav-item-more').removeClass('dis-none');
                }
                else {
                    $(tab01).find('.nav-tabs>.nav-item-more').addClass('dis-none');
                }

                wNavItemMore = $(tab01).find('.nav-tabs>.nav-item-more').hasClass('dis-none')? 0 : $(tab01).find('.nav-tabs>.nav-item-more').width();

                for(var i=0 ; i<navItemSize.length ; i++) {

                    if(navTabs.width() - wNavItemMore <= navItemSize[i] + 1) {
                        $(tab01).find('.nav-tabs .nav-item').remove();

                        for(var j=i-1 ; j >= 0 ; j--) {
                            $(navTabs).prepend($(navItem[j]).clone());
                        }

                        for(var j=i ; j < navItemSize.length ; j++) {
                            $(dropdownMenu).append($(navItem[j]).clone());
                        }

                        break;
                    }
                    else {
                        $(tab01).find('.nav-tabs .nav-item').remove();

                        for(var j=i ; j >= 0 ; j--) {
                            $(navTabs).prepend($(navItem[j]).clone());
                        }
                    }
                }
            };
        });
    } catch(er) {console.log(er);}


    /!*==================================================================
    [ Play video 01 ]*!/
    try {
        var srcOld = $('.video-mo-01').children('iframe').attr('src');

        $('[data-target="#modal-video-01"]').on('click',function(){
            $('.video-mo-01').children('iframe')[0].src += "&autoplay=1";

            setTimeout(function(){
                $('.video-mo-01').css('opacity','1');
            },300);
        });

        $('[data-dismiss="modal"]').on('click',function(){
            $('.video-mo-01').children('iframe')[0].src = srcOld;
            $('.video-mo-01').css('opacity','0');
        });
    } catch(er) {console.log(er);}


    /!*==================================================================
    [ Tab mega menu ]*!/
    try {
        $(window).on('load', function(){
            $('.sub-mega-menu .nav-pills > a').hover(function() {
                $(this).tab('show');
            });
        });
    } catch(er) {console.log(er);}

    /!*==================================================================
    [ Slide100 txt ]*!/

    try {
        $('.slide100-txt').each(function(){
            var slideTxt = $(this);
            var itemSlideTxt = $(this).find('.slide100-txt-item');
            var data = [];
            var count = 0;
            var animIn = $(this).data('in');
            var animOut = $(this).data('out');

            for(var i=0; i<itemSlideTxt.length; i++) {
                data[i] = $(itemSlideTxt[i]).clone();
                $(data[i]).addClass('clone');
            }

            $(window).on('load', function(){
                $(slideTxt).find('.slide100-txt-item').remove();
                $(slideTxt).append($(data[0]).clone());
                $(slideTxt).find('.slide100-txt-item.clone').addClass(animIn + ' visible-true');
                count = 0;
            });

            setInterval(function(){
                $(slideTxt).find('.slide100-txt-item.ab-t-l.' + animOut).remove();
                $(slideTxt).find('.slide100-txt-item').addClass('ab-t-l ' + animOut);


                if(count >= data.length-1) {
                    count = 0;
                }
                else {
                    count++;
                }

                console.log($(data[count]).text());

                $(slideTxt).append($(data[count]).clone());
                $(slideTxt).find('.slide100-txt-item.clone').addClass(animIn + ' visible-true');
            },5000);
        });
    } catch(er) {console.log(er);}


})(jQuery);*/


$(function() {
    $(".img-w").each(function() {
        $(this).wrap("<div class='img-c'></div>")
        let imgSrc = $(this).find("img").attr("src");
        $(this).css('background-image', 'url(' + imgSrc + ')');
    })


    $(".img-c").click(function() {
        let w = $(this).outerWidth()
        let h = $(this).outerHeight()
        let x = $(this).offset().left
        let y = $(this).offset().top


        $(".active").not($(this)).remove()
        let copy = $(this).clone();
        copy.insertAfter($(this)).height(h).width(w).delay(500).addClass("active")
        $(".active").css('top', y - 8);
        $(".active").css('left', x - 8);

        setTimeout(function() {
            copy.addClass("positioned")
        }, 0)

    })




})

$(document).on("click", ".img-c.active", function() {
    let copy = $(this)
    copy.removeClass("positioned active").addClass("postactive")
    setTimeout(function() {
        copy.remove();
    }, 500)
})