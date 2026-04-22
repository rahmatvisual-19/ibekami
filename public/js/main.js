(function ($) {
    ("use strict");

    /*----------------------------------------
            Bootstrap dropdown               
    -------------------------------------------*/

    // Add slideDown animation to Bootstrap dropdown when expanding.

    $(".dropdown").on("show.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(true, true).slideDown();
    });
    // Add slideUp animation to Bootstrap dropdown when collapsing.
    $(".dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(true, true).slideUp();
    });
    
    $(".whatsapp-order-btn").on("click", function (e) {
        var productId = $(this).data("product-id");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "/product/click",
            method: "POST",
            data: {
                product_id: productId,
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const searchForm = document.getElementById("home-search-form");
        const searchButton = searchForm.querySelector("button");

        // Toggle expanded class on button click
        searchButton.addEventListener("click", function () {
            searchForm.classList.toggle("expanded");
        });

        // Optional: Close the search bar when clicking outside
        document.addEventListener("click", function (event) {
            if (!searchForm.contains(event.target)) {
                searchForm.classList.remove("expanded");
            }
        });
    });

    /*---------------------------
       Menu Fixed On Scroll Active
    ------------------------------ */
    $(window).on("scroll", function (e) {
        var window_top = $(window).scrollTop() + 1;
        if (window_top > 250) {
            $(".sticky-nav").addClass("menu_fixed animated fadeInDown");
        } else {
            $(".sticky-nav").removeClass("menu_fixed animated fadeInDown");
        }
    });

    /*---------------------------
          Nice Select 
       ------------------------------ */

    $("select.shop-sort").niceSelect();

    /*---------------------
        venobox
    --------------------- */
    $(".venobox").venobox();
    /*---------------------

    /*---------------------------
       Commons Variables
    ------------------------------ */
    var $window = $(window),
        $body = $("body");

    /*---------------------------------
        Off Canvas Function
    -----------------------------------*/
    (function () {
        var $offCanvasToggle = $(".offcanvas-toggle"),
            $offCanvas = $(".offcanvas"),
            $offCanvasOverlay = $(".offcanvas-overlay"),
            $mobileMenuToggle = $(".mobile-menu-toggle");
        $offCanvasToggle.on("click", function (e) {
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr("href");
            $body.addClass("offcanvas-open");
            $($target).addClass("offcanvas-open");
            $offCanvasOverlay.fadeIn();
            if ($this.parent().hasClass("mobile-menu-toggle")) {
                $this.addClass("close");
            }
        });
        $(".offcanvas-close, .offcanvas-overlay").on("click", function (e) {
            e.preventDefault();
            $body.removeClass("offcanvas-open");
            $offCanvas.removeClass("offcanvas-open");
            $offCanvasOverlay.fadeOut();
            $mobileMenuToggle.find("a").removeClass("close");
        });
    })();

    /*----------------------------------
        Off Canvas Menu
    -----------------------------------*/
    function mobileOffCanvasMenu() {
        var $offCanvasNav = $(".offcanvas-menu, .overlay-menu"),
            $offCanvasNavSubMenu = $offCanvasNav.find(".sub-menu"),
            $offCanvas = $(".offcanvas"),
            $offCanvasOverlay = $(".offcanvas-overlay");

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu
            .parent()
            .prepend('<span class="menu-expand"></span>');

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on("click", "li a, .menu-expand", function (e) {
            var $this = $(this);
            if ($this.attr("href") === "#" || $this.hasClass("menu-expand")) {
                e.preventDefault();
                if ($this.siblings("ul:visible").length) {
                    $this.parent("li").removeClass("active");
                    $this.siblings("ul").slideUp();
                    $this.parent("li").find("li").removeClass("active");
                    $this.parent("li").find("ul:visible").slideUp();
                } else {
                    $this.parent("li").addClass("active");
                    $this
                        .closest("li")
                        .siblings("li")
                        .removeClass("active")
                        .find("li")
                        .removeClass("active");
                    $this
                        .closest("li")
                        .siblings("li")
                        .find("ul:visible")
                        .slideUp();
                    $this.siblings("ul").slideDown();
                }
            } else {
                e.preventDefault();
                var target = $this.attr("href");
                $body.removeClass("offcanvas-open");
                $offCanvas.removeClass("offcanvas-open");
                $offCanvasOverlay.fadeOut();

                if (target.startsWith("#")) {
                    $("html, body").animate(
                        {
                            scrollTop: $(target).offset().top,
                        },
                        300
                    );
                } else {
                    window.location.href = target;
                }
            }
        });
    }
    mobileOffCanvasMenu();

    /*----------------------------------
     * Offcanvas: User Panel
     ----------------------------------*/
    function mobileOffCanvasUserPanel() {
        var $offCanvasNav = $(".offcanvas-userpanel"),
            $offCanvasNavSubMenu = $offCanvasNav.find(".user-sub-menu");

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu
            .parent()
            .prepend('<span class="offcanvas__user-expand"></span>');

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on(
            "click",
            "li a, .offcanvas__user-expand",
            function (e) {
                var $this = $(this);
                if (
                    $this.attr("href") === "#" ||
                    $this.hasClass("offcanvas__user-expand")
                ) {
                    e.preventDefault();
                    if ($this.siblings("ul:visible").length) {
                        $this.parent("li").removeClass("active");
                        $this.siblings("ul").slideUp();
                        $this.parent("li").find("li").removeClass("active");
                        $this.parent("li").find("ul:visible").slideUp();
                    } else {
                        $this.parent("li").addClass("active");
                        $this
                            .closest("li")
                            .siblings("li")
                            .removeClass("active")
                            .find("li")
                            .removeClass("active");
                        $this
                            .closest("li")
                            .siblings("li")
                            .find("ul:visible")
                            .slideUp();
                        $this.siblings("ul").slideDown();
                    }
                }
            }
        );
    }
    mobileOffCanvasUserPanel();

    /*---------------------
        Hero Slider
     ---------------------- */

    var heroSlider = new Swiper(".hero-slider.swiper-container", {
        loop: true,
        speed: 1000,
        effect: "fade",
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    /*---------------------
        Category Slider
     ---------------------- */

    var categorySlider = new Swiper(".category-slider.swiper-container", {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 40, // Default gap for larger screens
        speed: 1500,
        autoplay: {
            delay: 1000,
            disableOnInteraction: false,
            stopOnLastSlide : false,
        },

        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 10, // Smaller gap for mobile screens
            },
            478: {
                slidesPerView: 2,
                spaceBetween: 10, // Smaller gap for mobile screens
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 15, // Slightly larger gap for slightly larger screens
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20, // Medium gap for tablets
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 25, // Larger gap for smaller desktops
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30, // Default gap for large screens
            },
        },
    });

    /*---------------------
        Blog Slider
     ---------------------- */

    var blogSlider = new Swiper(".blog-slider.swiper-container", {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        speed: 1500,

        // Navigation arrows

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });

    /*---------------------
        New Product Slider
     ---------------------- */

    var productSlider = new Swiper(".new-product-slider.swiper-container", {
        slidesPerView: 4,
        spaceBetween: 30,
        speed: 1500,
        loop: true,

        // Navigation arrows

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            478: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*---------------------------
        Product Details Slider 
    ------------------------------ */
    var zoomThumb = new Swiper(".zoom-thumbs", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var zoomTop = new Swiper(".zoom-top", {
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: zoomThumb,
        },
    });

    /*-------------------------------
      Product Gallery - Image Zoom
     --------------------------------*/


    /*------------------------------
            Single Product Slider
    -----------------------------------*/
    var swiper = new Swiper(".single-product-slider", {
        slidesPerView: 4,
        spaceBetween: 20,
        speed: 1500,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*-----------------------------
        Blog Gallery Slider 
    -------------------------------- */
    var swiper = new Swiper(".blog-post-media", {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    /*********************************************
     *   Company Logo Slider Active - 7 Grid Single Rows
     **********************************************/
    var companyLogoSlider = new Swiper(
        ".company-logo-slider.swiper-container",
        {
            slidesPerView: 6,
            speed: 1500,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                waitForTransition : true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                },
                480: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 6,
                },
            },
        }
    );
    
    var companyLogoSliderReverse = new Swiper(
        ".company-logo-slider-reverse.swiper-container",
        {
            slidesPerView: 6,
            speed: 1500,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                reverseDirection: true,
                waitForTransition : true
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                },
                480: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 6,
                },
            },
        }
    );
    
    
    var testimonySlider = new Swiper(
        ".testimonial-person-slider.swiper-container",
        {
            slidesPerView: 3,
            speed: 1500,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            // Navigation arrows
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 50,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 35,
                },
                992: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
        }
    );
})(jQuery);

