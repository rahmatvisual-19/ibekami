<!DOCTYPE html>
<html lang="en">

<head>
           <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WMSK4N53');</script>
        <!-- End Google Tag Manager -->
        
   <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-959548694"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-959548694');
    </script>
    
        <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VQG7HT2KD0"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-VQG7HT2KD0');
    </script>
    
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Souvenir, Merchandise, Digital Printing Medan')</title>
    <meta name="robots" content="index, follow" />
    <meta name="description"
        content="Ibekami.id, a Souvenir and Merchandise center in Medan City. Provides Various Custom Souvenirs, Custom Merchandise, Plaques, Offset Prints and UV Prints Get special prices for all orders. Contact 08112272727">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords"
        content="souvenir medan, tumbler custom medan, plakat wisuda medan, cetak offset, digital printing medan, custom merchandise, souvenir perusahaan, tumbler, tumbler custom, tumbler medan, souvenir, souvenir murah medan, souvenir custom, merchandise, merchandise medan, merchandise custom, akrilik, akrilik cutom, akrilik medan, plakat, plakat medan, plakat acara, plakat seminar, seminar kit, cetak uv flatbed, plakat wisuda, cetak offset, cetak spanduk, percetakan, cetak kartu nama, cetak, cetak flyer, cetak brosur, cetak kalender, cetak poster, cetak stiker" />
    <!-- Add site Favicon -->
    <link rel="icon" href="{{ asset("images/favicon/favicon.png") }}" sizes="32x32" />
    <link rel="icon" href="{{ asset("images/favicon/favicon.png") }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset("images/favicon/favicon.png") }}" />
    <meta name="msapplication-TileImage" content="{{ asset("images/favicon/favicon.png") }}" />
    <!-- Structured Data  -->
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "LocalBusiness",
            "name": "ibekami.id",
            "url": "ibekami.id"
            "logo": "https://ibekami.id/images/logo/ibeka.png",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+62-811-227-2727",
                "contactType": "customer service",
                "areaServed": "Medan, Indonesia"
             },
          "sameAs": [
            "https://www.instagram.com/ibekami.id",
           
          ]
            
        }
    </script>

    <!-- vendor css (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/ionicons.min.css')}}" />
    
    <!-- plugins css (All Plugins Files) -->
    <link rel="stylesheet" href="{{asset('css/plugins/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/jquery.lineProgressbar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/nice-select.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/venobox.css')}}" /> 
    
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <!-- <link rel="stylesheet" href="css/vendor/vendor.min.css'" />
        <link rel="stylesheet" href="css/plugins/plugins.min.css'" />
        <link rel="stylesheet" href="css/style.min.css'"> -->
    
    {{-- Outside css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aleo:ital,wght@0,100..900;1,100..900&family=Montserrat:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Roboto+Flex:opsz,wght@8..144,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&family=Special+Gothic+Condensed+One&display=swap" rel="stylesheet">
        
    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/testimony.css') }}">   
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
                                <!-- Google Maps Embed -->
                                <div class="mapouter" style="position: relative; text-align: right; height: 400px; width: 100%;">
                                    <div class="gmap_canvas" style="overflow: hidden; background: none!important; height: 400px; width: 100%;">
                                        <iframe width="100%" height="400" id="gmap_canvas" 
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.2642997320017!2d98.63692687455165!3d3.562946096411253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312f8411773ac5%3A0x3a6f109b483f3e2a!2sDigital%20Printing%20Ikhtiar%20Berkah%20Acrylic%20Akrilik%2C%20Plakat%2C%20Tumbler%2C%20dan%20Souvenir%20merchandise%20gimik!5e1!3m2!1sid!2sid!4v1744685839326!5m2!1sid!2sid" 
                                            frameborder="1" scrolling="no" marginheight="0" marginwidth="0" 
                                            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
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
    <script src="{{ asset('js/vendor/vendor.min.js') }}"></script>
    <script src="{{ asset('js/plugins/plugins.min.js') }}"></script>

    <!-- Floating WhatsApp Icon -->
    <a href="https://wa.me/{{ $admin_1 }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20produk%20dari%20Ibekami.id.%20Bisa%20bantu%20untuk%20info%20lebih%20lanjut?" class="floating-whatsapp" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp Icon" width="50" height="50">
        <span class="red-dot"></span> <!-- Red dot -->
    </a>
    <!-- Main Js -->
    <script src="{{asset('js/main.js')}}"></script>

</body>

</html>