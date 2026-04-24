@extends('layout.WebLayout')

@php
    // Ambil banner pertama untuk preload LCP
    $firstBanner = $banners->first();
    $firstExt = $firstBanner ? strtolower(pathinfo($firstBanner->image_url, PATHINFO_EXTENSION)) : null;
    $firstIsVideo = $firstExt && in_array($firstExt, ['mp4', 'webm', 'ogg']);
    $firstImageUrl = ($firstBanner && !$firstIsVideo && !empty($firstBanner->image_url))
        ? asset('storage/banner_picture/' . $firstBanner->image_url)
        : null;
@endphp

@if($firstImageUrl)
@section('preload_lcp')
    <link rel="preload" as="image" href="{{ $firstImageUrl }}" fetchpriority="high">
@endsection
@endif

@section('content')

        <!-- CSS KHUSUS UNTUK HERO CAROUSEL & PRODUCT CARD -->
        <style>
            /* =============================================
               PRODUCT CARD — OVERLAY & MOBILE BUTTON
               FIX: konsistensi tampilan desktop vs mobile
            ============================================= */

            /* --- Overlay button (desktop hover) --- */
            .product .thumb {
                position: relative;
                overflow: hidden;
            }

            .product .thumb .overlay-button {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 12px;
                background: linear-gradient(to top, rgba(0,0,0,0.45) 0%, transparent 100%);
                opacity: 0;
                transform: translateY(8px);
                transition: opacity 0.25s ease, transform 0.25s ease;
                z-index: 5;
            }

            .product .thumb:hover .overlay-button {
                opacity: 1;
                transform: translateY(0);
            }

            /* Sembunyikan overlay-button di mobile (touch device) karena hover tidak tersedia */
            @media (max-width: 768px) {
                .product .thumb .overlay-button {
                    display: none !important;
                }
            }

            /* --- Mobile button (di bawah card) --- */
            /* Tampilkan hanya di mobile */
            .product .mobile-view {
                display: none;
            }

            @media (max-width: 768px) {
                .product .mobile-view {
                    display: flex;
                    justify-content: center;
                    margin-top: 8px;
                }

                /* Tombol mobile: full-width, konsisten */
                .product .mobile-view .add-cart {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
                    font-size: 13px;
                    padding: 8px 12px;
                    border-radius: 4px;
                    white-space: nowrap;
                }

                .product .mobile-view .add-cart p {
                    margin: 0;
                    line-height: 1;
                }
            }

            /* Desktop: sembunyikan mobile-view */
            @media (min-width: 769px) {
                .product .mobile-view {
                    display: none !important;
                }

                /* Pastikan overlay button tampil saat hover di desktop */
                .product .thumb .overlay-button {
                    display: flex;
                }
            }

            /* --- Konsistensi ukuran button di overlay (desktop) --- */
            .product .thumb .overlay-button .add-cart {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                padding: 8px 16px;
                border-radius: 4px;
                white-space: nowrap;
            }

            .product .thumb .overlay-button .add-cart p {
                margin: 0;
                line-height: 1;
            }

            /* =============================================
               STAR RATING — FIX: bintang kosong vs penuh
            ============================================= */
            .review-stars .star {
                color: #FFC107; /* kuning — bintang penuh */
            }

            .review-stars .star-empty {
                color: #D1D5DB; /* abu — bintang kosong */
            }
        </style>
        <!-- AKHIR CSS KHUSUS -->

        @include('layout.partials.navbar')

        <!-- ========================================== -->
        <!-- HERO BOOTSTRAP CAROUSEL                    -->
        <!-- Hanya 1 video/gambar aktif sekaligus       -->
        <!-- ========================================== -->
        <style>
            #heroBannerCarousel {
                width: 100%;
                height: calc(100vh - 90px);
                background: #EFE9DA;
            }
            #heroBannerCarousel .carousel-inner,
            #heroBannerCarousel .carousel-item {
                height: 100%;
            }
            #heroBannerCarousel .carousel-item img,
            #heroBannerCarousel .carousel-item video {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            /* Pause video saat slide tidak aktif */
            #heroBannerCarousel .carousel-item video { display: block; }

            @media (max-width: 768px) {
                #heroBannerCarousel { height: 50vh; }
            }
        </style>

        @php
            $pastelColors = ['#e6e6e6', '#ff9c9c', '#fce0a2', '#d4fca4', '#b5d8ff'];
        @endphp

        <div id="heroBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach ($banners as $index => $banner)
                    @php
                        $ext     = strtolower(pathinfo($banner->image_url, PATHINFO_EXTENSION));
                        $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                        $bgColor = $pastelColors[$index % count($pastelColors)];
                        $isFirst = $index === 0;
                    @endphp

                    <div class="carousel-item {{ $isFirst ? 'active' : '' }}"
                         style="background-color: {{ $bgColor }};">

                        @if(!empty($banner->image_url))
                            @if($isVideo)
                                @php
                                    $webmFile = pathinfo($banner->image_url, PATHINFO_FILENAME) . '.webm';
                                    $webmPath = storage_path('app/public/banner_picture/' . $webmFile);
                                    $hasWebm  = file_exists($webmPath);
                                @endphp
                                <video
                                    {{ $isFirst ? 'autoplay' : '' }}
                                    loop muted playsinline
                                    preload="{{ $isFirst ? 'metadata' : 'none' }}">
                                    @if($hasWebm)
                                        <source src="{{ asset('storage/banner_picture/' . $webmFile) }}" type="video/webm">
                                    @endif
                                    <source src="{{ asset('storage/banner_picture/' . $banner->image_url) }}"
                                            type="video/{{ $ext === 'mp4' ? 'mp4' : $ext }}">
                                </video>
                            @else
                                <img
                                    src="{{ asset('storage/banner_picture/' . $banner->image_url) }}"
                                    alt="{{ $banner->title }}"
                                    {{ $isFirst ? 'fetchpriority="high"' : 'loading="lazy"' }}>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>

        </div>

        <script>
        // Pause video saat slide keluar, play saat slide masuk
        (function () {
            var carousel = document.getElementById('heroBannerCarousel');
            if (!carousel) return;

            function getVideo(item) {
                return item ? item.querySelector('video') : null;
            }

            carousel.addEventListener('slide.bs.carousel', function (e) {
                var leaving = getVideo(e.relatedTarget.parentElement.querySelector('.carousel-item.active'));
                if (leaving) { leaving.pause(); }
            });

            carousel.addEventListener('slid.bs.carousel', function (e) {
                var incoming = getVideo(e.relatedTarget);
                if (incoming) {
                    incoming.load();
                    incoming.play().catch(function () {});
                }
            });
        })();
        </script>

        <hr>

        <!-- =============================================
             PROMO SECTION
        ============================================= -->
        <section id="promo">
            <div class="section pt-100px pb-100px">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center" data-aos="fade-up">
                            <div class="section-title mb-0">
                                <h2 class="title">
                                    {{ __('home.hot_deals_title') }}
                                    <i class="fa-solid fa-fire" style="color: #ff7b00;"></i>
                                </h2>
                                <p class="sub-title mb-30px">{{ __('home.hot_deals_sub') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="category-slider swiper-container" data-aos="fade-up">
                        <div class="category-wrapper swiper-wrapper">
                            @foreach ($types as $type)
                                <div class="swiper-slide">
                                    <a href="https://wa.me/{{ $admin_1 }}?text=Halo admin, saya mendapat info promo {{ $type->name }} dari website Ibekami.id, apakah promonya masih tersedia?"
                                       target="_blank"
                                       class="category-inner">
                                        <div class="category-single-item">
                                            <img src="{{ asset('storage/gambar_jenis/' . $type->image_url) }}"
                                                 alt="{{ $type->name }}"
                                                 loading="lazy"
                                                 width="200" height="200">
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

        <!-- =============================================
             PRODUCT TAB AREA
             FIX: nama variable loop ($item), row closing
        ============================================= -->
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
                                <div class="tab-pane fade show active" id="tab-product-new-arrivals">
                                    <div class="row">

                                        {{--
                                            BUG FIX 1: Ganti nama variable loop dari $product menjadi $item
                                            agar tidak menimpa collection $product (nama sama = bug PHP/Laravel).

                                            BUG FIX 2: Pindahkan row-break ke DALAM loop dengan kondisi
                                            yang benar sehingga tidak ada <div class="row"> kosong di akhir.
                                        --}}
                                        @foreach($product as $index => $item)

                                            {{-- Row break setiap 4 item, KECUALI di item pertama --}}
                                            @if($index > 0 && $index % 4 === 0)
                                                    </div>{{-- tutup .row sebelumnya --}}
                                                    <div class="row">
                                            @endif

                                            <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-30px" data-aos="fade-up">
                                                <div class="product">
                                                    <div class="thumb">
                                                        <a href="{{ route('product', $item->product_id) }}" class="image">
                                                            @if(!empty($item->image_url))
                                                                <img src="{{ asset('storage/gambar_produk/' . $item->image_url[0]) }}"
                                                                     alt="{{ $item->name }}"
                                                                     width="400" height="400"
                                                                     @if($index < 4)
                                                                         loading="eager"
                                                                         fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                                                                     @else
                                                                         loading="lazy"
                                                                     @endif />
                                                                <img class="hover-image"
                                                                     src="{{ asset('storage/gambar_produk/' . $item->image_url[0]) }}"
                                                                     alt="{{ $item->name }}"
                                                                     width="400" height="400"
                                                                     loading="lazy"
                                                                     aria-hidden="true" />
                                                            @else
                                                                <img src="{{ asset('images/no-image.png') }}"
                                                                     alt="{{ $item->name }}"
                                                                     width="400" height="400"
                                                                     {{ $index < 4 ? 'loading="eager"' : 'loading="lazy"' }} />
                                                                <img class="hover-image"
                                                                     src="{{ asset('images/no-image.png') }}"
                                                                     alt=""
                                                                     width="400" height="400"
                                                                     loading="lazy"
                                                                     aria-hidden="true" />
                                                            @endif
                                                        </a>

                                                        {{-- Overlay button: hanya tampil di desktop saat hover --}}
                                                        <span class="overlay-button">
                                                            <a href="{{ route('product', $item->product_id) }}">
                                                                <button class="add-cart btn btn-primary btn-hover-primary">
                                                                    <i class="icon-magnifier"></i>
                                                                    <p>{{ __('home.discover_more') }}</p>
                                                                </button>
                                                            </a>
                                                        </span>
                                                    </div>

                                                    <div class="content">
                                                        <h5 class="title">
                                                            <a href="{{ route('product', $item->product_id) }}">{{ $item->name }}</a>
                                                        </h5>
                                                    </div>

                                                    {{-- Mobile button: hanya tampil di mobile, di bawah nama produk --}}
                                                    <span class="mobile-view">
                                                        <a href="{{ route('product', $item->product_id) }}">
                                                            <button class="add-cart btn btn-primary btn-hover-primary">
                                                                <i class="icon-magnifier"></i>
                                                                <p>{{ __('home.discover_more') }}</p>
                                                            </button>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>{{-- akhir .row terakhir --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =============================================
             BANNER SECTION
        ============================================= -->
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
                <div class="row">
                    <div class="col-lg-6 col-12 mb-md-30px mb-lm-30px" data-aos="fade-up" data-aos-delay="200">
                        <a href="https://tk.tokopedia.com/ZS9FJjX9u/" class="banner" target="_blank">
                            <div class="banner-container">
                                <img src="images/banner/tokped-nocapt.jpg"
                                     alt="Tokopedia Banner"
                                     loading="lazy"
                                     width="600" height="300" />
                                <div class="overlay-text-1">
                                    <div class="up">
                                        <h2>PLAQUES &amp; <br> SOUVENIRS</h2>
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
                    <div class="col-lg-6 col-12" data-aos="fade-up" data-aos-delay="400">
                        <a href="https://shopee.co.id/ikhtiar_berkah" class="banner" target="_blank">
                            <div class="banner-container">
                                <img src="images/banner/shope-nocapt.jpg"
                                     alt="Shopee Banner"
                                     loading="lazy"
                                     width="600" height="300" />
                                <div class="overlay-text">
                                    <h2>{!! __('home.free_shipping') !!}</h2>
                                    <h3>{!! __('home.for_all_products') !!}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- =============================================
             TESTIMONY AREA
             FIX: class bintang kosong → star-empty
        ============================================= -->
        <div class="section testimonial-section">
            <h1 class="main-heading">{{ __('home.testimony_title') }}</h1>
            <div class="testimonial-person-slider swiper-container">
                <div class="testimony-wrapper swiper-wrapper">
                    @foreach ($testimonies as $testimony)
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
                                    {{-- Bintang penuh --}}
                                    @for ($i = 0; $i < $testimony->star; $i++)
                                        <span class="star"><i class="fa-solid fa-star"></i></span>
                                    @endfor
                                    {{-- BUG FIX 3: Bintang kosong pakai class berbeda (star-empty)
                                         agar dapat di-style abu-abu, bukan kuning --}}
                                    @for ($i = 0; $i < (5 - $testimony->star); $i++)
                                        <span class="star-empty"><i class="fa-solid fa-star"></i></span>
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

        <!-- =============================================
             SOCIAL MEDIA SECTION
        ============================================= -->
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
                            <a href="https://www.instagram.com/ibekami.id" target="_blank" class="instagram">
                                <video class="w-100" loop muted playsinline preload="none"
                                       data-src="{{ asset('videos/instagram-v2.mp4') }}">
                                </video>
                            </a>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <div class="insta-wrapper">
                            <a href="https://www.tiktok.com/@ibekami.id" target="_blank" class="tiktok">
                                <video class="w-100" loop muted playsinline preload="none"
                                       data-src="{{ asset('videos/tiktok-v2.mp4') }}">
                                </video>
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                (function () {
                    if (!('IntersectionObserver' in window)) {
                        // Fallback: langsung load semua
                        document.querySelectorAll('.insta-wrapper video[data-src]').forEach(function (v) {
                            v.src = v.dataset.src;
                            v.load();
                            v.play().catch(function(){});
                        });
                        return;
                    }
                    var obs = new IntersectionObserver(function (entries, o) {
                        entries.forEach(function (entry) {
                            if (!entry.isIntersecting) return;
                            var v = entry.target;
                            v.src = v.dataset.src;
                            v.load();
                            v.play().catch(function(){});
                            o.unobserve(v);
                        });
                    }, { threshold: 0.25 });

                    document.querySelectorAll('.insta-wrapper video[data-src]').forEach(function (v) {
                        obs.observe(v);
                    });
                })();
                </script>
            </div>
        </div>

        <!-- =============================================
             COMPANY LOGO / PARTNER SECTION
        ============================================= -->
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
                                                <div class="image" style="height:80px;width:80px;">
                                                    <img class="img-fluid"
                                                         style="object-fit:contain;"
                                                         src="{{ asset('storage/gambar_partner/' . $partner->image_url) }}"
                                                         alt="{{ $partner->name ?? '' }}"
                                                         loading="lazy"
                                                         width="80" height="80">
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
                                                <div class="image" style="height:80px;width:80px;">
                                                    <img class="img-fluid"
                                                         style="object-fit:contain;"
                                                         src="{{ asset('storage/gambar_partner/' . $partner->image_url) }}"
                                                         alt="{{ $partner->name ?? '' }}"
                                                         loading="lazy"
                                                         width="80" height="80">
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

@endsection