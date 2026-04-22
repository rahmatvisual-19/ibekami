@extends('layout.WebLayout')

@section('title', __('machine.page_title'))

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
                        <input type="search" name="name" placeholder="{{ __('machine.search_placeholder') }}">
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
                        <a href="/"><img src="/images/logo/Logo IBEKAMI.png"
                                alt="ibekami.id" /></a>
                        <span style="display: block; font-size: 11px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                            Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                        </span>
                    </div>

                    <div class="main-menu">
                        <ul>
                            <li>
                                <a href="{{ url('/') }}#new-product" class="nav-link">{{ __('machine.nav_new_product') }}</a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}#promo" class="nav-link">{{ __('machine.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                            </li>
                            <li class="dropdown position-relative">
                                <a href="#">{{ __('machine.nav_catalogue') }} <i class="ion-ios-arrow-down"></i></a>
                                <ul class="sub-menu">
                                     <li>
                                <a href="{{route('shop')}}">{{ __('machine.nav_all_product') }}</a>
                                </li>
                                    @foreach ($types as $type)
                                        <li><a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="#about" class="nav-link">{{ __('machine.nav_information') }}</a>
                            </li>
                            <li>
                            <a href = "{{route('machine')}}">{{ __('machine.nav_our_machine') }}</a>
                        </li>
                        </ul>
                    </div>
                    <div class="header-actions">
                        <div class="header_account_list">
                            <div>
                                <form id="home-search-form" class="home-search-form" action="{{ route('shop') }}" method="GET">
                                    <input type="search" name="name" placeholder="{{ __('machine.search_placeholder') }}" id="search-input">
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
                            <a href = "{{ url('/') }}#new-product">{{ __('machine.nav_new_product') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#promo">{{ __('machine.nav_hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                        </li>
                        <li><a href="#"><span class="menu-text">{{ __('machine.nav_catalogue') }}</span></a>
                            <ul class="sub-menu">
                                 <li>
                                <a href="{{route('shop')}}">{{ __('machine.nav_all_product') }}</a>
                                </li>
                                @foreach ($types as $type)
                                    <li>
                                        <a href="{{ route('shop', ['type' => $type->id]) }}"><span
                                                class="menu-text">{{ $type->name }}</span></a>
                                        <ul class="sub-menu">
                                             <li>
                                <a href="{{route('shop')}}">{{ __('machine.nav_all_product') }}</a>
                                </li>
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
                            <a href = "#about">{{ __('machine.nav_information') }}</a>
                        </li>

                        <li>
                            <a href = "{{route('machine')}}">{{ __('machine.nav_our_machine') }}</a>
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
                            <h2 class="breadcrumb-title">{{ __('machine.breadcrumb_title') }}</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-12">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-md-end">
                                <li class="breadcrumb-item"><a href="/">{{ __('machine.breadcrumb_home') }}</a></li>
                               <li class="breadcrumb-item">{{ __('machine.breadcrumb_machine') }}</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Shop Category pages -->
    <div class="shop-category-area pb-100px pt-70px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12  col-md-12">
                   {{-- !-- Shop Bottom Area Start --> --}}
                    <div class="shop-bottom-area">
                        <div class="row">
                                @foreach($machine as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-20px" data-aos="fade-up">
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="#" class="image">
                                                    <img src="{{ asset('storage/machine_picture/' . $item->image_url) }}" alt="" />
                                                    <img class="hover-image" src="{{ asset('storage/machine_picture/' . $item->image_url) }}" alt="#" />
                                                </a>
                                                <span class="overlay-button">
                                                    
                                                </span>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="#">{{ $item->title }}</a></h5>
                                            </div>
                                            <span class="mobile-view">
                                                <a href="#">
                                                    
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- {{ $machine->withQueryString()->links('vendor.pagination.bootstrap-5') }} --}}
                            
                        </div>
                    </div>
                    <!-- Shop Bottom Area End --> 
                   
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Category pages -->
@endsection