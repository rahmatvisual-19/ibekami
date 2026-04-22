@extends('layout.WebLayout')
@section('content')

        <!-- CSS KHUSUS UNTUK HERO CAROUSEL -->
        <style>
            /* Animasi masuk (Jatuh dari atas dengan pantulan / spring bounce) */
            @keyframes dropInPanel {
                0% {
                    transform: translateY(-100vh);
                    opacity: 0;
                }
                70% {
                    transform: translateY(20px);
                    opacity: 1;
                }
                85% {
                    transform: translateY(-10px);
                    opacity: 1;
                }
                100% {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .hero-accordion-carousel {
                width: 100%;
                height: calc(100vh - 90px); /* Disesuaikan agar pas layar tanpa scroll berlebih */
                display: flex;
                flex-direction: row;
                overflow: hidden;
                background-color: #EFE9DA;
                box-sizing: border-box;
            }
            .hero-panel {
                flex: 1 0 0;
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                z-index: 1;
                min-width: 0;
                
                /* Setting awal untuk animasi masuk */
                opacity: 0;
                animation: dropInPanel 0.9s ease-in-out forwards;
            }
            .hero-panel-img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
            }

            /* Tampilan Handphone (Grid 2x2) */
            @media (max-width: 768px) {
                .hero-accordion-carousel {
                    flex-wrap: wrap; /* Mengizinkan elemen membungkus ke baris bawah */
                }
                .hero-panel {
                    flex: 0 0 50%; /* Memaksa lebar 50% (2 kolom) */
                    height: 50%;   /* Memaksa tinggi 50% (2 baris) */
                }
            }
        </style>
        <!-- AKHIR CSS KHUSUS -->

        @include('layout.partials.navbar')

        <!-- ========================================== -->
        <!-- HERO SECTION CAROUSEL (NATIVE LARAVEL / HTML+CSS) -->
        <!-- ========================================== -->
        <div class="hero-accordion-carousel">
            @php
                // Array warna fallback untuk panel
                $pastelColors = ['#e6e6e6', '#ff9c9c', '#fce0a2', '#d4fca4', '#b5d8ff'];
            @endphp
            
            @foreach ($banners as $index => $banner)
                @php
                    $bgColor = $pastelColors[$index % count($pastelColors)];
                    
                    // Mengecek apakah file yang diupload adalah video
                    $ext = strtolower(pathinfo($banner->image_url, PATHINFO_EXTENSION));
                    $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                @endphp
                
                <!-- Menambahkan animation-delay berdasarkan index perulangan -->
                <div class="hero-panel" style="background-color: {{ $bgColor }}; animation-delay: {{ $index * 0.15 }}s;">
                    @if(!empty($banner->image_url))
                        @if($isVideo)
                            <video class="hero-panel-img" autoplay loop muted playsinline>
                                <source src="{{ asset('storage/banner_picture/' . $banner->image_url) }}" type="video/{{ $ext == 'mp4' ? 'mp4' : $ext }}">
                                Browser Anda tidak mendukung video ini.
                            </video>
                        @else
                            <img class="hero-panel-img" src="{{ asset('storage/banner_picture/' . $banner->image_url) }}" alt="{{ $banner->title }}">
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
        <!-- ========================================== -->

        <hr>
        <!-- Promo Start -->
        <section id="promo">
        <div class="section pt-100px pb-100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center" data-aos="fade-up">
                        <div class="section-title mb-0">
                            <h2 class="title">{{ __('home.hot_deals_title') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></h2>
                            <p class="sub-title mb-30px">{{ __('home.hot_deals_sub') }}</p>
                        </div>
                    </div>
                </div>
                <div class="category-slider swiper-container" data-aos="fade-up">
                    <div class="category-wrapper swiper-wrapper">
                        <!-- Single Category -->
                        @foreach ($types as $type)
                            <div class="swiper-slide">
                                <a href="https://wa.me/{{ $admin_1 }}?text=Halo admin, saya mendapat info promo {{ $type->name }} dari website Ibekami.id, apakah promonya masih tersedia?"  target="_blank" class="category-inner ">
                                    <div class="category-single-item">
                                        <img src="{{ asset('storage/gambar_jenis/' . $type->image_url) }}" alt="">
                                        <span class="promo-btn">{{ __('home.ask_details') }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!-- Promo End -->

        <!-- Product tab Area Start -->
        <section id="new-product">
        <div class="section product-tab-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center" data-aos="fade-up">
                        <div class="section-title mb-0">
                            <h2 class="title">{{ __('home.product_title') }}</h2>
                            <p class="sub-title mb-30px">{{ __('home.product_sub') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            <!-- 1st tab start -->
                            <div class="tab-pane fade show active" id="tab-product-new-arrivals">
                                <div class="row">
                                    @foreach($product as $index => $product)
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-30px" data-aos="fade-up">
                                            <div class="product">
                                                <div class="thumb">
                                                    <a href="{{ route('product', $product->product_id) }}" class="image">
                                                        @if(!empty($product->image_url))
                                                            <img src="{{ asset('storage/gambar_produk/' . $product->image_url[0]) }}" alt="{{ $product->name }}" loading="lazy" />
                                                            <img class="hover-image" src="{{ asset('storage/gambar_produk/' . $product->image_url[0]) }}" alt="{{ $product->name }}" loading="lazy" />
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" alt="{{ $product->name }}" loading="lazy" />
                                                            <img class="hover-image" src="{{ asset('images/no-image.png') }}" alt="{{ $product->name }}" />
                                                        @endif

                                                    </a>
                                                    <span class="overlay-button">
                                                    <a href="{{ route('product', $product->product_id) }}">
                                                        <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                                            <i class="icon-magnifier"></i>
                                                            <p>{{ __('home.discover_more') }}</p>
                                                        </button>
                                                    </a>
                                                </span>
                                                </div>
                                                <div class="content">
                                                    <h5 class="title"><a >{{ $product->name }}</a></h5>
                                                </div>
                                                <span class="mobile-view">
                                                    <a href="{{ route('product', $product->product_id) }}">
                                                        <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                                            <i class="icon-magnifier"></i>
                                                            <p>{{ __('home.discover_more') }}</p>
                                                        </button>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        @if(($index + 1) % 4 == 0)
                                            </div>
                                            <div class="row">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!-- Product tab Area End -->
        <!-- Banner Section Start -->
        <div class="section pb-100px pt-100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" data-aos="fade-up">
                        <div class="section-title text-center mb-11">
                            <h2 class="title">{{ __('home.marketplace_title') }}</h2>
                            <p class="sub-title">{{ __('home.marketplace_sub') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Banners Start -->
                <div class="row">
                    <!-- Banner Start -->
                    <div class="col-lg-6 col-12 mb-md-30px mb-lm-30px" data-aos="fade-up" data-aos-delay="200">
                        <a href="#" class="banner">
                            <div class="banner-container">
                                <img src="images/banner/tokped-nocapt.jpg" alt="" />
                                <div class="overlay-text-1">
                                    <div class="up">
                                        <h2>PLAQUES & <br> SOUVENIRS </h2>
                                        <p>ETC.</p>
                                    </div>
                                    <div class="down">
                                        <h4>{!! __('home.shipped_to_you') !!}</h4>
                                        <h3>{{ __('home.free') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Banner End -->

                    <!-- Banner Start -->
                    <div class="col-lg-6 col-12" data-aos="fade-up" data-aos-delay="400">
                        <a href="#" class="banner">
                            <div class="banner-container">
                                <img src="images/banner/shope-nocapt.jpg" alt="Shopee Banner" />
                                <div class="overlay-text">
                                    <h2>{!! __('home.free_shipping') !!}</h2>
                                    <h3>{!! __('home.for_all_products') !!}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Banner End -->
                </div>
                <!-- Banners End -->
            </div>
        </div>
        <!-- Banner Section End -->

        <!-- Testimony Area Start -->
        <div class="section testimonial-section">
            <h1 class="main-heading">{{ __('home.testimony_title') }}</h1>
            {{-- <div class="divider"></div> --}}
            <div class="testimonial-person-slider swiper-container">
                <div class="testimony-wrapper swiper-wrapper">
                    @foreach ($testimonies as $testimony)
                        {{-- Testimonial 1 --}}
                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-avatar">{{ $testimony->initial }}</div>
                                    <div class="author-class">
                                        <div class="review-author">{{ $testimony->name }}</div>
                                        <div class="review-date">{{ $testimony->formattedDate }}</div>
                                    </div>
                                </div>
                                <div class="review-stars">
                                    @for ($i = 0; $i < $testimony->star; $i++)
                                        <span class="star"><i class="fa-solid fa-star"></i></span>
                                    @endfor
                                    @for ($i = 0; $i < (5 - $testimony->star); $i++)
                                        <span class="star"><i class="fa-solid fa-star"></i></span>
                                    @endfor
                                </div>
                                <div class="review-text-container">
                                    <div class="review-text">{{ $testimony->review }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Testimony Area End -->
        <div class="section pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12" data-aos="fade-up">
                <div class="section-title text-center mb-11">
                    <h2 class="title">{{ __('home.social_title') }}</h2>
                    <p class="sub-title">{!! __('home.social_sub') !!}</p>
                </div>
            </div>
        </div>
        <div class="insta-row">
            <div data-aos="fade-up" data-aos-delay="200">
                <div class="insta-wrapper">
                    <a href="https://www.instagram.com/ibekami.id" class="instagram" target="_blank">
                        <video class="w-100" autoplay loop muted playsinline>
                            <source src="videos/instagram.mp4" type="video/mp4">
                            {{ __('home.video_not_supported') }}
                        </video>
                    </a>
                </div>
            </div>
            <div data-aos="fade-up" data-aos-delay="400">
                <div class="insta-wrapper">
                    <a href="https://www.tiktok.com/@ibekami.id" class="tiktok" target="_blank">
                        <video class="w-100" autoplay loop muted playsinline>
                            <source src="videos/tiktok.mp4" type="video/mp4">
                            {{ __('home.video_not_supported') }}
                        </video>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
        <!-- Start Company Logo Section -->
        <div class="company-logo-section pb-100px">
            <div class="company-logo-wrapper" data-aos="fade-up" data-aos-delay="0">
                <div class="container">
                    <div class="row">
                        <div class="section-title text-center mb-11">
                            <h2 class="title">{{ __('home.partner_title') }}</h2>
                        </div>
                        <div class="col-12">
                            <div class="company-logo-slider slider-nav-style-1">
                                <div class="swiper-container company-logo-slider">
                                    <div class="swiper-wrapper">
                                        @foreach ($bumnPartner as $partner)
                                            <div class="company-logo-single-item swiper-slide">
                                                <div class="image" style="height: 80px; width: 80px"><img class="img-fluid"
                                                        style="object: fit-content;"
                                                        src="{{ asset('storage/gambar_partner/' . $partner->image_url) }}" alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="company-logo-slider slider-nav-style-1">
                                <div class="swiper-container company-logo-slider-reverse">
                                    <div class="swiper-wrapper">
                                        @foreach ($orgPartner as $partner)
                                            <div class="company-logo-single-item swiper-slide">
                                                <div class="image" style="height: 80px; width: 80px"><img class="img-fluid"
                                                        style="object: fit-content;" src="{{ asset('storage/gambar_partner/' . $partner->image_url) }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection