/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
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
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

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
        autoplay: true
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
            minamount.val(formatCurrency(ui.values[0])) ;
            maxamount.val(formatCurrency(ui.values[1])) ;
        }
    });
    minamount.val(formatCurrency(rangeSlider.slider("values", 0)));
    maxamount.val(formatCurrency(rangeSlider.slider("values", 1)));

    /*--------------------------
        Select
    ----------------------------*/
    $("select:not(select.noNice)").niceSelect();

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
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');


    $('.carousel').carousel({
        interval: 2000
    })

    /*-------------------
		Change Password
	--------------------- */
    $('#btnChangePassword').on('click', function (e) {
        e.preventDefault();

        let formData = $('#changePasswordForm').serialize();

        $('#changePasswordForm').find("input.form-control").each(function (index, ele) {
            $(ele).removeClass('is-invalid');
        });

        $.ajax({
            type: 'POST',
            url: '/changePassword',
            data: formData,
            async: false,
            success: function(response) {
                clearInput('#changePasswordForm');
                alert(response.success);
            },
            error: function(response) {
                handleError(response);
            }
        });
    });

    function handleError( response ) {
        console.log(response.responseJSON.errors);
        $.each(response.responseJSON.errors, function(key, value) {
            $('[name="' + key + '"]').addClass('is-invalid');
            $('[name="' + key + '"]').next('.invalid-feedback').text(value);
        });
    }

    function clearInput( form ) {
        $(form).find("input.form-control").each(function (index, ele) {
            $(ele).val('');
        });
    }

    /*-------------------
		Update Information
	--------------------- */

    $('#btnUpdateInfo').on('click', function (e) {
        e.preventDefault();

        let formData = $('#updateInfoForm').serialize();

        $('#updateInfoForm').find("input.form-control").each(function (index, ele) {
            $(ele).removeClass('is-invalid');
        });

        $.ajax({
            type: 'POST',
            url: '/user/updateInfo',
            data: formData,
            async: false,
            success: function(response) {
                alert(response.success);
                
            },
            error: function(response) {
                handleError(response);
            }
        });
    });


    /*-------------------
		Add to cart
	--------------------- */

    $('.btnAddToCart').each( function (index, ele) {
        $(ele).on('click', function(e) {
            e.preventDefault();
            if($(ele).data('user-id') !== -1) {
                let data = {
                    'product_id': $(ele).data('product-id'),
                    'user_id': $(ele).data('user-id'),
                }
                $.ajax({
                    type: 'GET',
                    url: '/user/cart/add',
                    data: data,
                    async: false,
                    success: function(response) {
                        alert(response.success);
                        
                    },
                    error: function(response) {
                        alert(response.responseJSON.error);
                    }
                });
            }else{
                if( true == confirm("Vui lòng đăng nhập để mua hàng!!")) {
                    location.replace('http://127.0.0.1:8000/login');
                }
            }
        });
    } );

    $('.hui_price').each(function(index, ele) {
        let oldValue = $(ele).text();
        $(ele).text(formatCurrency(oldValue));
    });

    

})(jQuery);

function formatCurrency(currency) {
    const VND = new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
    });
    return VND.format(currency);
}