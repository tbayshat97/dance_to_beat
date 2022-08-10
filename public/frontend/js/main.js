$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 50) {
        //clearHeader, not clearheader - caps H
        $("#sticky-header").addClass("sticky");
    }
    else {
        $("#sticky-header").removeClass("sticky");
    }
}); //missing );

// Categories Carousel
$(document).ready(function(){
    $('.owl-carousel.categories').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:8
            }
        }
    })

    $('.testimonials').owlCarousel({
        margin:20,
        nav: false,
        dots: false,
        items:1,
        autoplay: true,
        loop: true,
        onInitialized  : counter, //When the plugin has initialized.
        onTranslated : counter //When the translation of the stage has finished.
    });
    function counter(event) {
        var element   = event.target;         // DOM element, in this example .owl-carousel
         var items     = event.item.count;     // Number of items
         var item      = event.item.index + 1;     // Position of the current item
       
       // it loop is true then reset counter from 1
       if(item > items) {
         item = item - items
       }
       $('#counter').html("<span>" +item+ "</span>" +" / "+items)
     }
    $('.offers').owlCarousel({
        stagePadding: 20,
        margin:30,
        nav: true,
        dots: false,
        items:6,
        loop: true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive : {
            // breakpoint from 0 up
            0 : {
                items: 2,
                nav: false,
                dots: true,
            },
            // breakpoint from 480 up
            480 : {
                items: 2,
                nav: false,
                dots: true,
            },
            // breakpoint from 768 up
            768 : {
                items: 6,
                nav: true,
                dots: true,
            }
        }
    });
});


    // product Gallery and Zoom

    // activation carousel plugin
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 5,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        breakpoints: {
            0: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
        }
    });
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        },
    });
    // change carousel item height
    // gallery-top
    let productCarouselTopWidth = $('.gallery-top').outerWidth();
    $('.gallery-top').css('height', productCarouselTopWidth);

    // gallery-thumbs
    let productCarouselThumbsItemWith = $('.gallery-thumbs .swiper-slide').outerWidth();
    $('.gallery-thumbs').css('height', productCarouselThumbsItemWith);

    // activation zoom plugin
    var $easyzoom = $('.easyzoom').easyZoom();

    // Back To Top Button
    var btn = $('#backtotop');

    $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
    });

    btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
    });



    $(document).ready(function($) {
        // Declare the body variable
        var $body = $("body");
    
        // Function that shows and hides the sidebar cart
        $(".cart-button, .close-button, #sidebar-cart-curtain").click(function(e) {
            e.preventDefault();
            
            // Add the show-sidebar-cart class to the body tag
            $body.toggleClass("show-sidebar-cart");
    
            // Check if the sidebar curtain is visible
            if ($("#sidebar-cart-curtain").is(":visible")) {
                // Hide the curtain
                $("#sidebar-cart-curtain").fadeOut(500);
            } else {
                // Show the curtain
                $("#sidebar-cart-curtain").fadeIn(500);
            }
        });
        
        // Function that adds or subtracts quantity when a 
        // plus or minus button is clicked
        $body.on('click', '.plus-button, .minus-button', function () {
            // Get quanitity input values
            var qty = $(this).closest('.qty').find('.qty-input');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));
    
            // Check which button is clicked
            if ($(this).is('.plus-button')) {
                // Increase the value
                qty.val(val + step);
            } else {
                // Check if minimum button is clicked and that value is 
                // >= to the minimum required
                if (min && min >= val) {
                    // Do nothing because value is the minimum required
                    qty.val(min);
                } else if (val > 0) {
                    // Subtract the value
                    qty.val(val - step);
                }
            }
        });
        //Search Form
        $(function() { 
            $(".search-modal").click(function() {
                $("#search").addClass("show");
            });
            $("#close-search").click(function() {
                $("#search").removeClass("show");
            });
        });
    });