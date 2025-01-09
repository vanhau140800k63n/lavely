'use strict';

(function ($) {
    if($(document).width() < 576) {
        $('.product_card').each(function () {
            var home_main_img = $(this).children('.product_container-img').width();
            var bottom_img = $(this).children('.product_container-label_bottom').height();
            $(this).children('.product_container-img').height(home_main_img);
            $(this).children('.product_container-label_bottom').css('top',home_main_img - bottom_img + 1);
            $(this).children('.ribbon__sale').css('left',home_main_img - 50);
        });
        $('.categories__item').each(function () {
            var widthItem = ($(document).width()-30)/3 - 10;
            // $(this).children('.categories__item-main').height(widthItem);
            $(this).children('.categories__item-img').css('top', widthItem - 0.1734*widthItem + 5);
            $(this).children('p').css('top', widthItem - 0.1734*widthItem + 5);
            if($(document).width() > 400) {
                $(this).children('p').css('left', widthItem - 50);
            }
            else {
                $(this).children('p').css('left', widthItem - 45);
                $(this).children('p').css('font-size', 10);
            }
        });
    }
    $('.card__home').each(function () {
        var width = $('.card__home').width();
        $('.card__home').css('height', width + 5);
    });
    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li:nth-child(1)').addClass('active');
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
            var id = $(this).attr('id');
            $.get("getshop/" + id, function(data) {
                $('.featured__products').html(data);     
            }) 
        });
        // $('.featured__controls div').on('click', function () {
        //     $('.featured__controls li').removeClass('active');
        //     $(this).addClass('active');
        //     var id = $(this).attr('id');
        //     $.get("getshop/" + id, function(data) {
        //         $('.featured__products').html(data);     
        //     }) 
        // });
        /*------------------
            Search filter
        --------------------*/
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 3,
            },

            480: {
                items: 3,
            },

            768: {
                items: 4,
            },

            992: {
                items: 6,
            }
        }
    });
    $(".text__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 7,
            },

            480: {
                items:7,
            },

            768: {
                items: 9,
            },

            992: {
                items: 12,
            }
        }
    });
    $(".img-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 5,
            },

            480: {
                items: 7,
            },

            768: {
                items: 8,
            },

            992: {
                items: 10,
            }
        }
    });
    $(".banner-type2").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 2,
            },

            480: {
                items: 3,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });

    // $('.hero__categories__all').on('click', function(){
    //     $('.hero__categories ul').slideToggle(400);
    // });
    
    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty1 = $('.quantity');
    proQty1.on('click', '.quantity_btn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

})(jQuery);

// search select
const selectBox = document.querySelectorAll(".select-box");
selectBox.forEach(function(item) {
    const selected = item.querySelector(".selected");
    const optionsContainer = item.querySelector(".options-container");
    const searchBox = item.querySelector(".search-box input");
    const optionsList = optionsContainer.querySelectorAll(".option");

    selected.addEventListener("click", () => {
        optionsContainer.classList.toggle("active");
        searchBox.value = "";
        filterList("");
        if (optionsContainer.classList.contains("active")) {
            searchBox.focus();
        }
    });
    optionsList.forEach(o => {
        o.addEventListener("click", () => {
            selected.value = o.querySelector("input").value;
            selected.id = o.querySelector("input").id;
            optionsContainer.html = "";
            optionsContainer.classList.remove("active");
        });
    });

    searchBox.addEventListener("keyup", function(e) {
        filterList(e.target.value);
    });

    const filterList = searchTerm => {
        searchTerm = searchTerm.toLowerCase();
        optionsList.forEach(option => {
            let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
            if (label.indexOf(searchTerm) != -1) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    };
})


// search select END