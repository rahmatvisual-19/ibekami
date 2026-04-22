@extends('layout.WebLayout')

@section('title', "$type_name")

@section('content')
    <!-- Header Area start  -->
    <div class="header section">
        <!-- Header Bottom  Start -->
        <div class="header-bottom d-lg-none sticky-nav">
            <div class="nav-container-mobile">
                 <div class="header-logo text-center">
                    <a href="/"><img src="/images/logo/Logo IBEKAMI.png" /></a>
                    <span style="display: block; font-size: 10px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                        Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                    </span>
                </div> 
                
                <div class="header_account_list">
                    <form class="home-search-form" action="{{ route('shop') }}" method="GET">
                        <input type="search" name="name" placeholder="{{ __('product.search_placeholder') }}">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <a href="#offcanvas-mobile-menu"
                    class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                    <i class="icon-menu"></i>
                </a>
            </div>
        </div>
        <!-- Header Bottom  End -->
        <!-- Main Menu Start -->
        <div class="bg-brown d-none d-lg-block sticky-nav">
        <div class="nav-container">
                <div class="header-logo text-center" style="bg-bl">
                    <a href="/"><img  src="/images/logo/Logo IBEKAMI.png"
                            alt="Site Logo" /></a>
                    <span style="display: block; font-size: 11px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                        Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                    </span>
                </div> 
               
                <div class="main-menu">
                             <ul>
                            <li>
                                <a href="{{ url('/') }}#new-product" class="nav-link">{{ __('product.nav_new_product') }}</a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}#promo" class="nav-link">{{ __('product.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                            </li>
                            <li class="dropdown position-relative">
                                <a href="#">{{ __('product.nav_catalogue') }} <i class="ion-ios-arrow-down"></i></a>
                                <ul class="sub-menu">
                                    <li>
                                <a href="{{route('shop')}}">{{ __('product.nav_all_product') }}</a>
                                </li>
                                    @foreach ($types as $type)
                                        <li><a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="#about" class="nav-link">{{ __('product.nav_information') }}</a>
                            </li>
                            <li>
                            <a href = "{{route('machine')}}">{{ __('product.nav_our_machine') }}</a>
                        </li>
                        </ul>
                        </div>
                <div class="header-actions">
                    <div class="header_account_list">
                        <div>
                            <form id="home-search-form" class="home-search-form" action="{{ route('shop') }}" method="GET">
                                <input type="search" name="name" placeholder="{{ __('product.search_placeholder') }}" id="search-input">
                                <button type="button"> <!-- Add type="button" to prevent form submission -->
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Menu End -->
    </div>
    <!-- Header Area End  -->

    <!-- OffCanvas Menu Start -->
    <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
        <button class="offcanvas-close"></button>
        <div class="inner customScroll">

            <div class="offcanvas-menu mb-20px">
                <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li>
                            <a href = "{{ url('/') }}#new-product">{{ __('product.nav_new_product') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#promo">{{ __('product.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                        </li>
                        <li><a href="#"><span class="menu-text">{{ __('product.nav_catalogue') }}</span></a>
                            <ul class="sub-menu">
                                 <li>
                                <a href="{{route('shop')}}">{{ __('product.nav_all_product') }}</a>
                                </li>
                                @foreach ($types as $type)
                                    <li>
                                        <a href="{{ route('shop', ['type' => $type->id]) }}"><span
                                                class="menu-text">{{ $type->name }}</span></a>
                                        <ul class="sub-menu">
                                            @foreach ($type->categories as $category)
                                                <li>
                                                    <a
                                                        href="{{ route('shop', ['category' => $category->id, 'type' => $type->id]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href = "#about">{{ __('product.nav_information') }}</a>
                        </li>
                        <li>
                            <a href = "{{route('machine')}}">{{ __('product.nav_our_machine') }}</a>
                        </li>
                    </ul>
            </div>
            <!-- OffCanvas Menu End -->
        </div>
    </div>
    <!-- OffCanvas Menu End -->


    <div class="offcanvas-overlay"></div>
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-start">
                            <h1 class="breadcrumb-title">{{ $product->name }}</h1>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-12">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-md-end">
                                <li class="breadcrumb-item"><a href="/">{{ __('product.breadcrumb_home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('product.breadcrumb_catalogue') }}</a></li>
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- breadcrumb-area end -->

    <!-- Product Details Area Start -->
    <div class="product-details-area mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                    <!-- Swiper -->
                    <div class="swiper-container zoom-top">
                        <div class="swiper-wrapper">
                            @foreach ($product->image_url as $image)
                                <div class="swiper-slide zoom-image-hover">
                                    <img class="img-responsive m-auto" src="{{ asset('storage/gambar_produk/' . $image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if (count($product->image_url) > 1)
                        <div class="swiper-container zoom-thumbs slider-nav-style-1 small-nav mt-15px mb-15px">
                            <div class="swiper-wrapper">
                                @foreach ($product->image_url as $image)
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto" src="{{ asset('storage/gambar_produk/' . $image) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-buttons">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-7 col-sm-12 col-xs-12 bg-transparent" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-details-content quickview-content">
                        <h2>{{ $product->name }}</h2>
                        <div class="product-anotherinfo-wrapper bg-transparent">
                            <!-- disini -->
                            <div class="description-review-wrapper">

                                    <!-- Product Description -->
                                    <div class="product-description-wrapper">
                                        <h4>{{ __('product.description') }}</h4>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <!-- Product Description End-->

                                <!-- Product Details -->
                                <div class="product-anotherinfo-wrapper">
                                    <h4>{{ __('product.product_details') }}</h4>
                                    <ul>
                                        @if ($product->detail)
                                            @foreach ($product->detail as $key => $value)
                                                <li>
                                                @php
                                                    $label = ucfirst($key);
                                                    $length = strlen($label);
                                                    $spaces = str_repeat('&nbsp;', 20 - $length);
                                                @endphp
                                                <span style="font-family: monospace; font-weight: bold;">
                                                    {!! $label . $spaces !!}: <span style="font-weight: normal;">{{ $value }}</span>
                                                </span>                        
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="no-detail">{{ __('product.no_detail') }}</li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- END OF NEW DESCRIPTION -->
                                <div class="pro-details-cart">
                                    <a href="https://wa.me/{{ $admin_1 }}?text={{ urlencode(__('product.whatsapp_text', ['name' => $product->name])) }}"  
                                    target="_blank"
                                    class="whatsapp-order-btn"
                                    data-product-id="{{ $product->product_id }}">
                                        <button class="add-cart btn btn-primary btn-hover-primary ml-4">
                                            <i class="icon-handbag"></i>
                                            <span>{{ __('product.ask_to_order') }}</span>
                                        </button>
                                    </a>
                                    <a href="/catalogue">
                                        <button class="add-cart btn btn-primary btn-hover-primary ml-4" href="/catalogue">
                                            <i class="icon-arrow-left"></i>
                                            <span>{{ __('product.back_to_catalogue') }}</span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- New Product Start -->
    <div class="section pb-100px" data-aos="fade-up" data-aos-delay="200">
        <div class="container">
            <!-- section title start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-start mb-11">
                        <h2 class="title">{{ __('product.you_might_like') }}</h2>
                    </div>
                </div>
            </div>
            <!-- section title start -->
            <div class="new-product-slider swiper-container slider-nav-style-1" data-aos="fade-up" data-aos-delay="200">
                <div class="new-product-wrapper swiper-wrapper">
                    <!-- Single Prodect -->
                    @foreach ($related_products as $related_product)
                        <div class="new-product-item swiper-slide">
                            <div class="product">
                                <div class="thumb">
                                    <a href="{{ route('product', $related_product->product_id) }}" class="image">
                                        @if(!empty($related_product->image_url))
                                            <img src="{{ asset('storage/gambar_produk/' . $related_product->image_url[0]) }}" alt="{{ $related_product->name }}" />
                                            <img class="hover-image" src="{{ asset('storage/gambar_produk/' . $related_product->image_url[0]) }}"
                                                alt="{{ $related_product->name }}" />
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="{{ $related_product->name }}" />
                                            <img class="hover-image" src="{{ asset('images/no-image.png') }}"
                                                alt="{{ $related_product->name }}" />
                                        @endif
                                    </a>
                                    <span class="overlay-button">
                                        <a href="{{ route('product', $related_product->product_id) }}">
                                            <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                                <i class="icon-magnifier"></i>
                                                <p>{{ __('product.discover_more') }}</p>
                                            </button>
                                        </a>
                                    </span>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a
                                            href="{{ route('product', $related_product->product_id) }}">{{ $related_product->name }}</a>
                                    </h5>
                                </div>
                                <span class="mobile-view">
                                    <a href="{{ route('product', $related_product->product_id) }}">
                                        <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                            <i class="icon-magnifier"></i>
                                            <p>{{ __('product.discover_more') }}</p>
                                        </button>
                                    </a>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Add Arrows -->
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>  
    </div>
@endsection