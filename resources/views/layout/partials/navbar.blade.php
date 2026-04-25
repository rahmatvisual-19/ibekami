{{--
    Navbar Partial IBEKAMI - Versi V3 Premium & Balanced
    Menggunakan prefix ibk-v3- untuk optimasi layout dan isolasi total.
--}}

<style>
/* ── Variabel & Token Desain ────────────────────────────────── */
.ibk-v3-scope {
    --ibk-v3-primary: #b25533;
    --ibk-v3-primary-dark: #8e4228;
    --ibk-v3-accent: #ff9d6e;
    --ibk-v3-white: #ffffff;
    --ibk-v3-text-muted: rgba(255, 255, 255, 0.7);
    --ibk-v3-transition: all 0.25s ease;
    --ibk-v3-h-desktop: 110px;
    --ibk-v3-h-mobile: 80px;
    --ibk-v3-container-max: 1200px;
    font-family: 'Montserrat', sans-serif;
}

/* Reset Scope - Menghindari pengaruh dari style.css 9000 baris */
.ibk-v3-scope * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    list-style: none;
    text-decoration: none;
}

/* ── Container Utama ────────────────────────────────────────── */
.ibk-v3-navbar {
    background-color: var(--ibk-v3-primary);
    width: 100%;
    z-index: 9999;
    position: fixed;
    top: 0;
    left: 0;
    transition: var(--ibk-v3-transition);
}

/* Sticky State */
.ibk-v3-navbar.ibk-v3-sticky {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    background-color: rgba(178, 85, 51, 0.98);
    backdrop-filter: blur(8px);
}

/* ── Layout Wrapper (3-Column Grid) ─────────────────────────── */
.ibk-v3-nav-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 32px;
    display: grid;
    grid-template-columns: 200px 1fr 280px;
    align-items: center;
    height: var(--ibk-v3-h-desktop);
    gap: 24px;
}

/* Column 1: Logo (Left) */
.ibk-v3-col-left {
    display: flex;
    justify-content: flex-start;
}

/* Column 2: Menu (Center - Perfect Center) */
.ibk-v3-col-center {
    display: flex;
    justify-content: center;
}

/* Column 3: Actions (Right) */
.ibk-v3-col-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
}

/* ── Logo & Tagline ─────────────────────────────────────────── */
.ibk-v3-logo-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.ibk-v3-logo-box img {
    height: 52px;
    width: auto;
    display: block;
}
.ibk-v3-tagline {
    color: var(--ibk-v3-white);
    font-size: 8.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 6px;
    line-height: 1.3;
}

/* ── Navigation Menu Desktop ────────────────────────────────── */
.ibk-v3-nav-list {
    display: flex;
    gap: 36px;
    align-items: center;
}
.ibk-v3-nav-link {
    color: var(--ibk-v3-white);
    font-size: 14px;
    font-weight: 600;
    padding: 8px 0;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: var(--ibk-v3-transition);
    white-space: nowrap;
}
.ibk-v3-nav-link:hover {
    color: var(--ibk-v3-accent);
}
.ibk-v3-nav-link i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

/* Dropdown Hierarchy */
.ibk-v3-dropdown { position: relative; }
.ibk-v3-dropdown:hover .ibk-v3-sub-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.ibk-v3-sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 220px;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    padding: 12px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(12px);
    transition: var(--ibk-v3-transition);
    z-index: 1000;
    margin-top: 8px;
}
.ibk-v3-sub-item a {
    display: block;
    padding: 10px 20px;
    color: #333;
    font-size: 13px;
    font-weight: 500;
}
.ibk-v3-sub-item a:hover {
    background-color: #fdf5f2;
    color: var(--ibk-v3-primary);
}

/* ── Aksi (Search & Lang) ──────────────────────────────────── */
/* Search Bar (Static/Normal) */
.ibk-v3-search-static {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 6px 16px;
}
.ibk-v3-search-static input {
    background: none;
    border: none;
    color: #fff;
    font-size: 13px;
    width: 140px;
    outline: none;
}
.ibk-v3-search-static input::placeholder { color: var(--ibk-v3-text-muted); }

/* Language Switcher */
.ibk-v3-lang-switcher {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    color: var(--ibk-v3-white);
}
.ibk-v3-lang-link {
    color: var(--ibk-v3-text-muted);
    transition: var(--ibk-v3-transition);
}
.ibk-v3-lang-link.active, .ibk-v3-lang-link:hover {
    color: #fff;
    text-decoration: underline;
}

/* ── Mobile View Style ───────────────────────────────────────── */
@media (max-width: 991px) {
    .ibk-v3-nav-container {
        grid-template-columns: 1fr auto;
        height: var(--ibk-v3-h-mobile);
        padding: 0 16px;
        gap: 0;
    }

    .ibk-v3-col-center { display: none; }

    .ibk-v3-col-left { flex: none; }
    .ibk-v3-logo-box img { height: 38px; }
    .ibk-v3-tagline { display: none; }

    .ibk-v3-col-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Sembunyikan search di mobile — ada di search bar bawah */
    .ibk-v3-search-static {
        display: none !important;
    }

    /* Language switcher di mobile: tampil kecil di samping hamburger */
    .ibk-v3-lang-switcher {
        font-size: 10px;
        gap: 4px;
    }

    /* Mobile Search Area */
    .ibk-v3-mobile-search-bar {
        background: var(--ibk-v3-primary-dark);
        padding: 10px 16px 12px;
    }
    .ibk-v3-mobile-form {
        display: flex;
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
    }
    .ibk-v3-mobile-form input {
        flex: 1;
        border: none;
        padding: 10px 14px;
        font-size: 14px;
        outline: none;
        min-width: 0;
    }
    .ibk-v3-mobile-form button {
        background: none;
        border: none;
        padding: 0 16px;
        color: var(--ibk-v3-primary);
        cursor: pointer;
        flex-shrink: 0;
    }
}

/* ── Offcanvas Mobile Sidebar ─────────────────────────────── */
.ibk-v3-offcanvas {
    position: fixed;
    top: 0;
    right: -310px;
    width: 300px;
    height: 100%;
    background: #fff;
    z-index: 10001;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: -5px 0 25px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
}
.ibk-v3-offcanvas.open { transform: translateX(-310px); }
.ibk-v3-offcanvas-header {
    padding: 24px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ibk-v3-offcanvas-body {
    padding: 10px 24px;
    overflow-y: auto;
    flex: 1;
}
.ibk-v3-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 10000;
    display: none;
}
.ibk-v3-overlay.show { display: block; }

.ibk-v3-mobile-link {
    display: block;
    padding: 16px 0;
    color: #333;
    font-weight: 700;
    font-size: 15px;
    border-bottom: 1px solid #f5f5f5;
    position: relative;
}

/* Mobile submenu expand */
.ibk-v3-mobile-item.has-submenu > .ibk-v3-mobile-link::after {
    content: '\f078';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 0;
    font-size: 12px;
    transition: transform 0.2s;
}
.ibk-v3-mobile-item.has-submenu.open > .ibk-v3-mobile-link::after {
    transform: rotate(180deg);
}
.ibk-v3-mobile-submenu {
    display: none;
    padding-left: 16px;
    margin-top: 8px;
}
.ibk-v3-mobile-item.open .ibk-v3-mobile-submenu { display: block; }
.ibk-v3-mobile-submenu a {
    display: block;
    padding: 10px 0;
    color: #666;
    font-size: 13px;
    font-weight: 500;
    border-bottom: 1px solid #f9f9f9;
}
</style>

<div class="ibk-v3-scope">
    <header class="ibk-v3-navbar" id="ibk-v3-header">
        
        <div class="ibk-v3-nav-container">
            
            {{-- Bagian Kiri: Logo --}}
            <div class="ibk-v3-col-left">
                <a href="/" class="ibk-v3-logo-box">
                    <img src="/images/logo/Logo IBEKAMI.png" alt="IBEKAMI">
                    <span class="ibk-v3-tagline">Ikhtiar Berkah, Ekonomi Kreatif<br>Asli Medan Indonesia (IBEKAMI)</span>
                </a>
            </div>

            {{-- Bagian Tengah: Menu (Hanya Desktop) --}}
            <nav class="ibk-v3-col-center d-none d-lg-flex">
                <ul class="ibk-v3-nav-list">
                    <li><a href="{{ url('/') }}#new-product" class="ibk-v3-nav-link">{{ __('nav.new_product') }}</a></li>
                    <li>
                        <a href="{{ url('/') }}#promo" class="ibk-v3-nav-link">
                            {{ __('nav.hot_deals') }}
                            <i class="fa-solid fa-fire" style="color:#ffcc00;font-size:13px;margin-left:2px;"></i>
                        </a>
                    </li>
                    <li class="ibk-v3-dropdown">
                        <a href="#" class="ibk-v3-nav-link">
                            {{ __('nav.catalogue') }}
                            <i class="fa fa-chevron-down" style="font-size:9px;margin-left:2px;"></i>
                        </a>
                        <ul class="ibk-v3-sub-menu">
                            <li class="ibk-v3-sub-item"><a href="{{ route('shop') }}"><b>{{ __('nav.all_product') }}</b></a></li>
                            @foreach ($types as $type)
                                <li class="ibk-v3-sub-item"><a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ url('/') }}#about" class="ibk-v3-nav-link">{{ __('nav.information') }}</a></li>
                    <li><a href="{{ route('machine') }}" class="ibk-v3-nav-link">{{ __('nav.our_machine') }}</a></li>
                </ul>
            </nav>

            {{-- Bagian Kanan: Aksi --}}
            <div class="ibk-v3-col-right">
                
                {{-- Search Desktop --}}
                <form action="{{ route('shop') }}" method="GET" class="ibk-v3-search-static d-none d-lg-flex">
                    <input type="search" name="name" placeholder="Cari produk...">
                </form>

                {{-- Language Switcher (Disesuaikan posisinya di mobile) --}}
                <div class="ibk-v3-lang-switcher">
                    <a href="{{ route('lang.switch', 'id') }}" class="ibk-v3-lang-link {{ app()->getLocale() === 'id' ? 'active' : '' }}">INDONESIA</a>
                    <span style="opacity:0.3">|</span>
                    <a href="{{ route('lang.switch', 'en') }}" class="ibk-v3-lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">ENGLISH</a>
                </div>

                {{-- Hamburger Mobile --}}
                <button class="ibk-v3-icon-btn d-lg-none" id="ibk-v3-hamburger" style="background:none; border:none; color:#fff; font-size:24px; cursor:pointer;">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search (Baris Kedua) --}}
        <div class="ibk-v3-mobile-search-bar d-lg-none">
            <form class="ibk-v3-mobile-form" action="{{ route('shop') }}" method="GET">
                <input type="search" name="name" placeholder="Cari produk di sini...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

    </header>

    {{-- Offcanvas Mobile Sidebar --}}
    <div class="ibk-v3-overlay" id="ibk-v3-overlay"></div>
    <aside class="ibk-v3-offcanvas" id="ibk-v3-sidebar">
        <div class="ibk-v3-offcanvas-header">
            <img src="/images/logo/Logo IBEKAMI.png" alt="Logo" height="35">
            <i class="fa fa-times" id="ibk-v3-close" style="font-size:22px; color:#333; cursor:pointer;"></i>
        </div>
        <div class="ibk-v3-offcanvas-body">
            <ul class="ibk-v3-mobile-list">
                <li class="ibk-v3-mobile-item"><a href="/" class="ibk-v3-mobile-link">Home</a></li>
                <li class="ibk-v3-mobile-item"><a href="{{ url('/') }}#new-product" class="ibk-v3-mobile-link">{{ __('nav.new_product') }}</a></li>
                <li class="ibk-v3-mobile-item"><a href="{{ url('/') }}#promo" class="ibk-v3-mobile-link">{{ __('nav.hot_deals') }}</a></li>
                
                {{-- Katalog dengan submenu --}}
                <li class="ibk-v3-mobile-item has-submenu">
                    <a href="javascript:void(0)" class="ibk-v3-mobile-link ibk-v3-submenu-toggle">{{ __('nav.catalogue') }}</a>
                    <div class="ibk-v3-mobile-submenu">
                        <a href="{{ route('shop') }}"><b>{{ __('nav.all_product') }}</b></a>
                        @foreach ($types as $type)
                            <a href="{{ route('shop', ['type' => $type->id]) }}">{{ $type->name }}</a>
                        @endforeach
                    </div>
                </li>

                <li class="ibk-v3-mobile-item"><a href="{{ url('/') }}#about" class="ibk-v3-mobile-link">{{ __('nav.information') }}</a></li>
                <li class="ibk-v3-mobile-item"><a href="{{ route('machine') }}" class="ibk-v3-mobile-link">{{ __('nav.our_machine') }}</a></li>
            </ul>
        </div>
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('ibk-v3-header');
    const openBtn = document.getElementById('ibk-v3-hamburger');
    const closeBtn = document.getElementById('ibk-v3-close');
    const sidebar = document.getElementById('ibk-v3-sidebar');
    const overlay = document.getElementById('ibk-v3-overlay');

    /* ── Sticky Scroll Logic ── */
    window.addEventListener('scroll', () => {
        if (window.scrollY > 80) {
            header.classList.add('ibk-v3-sticky');
        } else {
            header.classList.remove('ibk-v3-sticky');
        }
    });

    /* ── Mobile Toggle Logic ── */
    const toggleSidebar = (state) => {
        if (state) {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    };

    openBtn.addEventListener('click', () => toggleSidebar(true));
    closeBtn.addEventListener('click', () => toggleSidebar(false));
    overlay.addEventListener('click', () => toggleSidebar(false));

    /* ── Mobile submenu expand ── */
    document.querySelectorAll('.ibk-v3-submenu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            this.closest('.ibk-v3-mobile-item').classList.toggle('open');
        });
    });
});
</script>