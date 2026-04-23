<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Souvenir, Merchandise, Digital Printing Medan')</title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Ibekami.id, a Souvenir and Merchandise center in Medan City. Provides Various Custom Souvenirs, Custom Merchandise, Plaques, Offset Prints and UV Prints Get special prices for all orders. Contact 08112272727">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="souvenir medan, tumbler custom medan, plakat wisuda medan, cetak offset, digital printing medan, custom merchandise, souvenir perusahaan, tumbler, tumbler custom, tumbler medan, souvenir, souvenir murah medan, souvenir custom, merchandise, merchandise medan, merchandise custom, akrilik, akrilik cutom, akrilik medan, plakat, plakat medan, plakat acara, plakat seminar, seminar kit, cetak uv flatbed, plakat wisuda, cetak offset, cetak spanduk, percetakan, cetak kartu nama, cetak, cetak flyer, cetak brosur, cetak kalender, cetak poster, cetak stiker" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon/favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('images/favicon/favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/favicon.png') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/favicon.png') }}" />

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "LocalBusiness",
        "name": "ibekami.id",
        "url": "https://ibekami.id",
        "logo": "https://ibekami.id/images/logo/ibeka.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-811-227-2727",
            "contactType": "customer service",
            "areaServed": "Medan, Indonesia"
        },
        "sameAs": [
            "https://www.instagram.com/ibekami.id"
        ]
    }
    </script>

    <!-- Preconnect untuk resource eksternal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Preload LCP image (banner pertama) — diisi dinamis via blade jika tersedia -->
    @yield('preload_lcp')

    <!-- =============================================
         CRITICAL CSS — inline untuk render cepat
         (hanya style yang dibutuhkan layar pertama)
         ============================================= -->
    <style>
        *,*::before,*::after{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{margin:0;padding:0;font-family:'Open Sans',sans-serif;background:#fff;color:#333}
        img{max-width:100%;height:auto;display:block}
        /* Navbar placeholder agar tidak layout shift */
        .navbar-area{position:relative;z-index:999;background:#fff}
        /* Hero accordion */
        .hero-accordion-carousel{width:100%;height:calc(100vh - 90px);display:flex;flex-direction:row;overflow:hidden;background-color:#EFE9DA;box-sizing:border-box}
        .hero-panel{flex:1 0 0;position:relative;overflow:hidden;display:flex;flex-direction:column;z-index:1;min-width:0;opacity:0}
        .hero-panel-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:1}
        @media(max-width:768px){.hero-accordion-carousel{flex-wrap:wrap}.hero-panel{flex:0 0 50%;height:50%}}
        /* Floating WhatsApp */
        .floating-whatsapp{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;align-items:center;justify-content:center}
        /* Prevent CLS pada section */
        section{display:block}
    </style>

    <!-- CSS Inti — blocking (wajib ada sebelum render) -->
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/testimony.css') }}">

    <!-- CSS Plugin — async load (tidak kritis untuk render awal) -->
    <link rel="stylesheet" href="{{ asset('css/vendor/simple-line-icons.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/vendor/ionicons.min.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/plugins/animate.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/plugins/swiper-bundle.min.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui.min.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/plugins/nice-select.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/plugins/venobox.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/vendor/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendor/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/venobox.css') }}">
    </noscript>

    <!-- Font Awesome (async load) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>

    <!-- Google Fonts — async load dengan display=swap -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"></noscript>

    <!-- GTM + GA: Load on Interaction (scroll/click/touch) — TBT Fix -->
    <script>
    (function() {
        var analyticsLoaded = false;
        function loadAnalytics() {
            if (analyticsLoaded) return;
            analyticsLoaded = true;

            // Google Tag Manager
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-WMSK4N53');

            // Google Analytics
            var gaScript = document.createElement('script');
            gaScript.async = true;
            gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-VQG7HT2KD0';
            document.head.appendChild(gaScript);
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            window.gtag = gtag;
            gtag('js', new Date());
            gtag('config', 'G-VQG7HT2KD0');
            gtag('config', 'AW-959548694');
        }
        ['scroll','mousemove','touchstart','keydown','click'].forEach(function(evt) {
            window.addEventListener(evt, loadAnalytics, { once: true, passive: true });
        });
        // Fallback: muat setelah 5 detik jika user tidak interaksi
        setTimeout(loadAnalytics, 5000);
    })();
    </script>
</head>

<body>
            <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WMSK4N53"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <section>
        @yield('content')
    </section>
    
    

    <section id="about">
    <!-- Footer Area Start -->
    <div class="footer-area">
        <div class="footer-container">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 mb-md-30px mb-lm-30px" data-aos="fade-up" data-aos-delay="200">
                            <div class="single-wedge">
                            <h4>{{ __('layout.social_media') }}</h4>
                                <ul class="social-links align-items-center">
                                    <li><a class="ion-social-instagram" href="https://www.instagram.com/ibekami.id" target="_blank"> @ibekami.id</a></li>
                                    <li><i class="fa-brands fa-tiktok"><a href="https://www.tiktok.com/@ibekami.id" target="_blank"> @ibekami.id</i></a></li>
                                    
                                  
                                </ul>
                            </div>
                            <br><br>
                            <div class="single-wedge">
                                <h4 class="footer-herading">{{ __('layout.ask_to_order') }}</h4>

                                <!-- Tombol WhatsApp -->
                                <a href="https://wa.me/{{ $admin_1 }}?text={{ urlencode(__('layout.whatsapp_text')) }}" target="_blank" class="whatsapp-button">
                                    <i class="fab fa-whatsapp"></i> {{ __('layout.ask_now') }}
                                </a>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-sm-6 col-lg-3" data-aos="fade-up"
                            data-aos-delay="400">
                            <div class="single-wedge">
                                <h4 class="footer-herading">{{ __('layout.contacts') }}</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="contact-info align-items-center">
                                            <li>📧 Email: <a href="mailto:ibeka1011@gmail.com" target="_blank">ibeka1011@gmail.com</a></li>
                                            <li><a href="/privacy-policy" style="color: inherit; text-decoration: none;">{{ __('layout.privacy_policy') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <br>
                            <div class="single-wedge">
                                <h4 class="footer-herading">{{ __('layout.operational_hours') }}</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center operational-hours">
                                          <li>{{ __('layout.op_hours_value') }}</li>
                                            <li>{{ __('layout.op_hours_holiday') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-4 col-lg-6 col-sm-6 mb-lm-30px" data-aos="fade-up" data-aos-delay="600">
                            <div class="single-wedge">
                                <h4 class="footer-herading">{{ __('layout.location') }}</h4>
                                <!-- Google Maps — lazy load on click -->
                                <div class="mapouter" style="position: relative; text-align: right; height: 400px; width: 100%;">
                                    <div class="gmap_canvas" style="overflow: hidden; background: #e8e8e8; height: 400px; width: 100%; display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:4px;"
                                        onclick="this.innerHTML='<iframe width=\'100%\' height=\'400\' src=\'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.2642997320017!2d98.63692687455165!3d3.562946096411253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312f8411773ac5%3A0x3a6f109b483f3e2a!2sDigital%20Printing%20Ikhtiar%20Berkah%20Acrylic%20Akrilik%2C%20Plakat%2C%20Tumbler%2C%20dan%20Souvenir%20merchandise%20gimik!5e1!3m2!1sid!2sid!4v1744685839326!5m2!1sid!2sid\' frameborder=\'0\' style=\'border:0;\' allowfullscreen loading=\'lazy\'></iframe>'">
                                        <div style="text-align:center; color:#555;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#A65D3B" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                            <p style="margin:8px 0 0; font-size:13px; font-weight:600;">Klik untuk lihat peta</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- End single blog -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->
    </section>
    <section>
        <div class="copyright-container">
            <div class="copyright">
               <p>&copy; ibekami.id <span id="year"></span></p>
            </div>
        </div>
    </section>
        <script>
          document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    {{-- <script src="{{asset('js/vendor/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
    <script src="{{asset('js/vendor/modernizr-3.11.2.min.js')}}"></script>  --}}

    <!--Plugins JS-->
    {{-- <script src="{{asset('js/plugins/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/plugins/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/plugins/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('js/plugins/countdown.js')}}"></script>
    <script src="{{asset('js/plugins/scrollup.js')}}"></script>
    <script src="{{asset('js/plugins/jquery.waypoints.js')}}"></script>
    <script src="{{asset('js/plugins/jquery.lineProgressbar.js')}}"></script>
    <script src="{{asset('js/plugins/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('js/plugins/venobox.min.js')}}"></script>
    <script src="{{asset('js/plugins/ajax-mail.js')}}"></script> --}}

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="{{ asset('js/vendor/vendor.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins/plugins.min.js') }}" defer></script>

    <!-- Floating WhatsApp Icon -->
    <a href="https://wa.me/{{ $admin_1 }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20produk%20dari%20Ibekami.id.%20Bisa%20bantu%20untuk%20info%20lebih%20lanjut?" class="floating-whatsapp" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp Icon" width="50" height="50">
        <span class="red-dot"></span> <!-- Red dot -->
    </a>
    <!-- Main Js -->
    <script src="{{ asset('js/main.js') }}" defer></script>

</body>

</html>