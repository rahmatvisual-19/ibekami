{{--
    Navbar Partial - dipakai di semua halaman frontend
    Variabel yang dibutuhkan: $types (dari controller)
--}}

<!-- Header Area Start -->
<div class="header section">

    <!-- Mobile Navbar -->
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
                    <input type="search" name="name" placeholder="{{ __('nav.search_placeholder') }}">
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="lang-toggle lang-toggle--mobile">
                <a href="{{ route('lang.switch', 'id') }}" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
                <span class="lang-divider">|</span>
                <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
            <a href="#offcanvas-mobile-menu" class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                <i class="icon-menu"></i>
            </a>
        </div>
    </div>

    <!-- Desktop Navbar -->
    <div class="bg-brown d-none d-lg-block sticky-nav">
        <div class="nav-container">
            <div class="header-logo text-center">
                <a href="/"><img src="/images/logo/Logo IBEKAMI.png" alt="ibekami.id" /></a>
                <span style="display: block; font-size: 11px; font-weight: 600; line-height: 1.2; margin-top: 5px; color: #000;">
                    Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)
                </span>
            </div>
            <div class="main-menu">
                <ul>
                    <li>
                        <a href="{{ url('/') }}#new-product" class="nav-link">{{ __('nav.new_product') }}</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#promo" class="nav-link">{{ __('nav.hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                    </li>
                    <li class="dropdown position-relative">
                        <a href="#">{{ __('nav.catalogue') }} <i class="ion-ios-arrow-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('shop') }}">{{ __('nav.all_product') }}</a></li>
                            @foreach ($types as $type)
                                <li><a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#about" class="nav-link">{{ __('nav.information') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('machine') }}">{{ __('nav.our_machine') }}</a>
                    </li>
                </ul>
            </div>
            <div class="header-actions">
                <div class="header_account_list">
                    <form id="home-search-form" class="home-search-form" action="{{ route('shop') }}" method="GET">
                        <input type="search" name="name" placeholder="{{ __('nav.search_placeholder') }}" id="search-input">
                        <button type="button"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="lang-toggle">
                    <a href="{{ route('lang.switch', 'id') }}" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
                    <span class="lang-divider">|</span>
                    <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Header Area End -->

<!-- OffCanvas Menu Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <button class="offcanvas-close"></button>
    <div class="inner customScroll">
        <div class="lang-toggle lang-toggle--offcanvas" style="padding: 16px 20px 0;">
            <a href="{{ route('lang.switch', 'id') }}" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}">🇮🇩 Indonesia</a>
            <span class="lang-divider" style="margin: 0 8px;">|</span>
            <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">🇬🇧 English</a>
        </div>
        <div class="offcanvas-menu mb-20px">
            <ul>
                <li><a href="/">Home</a></li>
                <li>
                    <a href="{{ url('/') }}#new-product">{{ __('nav.new_product') }}</a>
                </li>
                <li>
                    <a href="{{ url('/') }}#promo">{{ __('nav.hot_deals') }} <i class="fa-solid fa-fire" style="color: #ff7b00;"></i></a>
                </li>
                <li>
                    <a href="#"><span class="menu-text">{{ __('nav.catalogue') }}</span></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('shop') }}">{{ __('nav.all_product') }}</a></li>
                        @foreach ($types as $type)
                            <li>
                                <a href="{{ route('shop', ['type' => $type->id]) }}">
                                    <span class="menu-text">{{ $type->name }}</span>
                                </a>
                                <ul class="sub-menu">
                                    @foreach ($type->categories as $category)
                                        <li>
                                            <a href="{{ route('shop', ['category' => $category->id, 'type' => $type->id]) }}">
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
                    <a href="{{ url('/') }}#about">{{ __('nav.information') }}</a>
                </li>
                <li>
                    <a href="{{ route('machine') }}">{{ __('nav.our_machine') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- OffCanvas Menu End -->

<div class="offcanvas-overlay"></div>
