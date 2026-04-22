@extends('layout.WebLayout')

@if (request('type'))
    @php
        $type = \App\Models\Type::find(request('type'));
    @endphp
    @section('title', __('shop.breadcrumb_catalogue') . " $type->name")
@else
    @section('title', __('shop.breadcrumb_catalogue') . ' Products')
@endif

@section('content')
    <!-- Header Area start  -->
    <div class="header section">
        <!-- Header Start -->
        <div class="header-bottom d-lg-none sticky-nav">
            <div class="nav-container-mobile">
                 <div class="header-logo text-center">
                    <a href="/"><img src="images/logo/Logo IBEKAMI.png" /></a>
                    <span style="display: block; font-size: 10px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                        Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                    </span>
                </div> 
               
                <div class="header_account_list">
                    <form class="home-search-form" action="{{ route('shop') }}" method="GET">
                        <input type="search" name="name" placeholder="{{ __('shop.search_placeholder') }}">
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
        <!-- Header End -->
        <!-- Main Menu Start -->
        <div class="bg-brown d-none d-lg-block sticky-nav">
        <div class="nav-container">
                 <div class="header-logo text-center" style="bg-bl">
                    <a href="/"><img src="images/logo/Logo IBEKAMI.png"
                            alt="Site Logo" /></a>
                    <span style="display: block; font-size: 11px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                        Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                    </span>
                </div> 
                
                <div class="main-menu">
                             <ul>
                            <li>
                                <a href="{{ url('/') }}#new-product" class="nav-link">{{ __('shop.nav_new_product') }}</a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}#promo" class="nav-link">{{ __('shop.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                            </li>
                            <li class="dropdown position-relative">
                                <a href="#">{{ __('shop.nav_catalogue') }} <i class="ion-ios-arrow-down"></i></a>
                                <ul class="sub-menu">
                                    <li>
                                <a href="{{route('shop')}}">{{ __('shop.nav_all_product') }}</a>
                                </li>
                                    @foreach ($types as $type)
                                        <li><a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="#about" class="nav-link">{{ __('shop.nav_information') }}</a>
                            </li>
                            <li>
                            <a href = "{{route('machine')}}">{{ __('shop.nav_our_machine') }}</a>
                        </li>
                        </ul>
                        </div>
                <div class="header-actions">
                    <div class="header_account_list">
                        <div>
                            <form id="home-search-form" class="home-search-form" action="{{ route('shop') }}" method="GET">
                                <input type="search" name="name" placeholder="{{ __('shop.search_placeholder') }}" id="search-input">
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
                            <a href = "{{ url('/') }}#new-product">{{ __('shop.nav_new_product') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#promo">{{ __('shop.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                        </li>
                        <li><a href="#"><span class="menu-text">{{ __('shop.nav_catalogue') }}</span></a>
                            <ul class="sub-menu">
                                 <li>
                                <a href="{{route('shop')}}">{{ __('shop.nav_all_product') }}</a>
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
                            <a href = "#about">{{ __('shop.nav_information') }}</a>
                        </li>
                        <li>
                            <a href = "{{route('machine')}}">{{ __('shop.nav_our_machine') }}</a>
                        </li>
                    </ul>
            </div>
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
                            <h2 class="breadcrumb-title">{{ __('shop.breadcrumb_title') }}</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-12">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-md-end">
                                <li class="breadcrumb-item"><a href="/">{{ __('shop.breadcrumb_home') }}</a></li>
                                @if (request('type') || request('category'))   
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('shop') }}">{{ __('shop.breadcrumb_catalogue') }}</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item">{{ __('shop.breadcrumb_catalogue') }}</li>
                                @endif
                               

                                @if (request('type'))
                                    @php
                                        $type = \App\Models\Type::find(request('type'));
                                    @endphp
                                    @if (request('category'))
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('shop', ['type' => $type->id] + request()->except('category')) }}">{{ $type->name }}</a>
                                        </li>
                                    @else
                                        <li class="breadcrumb-item">
                                            {{ $type->name }}
                                        </li>
                                    @endif
                                @endif

                                @if (request('category'))
                                    @php
                                        $category = \App\Models\Category::find(request('category'));
                                    @endphp
                                    <li class="breadcrumb-item">
                                        {{ $category->name }}
                                    </li>
                                @endif
                            </ul>
                            <!-- breadcrumb-list end -->
                            {{-- Tombol Type atau Category untuk tampilan Mobile & Tablet --}}
                            <div class="d-lg-none mt-3 px-2">
                            <div class="category-grid">
                                @if(request('type'))
                                    @foreach ($categories as $category)
                                        <a href="{{ route('shop', ['category' => $category->id] + collect(request()->query())->except('page')->all()) }}"
                                        class="category-btn {{ request('category') == $category->id ? 'selected' : '' }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                @else
                                    @foreach ($types as $typeItem)
                                        <a href="{{ route('shop', ['type' => $typeItem->id]) }}"
                                        class="category-btn {{ request('type') == $typeItem->id ? 'selected' : '' }}">
                                            {{ $typeItem->name }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- breadcrumb-area end -->

    <!-- Shop Category pages -->
    <div class="shop-category-area pb-100px pt-70px">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    <!-- Shop Top Area Start -->
                    <div class="shop-top-bar d-flex">
                        <!-- Left Side start -->
                        <p>{{ __('shop.product_count', ['count' => $productCount]) }}</p>
                        <!-- Left Side End -->
                        <!-- Right Side Start -->
                        <div class="select-shoing-wrap d-flex align-items-center">
                            <div class="shot-product">
                                <p>{{ __('shop.sort_by') }}</p>
                            </div>
                            <div class="shop-select">
                                <select class="shop-sort" onchange="window.location.href = this.value;">
                                    <option value="{{ route('shop', ['sort' => 'time_desc'] + request()->query()) }}" {{ request('sort') == 'time_desc' ? 'selected' : '' }}>
                                        {{ __('shop.sort_newest') }}
                                    </option>
                                    <option value="{{ route('shop', ['sort' => 'time_asc'] + request()->query()) }}" {{ request('sort') == 'time_asc' ? 'selected' : '' }}>
                                        {{ __('shop.sort_oldest') }}
                                    </option>
                                    <option value="{{ route('shop', ['sort' => 'name_asc'] + request()->query()) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                        {{ __('shop.sort_name_asc') }}
                                    </option>
                                    <option value="{{ route('shop', ['sort' => 'name_desc'] + request()->query()) }}" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                        {{ __('shop.sort_name_desc') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Right Side End -->
                    </div>
                    <!-- Shop Top Area End -->
                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area">
                        <div class="row">
                            @if($products->isEmpty())
                                <div class="col-12 text-center">
                                    <div class="error-404 d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
                                        <h2>{{ __('shop.no_products') }}</h2>
                                        <a href="{{ url('/') }}" class="btn btn-primary">{{ __('shop.back_home') }}</a>
                                    </div>
                                </div>
                            @else
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-20px" data-aos="fade-up">
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="{{ route('product', $product->product_id) }}" class="image">
                                                    @if(!empty($product->image_url))
                                                        <img src="{{ asset('storage/gambar_produk/' . $product->image_url[0]) }}" alt="{{ $product->name }}" />
                                                        <img class="hover-image" src="{{ asset('storage/gambar_produk/' . $product->image_url[0]) }}" alt="{{ $product->name }}" />
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}" alt="{{ $product->name }}" />
                                                        <img class="hover-image" src="{{ asset('images/no-image.png') }}" alt="{{ $product->name }}" />
                                                    @endif
                                                </a>
                                                <span class="overlay-button">
                                                    <a href="{{ route('product', $product->product_id) }}">
                                                        <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                                            <i class="icon-magnifier"></i>
                                                            <p>{{ __('shop.discover_more') }}</p>
                                                        </button>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="{{ route('product', $product->product_id) }}">{{ $product->name }}</a></h5>
                                            </div>
                                            <span class="mobile-view">
                                                <a href="{{ route('product', $product->product_id) }}">
                                                    <button id="order-btn" class="add-cart btn btn-primary btn-hover-primary ml-4">
                                                        <i class="icon-magnifier"></i>
                                                        <p>{{ __('shop.discover_more') }}</p>
                                                    </button>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                    <!-- Shop Bottom Area End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-md-60px mb-lm-60px hidden-on-mobile">
                    <div class="shop-sidebar-wrap">
                        <!-- Sidebar single item -->
                        <div class="sidebar-widget">
                            <div class="main-heading">
                                <h3 class="sidebar-title">{{ __('shop.sidebar_category') }}</h3>
                            </div>
                            <div class="sidebar-widget-category">
                                <ul>
    @if (request('type'))
        {{-- Jika ada ?type=..., tampilkan daftar kategori --}}
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('shop', ['category' => $category->id] + collect(request()->query())->except('page')->all()) }}"
                   class="{{ request('category') == $category->id ? 'selected' : '' }}">
                    {{ $category->name }} <span>({{ $categoryCount[$category->id] ?? 0 }})</span>
                </a>
            </li>
        @endforeach
    @else
        {{-- Jika tidak ada ?type=..., tampilkan daftar type --}}
        @foreach ($types as $type)
            <li>
                <a href="{{ route('shop', ['type' => $type->id]) }}"
                   class="{{ request('type') == $type->id ? 'selected' : '' }}">
                    {{ $type->name }}
                </a>
            </li>
        @endforeach
    @endif
</ul>

                            </div>
                        </div>
                        <!-- Sidebar single item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection