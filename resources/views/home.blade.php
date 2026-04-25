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

        <!-- ========================================== -->
        <!-- CSS KHUSUS HALAMAN HOME                    -->
        <!-- ========================================== -->
        <style>
            /* --- HERO CAROUSEL --- */
            #heroBannerCarousel {
                width: 100%;
                height: calc(100vh - 90px);
                background: #EFE9DA;
                margin-top: 110px; /* offset navbar desktop */
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
            #heroBannerCarousel .carousel-item video { display: block; }

            @media (max-width: 991px) {
                #heroBannerCarousel {
                    height: 50vh;
                    margin-top: 110px; /* offset navbar mobile (80px bar + 30px search) */
                }
            }

            /* --- CATEGORY / PROMO BUTTON FIX --- */
            .category-single-item .promo-btn {
                white-space: normal !important; /* Izinkan teks turun ke baris baru */
                word-wrap: break-word !important; /* Patahkan kata jika kepanjangan */
                word-break: break-word !important;
                overflow: visible !important; /* Tampilkan teks yang meluap ke bawah */
                text-overflow: clip !important; /* Hilangkan elipsis (...) bawaan template */
                height: auto !important; /* Hapus batasan tinggi fix dari template */
                max-height: none !important;
                text-align: center !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                min-height: 44px; /* Tinggi minimum agar konsisten */
                line-height: 1.2 !important;
                padding: 6px 4px !important;
                font-size: 13px !important;
                width: 90% !important; /* Lebar 90% agar ada sela di pinggir */
                left: 5% !important; /* Posisikan ke tengah (jika absolute) */
                box-sizing: border-box;
            }

            /* --- PRODUCT PAGINATION WRAPPER --- */
            .product-pages-wrapper {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                gap: 0;
                /* Sembunyikan scrollbar tapi tetap bisa di-scroll */
                scrollbar-width: none;
                -ms-overflow-style: none;
                padding-bottom: 10px;
            }
            .product-pages-wrapper::-webkit-scrollbar {
                display: none;
            }

            /* --- PRODUCT GRID --- */
            .product-page {
                flex: 0 0 100%;
                scroll-snap-align: start;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 24px; /* Konsisten jarak antar produk */
                padding: 5px;
            }

            /* --- PRODUCT CARD --- */
            .product {
                display: flex;
                flex-direction: column;
                height: 100%;
                width: 100%;
                background: #fff;
            }

            .product .thumb {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                background: #f5f5f5;
                aspect-ratio: 1 / 1; /* gambar selalu kotak simetris */
            }

            .product .thumb .image {
                display: block;
                width: 100%;
                height: 100%;
            }

            .product .thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform 0.3s ease;
            }

            .product .thumb:hover img:first-child {
                transform: scale(1.04);
            }

            /* Overlay button — desktop hover */
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

            /* Nama produk */
            .product .content {
                padding: 12px 4px 4px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .product .content .title {
                font-size: 14px;
                font-weight: 600;
                line-height: 1.4;
                margin: 0;
                white-space: normal;
                overflow: visible;
                display: block;
                text-align: center;
            }

            .product .content .title a {
                color: #333;
                text-decoration: none;
                transition: color 0.2s;
            }

            .product .content .title a:hover {
                color: #ff7b00;
            }

            /* Sembunyikan Mobile button default */
            .product .mobile-view {
                display: none;
            }

            /* --- PAGINATION BUTTONS --- */
            .product-pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 8px;
                margin-top: 32px;
            }

            .product-pagination .page-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: #D1D5DB;
                border: none;
                cursor: pointer;
                padding: 0;
                transition: background 0.2s, transform 0.2s;
            }

            .product-pagination .page-dot.active {
                background: #ff7b00;
                transform: scale(1.3);
            }

            .product-nav-btn {
                background: none;
                border: 2px solid #ff7b00;
                border-radius: 50%;
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: border-color 0.2s, color 0.2s;
                color: #ff7b00;
                flex-shrink: 0;
            }

            .product-nav-btn:hover {
                border-color: #ff7b00;
                color: #ff7b00;
            }

            .product-nav-btn:disabled {
                opacity: 0.35;
                cursor: default;
            }

            /* --- STAR RATING --- */
            .review-stars .star      { color: #FFC107; }
            .review-stars .star-empty { color: #D1D5DB; }

            /* =============================================
               RESPONSIVE — MOBILE (3 Kolom x 4 Baris)
            ============================================= */
            @media (max-width: 768px) {
                /* Perbaikan promo button di mobile */
                .category-single-item .promo-btn {
                    font-size: 11px !important;
                    min-height: 38px !important;
                    padding: 4px !important;
                    width: 94% !important; /* Pakai sedikit lebih luas di mobile */
                    left: 3% !important;
                }

                .product-page {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 10px; /* Jarak rapat agar 3 kolom terlihat bagus */
                }

                #new-product .section {
                    padding-top: 32px;
                    padding-bottom: 32px;
                }

                #new-product .section .container {
                    padding-left: 10px;
                    padding-right: 10px;
                }

                /* Sembunyikan overlay di mobile */
                .product .thumb .overlay-button {
                    display: none !important;
                }

                /* Sembunyikan tombol mobile — cukup gambar + nama */
                .product .mobile-view {
                    display: none !important;
                }

                /* Thumb: gambar kotak penuh */
                .product .thumb {
                    border-radius: 6px;
                }

                /* Nama produk: kecil, center */
                .product .content {
                    padding: 5px 2px 0;
                }

                .product .content .title {
                    font-size: 11px;
                    font-weight: 600;
                    text-align: center;
                    line-height: 1.3;
                    white-space: normal;
                    overflow: visible;
                    display: block;
                    height: auto;
                }
            }

            @media (min-width: 769px) {
                .product .thumb .overlay-button {
                    display: flex;
                }
            }
        </style>
        <!-- AKHIR CSS KHUSUS -->

        @include('layout.partials.navbar')

        @php
            $pastelColors = ['#e6e6e6', '#ff9c9c', '#fce0a2', '#d4fca4', '#b5d8ff'];
        @endphp

        <!-- ========================================== -->
        <!-- HERO BOOTSTRAP CAROUSEL                    -->
        <!-- ========================================== -->
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
                                            <span class="promo-btn">{{ $type->name }}</span>
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
        ============================================= -->
        <style>
            /* Filter Tabs */
            .product-filter-wrap {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                justify-content: center;
                margin-bottom: 28px;
            }

            .product-filter-btn {
                background: none;
                border: 1.5px solid #ddd;
                border-radius: 999px;
                padding: 6px 18px;
                font-size: 13px;
                font-weight: 600;
                color: #555;
                cursor: pointer;
                transition: all 0.2s ease;
                white-space: nowrap;
                font-family: 'Montserrat', sans-serif;
            }

            .product-filter-btn:hover {
                border-color: #ff7b00;
                color: #ff7b00;
            }

            .product-filter-btn.active {
                background: #ff7b00;
                border-color: #ff7b00;
                color: #fff;
            }

            @media (max-width: 767px) {
                .product-filter-wrap {
                    gap: 6px;
                    margin-bottom: 16px;
                }
                .product-filter-btn {
                    font-size: 11px;
                    padding: 5px 12px;
                }
            }
        </style>

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

                    {{-- Filter Tabs --}}
                    <div class="product-filter-wrap" id="productFilterWrap" data-aos="fade-up">
                        <button class="product-filter-btn active" data-category="all">Semua</button>
                        @foreach($homeCategories as $cat)
                            <button class="product-filter-btn" data-category="{{ $cat->id }}">{{ $cat->name }}</button>
                        @endforeach
                    </div>

                    @php
                        $productChunks = $product->chunk(12);
                        $totalPages    = max(1, $productChunks->count());
                    @endphp

                    <div class="product-pages-wrapper" id="productPagesWrapper">
                        @forelse($productChunks as $pageIndex => $chunk)
                            <div class="product-page" id="productPage{{ $pageIndex }}">
                                @foreach($chunk as $item)
                                    @php $globalIndex = $loop->parent->index * 12 + $loop->index; @endphp
                                    
                                    <div class="product" data-aos="fade-up" data-category="{{ $item->category_type }}">
                                        <div class="thumb">
                                            <a href="{{ route('product', $item->product_id) }}" class="image">
                                                @if(!empty($item->image_url))
                                                    <img src="{{ asset('storage/gambar_produk/' . $item->image_url[0]) }}"
                                                         alt="{{ $item->name }}"
                                                         width="400" height="400"
                                                         @if($globalIndex < 4) loading="eager" fetchpriority="{{ $globalIndex === 0 ? 'high' : 'auto' }}"
                                                         @else loading="lazy" @endif />
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
                                                         {{ $globalIndex < 4 ? 'loading="eager"' : 'loading="lazy"' }} />
                                                    <img class="hover-image"
                                                         src="{{ asset('images/no-image.png') }}"
                                                         alt=""
                                                         width="400" height="400"
                                                         loading="lazy"
                                                         aria-hidden="true" />
                                                @endif
                                            </a>

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
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="product-page">
                                <p class="text-center text-muted w-100" style="grid-column: 1 / -1;">Belum ada produk tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination dots + arrow --}}
                    @if($totalPages > 1)
                    <div class="product-pagination" id="productPagination">
                        <button class="product-nav-btn" id="productPrev" aria-label="Previous" disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <div class="dots-container" style="display:flex;align-items:center;gap:8px;">
                            @for($p = 0; $p < $totalPages; $p++)
                                <button class="page-dot {{ $p === 0 ? 'active' : '' }}"
                                        data-page="{{ $p }}"
                                        aria-label="Halaman {{ $p + 1 }}"></button>
                            @endfor
                        </div>

                        <button class="product-nav-btn" id="productNext" aria-label="Next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <script>
                    (function () {
                        var wrapper   = document.getElementById('productPagesWrapper');
                        var dots      = document.querySelectorAll('#productPagination .page-dot');
                        var prevBtn   = document.getElementById('productPrev');
                        var nextBtn   = document.getElementById('productNext');
                        var total     = dots.length;
                        var current   = 0;

                        function goTo(page) {
                            current = Math.max(0, Math.min(page, total - 1));
                            wrapper.scrollTo({ left: wrapper.offsetWidth * current, behavior: 'smooth' });
                            dots.forEach(function (d, i) {
                                d.classList.toggle('active', i === current);
                            });
                            prevBtn.disabled = current === 0;
                            nextBtn.disabled = current === total - 1;
                        }

                        dots.forEach(function (dot) {
                            dot.addEventListener('click', function () {
                                goTo(parseInt(this.dataset.page));
                            });
                        });

                        prevBtn.addEventListener('click', function () { goTo(current - 1); });
                        nextBtn.addEventListener('click', function () { goTo(current + 1); });

                        // Sync dots saat user swipe manual
                        var scrollTimer;
                        wrapper.addEventListener('scroll', function () {
                            clearTimeout(scrollTimer);
                            scrollTimer = setTimeout(function () {
                                var page = Math.round(wrapper.scrollLeft / wrapper.offsetWidth);
                                if (page !== current) goTo(page);
                            }, 80);
                        });
                    })();
                    </script>
                    @endif

                    {{-- Script Filter Kategori --}}
                    <script>
                    (function () {
                        var filterBtns = document.querySelectorAll('#productFilterWrap .product-filter-btn');
                        var wrapper    = document.getElementById('productPagesWrapper');
                        var perPage    = 12;

                        // Simpan semua card asli sebelum dimanipulasi
                        var allOriginalCards = null;

                        function getAllCards() {
                            if (!allOriginalCards) {
                                allOriginalCards = Array.from(
                                    document.querySelectorAll('#productPagesWrapper .product[data-category]')
                                ).map(function (c) { return c.cloneNode(true); });
                            }
                            return allOriginalCards;
                        }

                        function renderFiltered(categoryId) {
                            var allCards = getAllCards();

                            var filtered = categoryId === 'all'
                                ? allCards
                                : allCards.filter(function (c) { return c.dataset.category == categoryId; });

                            wrapper.innerHTML = '';

                            if (filtered.length === 0) {
                                var emptyPage = document.createElement('div');
                                emptyPage.className = 'product-page';
                                emptyPage.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#999;padding:40px 0;">Tidak ada produk di kategori ini.</p>';
                                wrapper.appendChild(emptyPage);
                                rebuildPagination(0);
                                return;
                            }

                            var pages = [];
                            for (var i = 0; i < filtered.length; i += perPage) {
                                pages.push(filtered.slice(i, i + perPage));
                            }

                            pages.forEach(function (pageCards, idx) {
                                var pageDiv = document.createElement('div');
                                pageDiv.className = 'product-page';
                                pageDiv.id = 'productPage' + idx;
                                pageCards.forEach(function (card) {
                                    pageDiv.appendChild(card.cloneNode(true));
                                });
                                wrapper.appendChild(pageDiv);
                            });

                            wrapper.scrollTo({ left: 0, behavior: 'instant' });
                            rebuildPagination(pages.length);
                        }

                        function rebuildPagination(totalPages) {
                            var paginationEl = document.getElementById('productPagination');
                            if (!paginationEl) return;

                            paginationEl.style.display = totalPages > 1 ? 'flex' : 'none';

                            var dotsContainer = paginationEl.querySelector('.dots-container');
                            var prevBtn = document.getElementById('productPrev');
                            var nextBtn = document.getElementById('productNext');
                            if (!dotsContainer) return;

                            dotsContainer.innerHTML = '';
                            var current = 0;

                            for (var p = 0; p < totalPages; p++) {
                                (function(idx) {
                                    var dot = document.createElement('button');
                                    dot.className = 'page-dot' + (idx === 0 ? ' active' : '');
                                    dot.dataset.page = idx;
                                    dot.setAttribute('aria-label', 'Halaman ' + (idx + 1));
                                    dot.addEventListener('click', function () { goTo(idx); });
                                    dotsContainer.appendChild(dot);
                                })(p);
                            }

                            function goTo(page) {
                                current = Math.max(0, Math.min(page, totalPages - 1));
                                wrapper.scrollTo({ left: wrapper.offsetWidth * current, behavior: 'smooth' });
                                dotsContainer.querySelectorAll('.page-dot').forEach(function (d, i) {
                                    d.classList.toggle('active', i === current);
                                });
                                prevBtn.disabled = current === 0;
                                nextBtn.disabled = current === totalPages - 1;
                            }

                            prevBtn.onclick = function () { goTo(current - 1); };
                            nextBtn.onclick = function () { goTo(current + 1); };
                            prevBtn.disabled = true;
                            nextBtn.disabled = totalPages <= 1;
                        }

                        filterBtns.forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                                this.classList.add('active');
                                renderFiltered(this.dataset.category);
                            });
                        });
                    })();
                    </script>

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
                                <img src="images/banner/tokped-nocapt.png"
                                     alt="Tokopedia Banner"
                                     loading="lazy"
                                     width="600" height="300" />
                                <div class="overlay-text-1">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-12" data-aos="fade-up" data-aos-delay="400">
                        <a href="https://shopee.co.id/ikhtiar_berkah" class="banner" target="_blank">
                            <div class="banner-container">
                                <img src="images/banner/shope-nocapt.png"
                                     alt="Shopee Banner"
                                     loading="lazy"
                                     width="600" height="300" />
                                <div class="overlay-text">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- =============================================
             TESTIMONY AREA
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
                                    {{-- Bintang kosong --}}
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