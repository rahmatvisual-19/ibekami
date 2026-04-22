@extends('layout.WebLayout')

@section('title', __('privacy.page_title'))

@section('content')
<style>
    /* Custom Styling for Privacy Policy - IBEKAMI Image Match */
    :root {
        --ibekami-terracotta: #A65D3B; /* Warna cokelat terakota dari header/tombol */
        --ibekami-dark: #222222;      /* Warna teks gelap */
        --ibekami-bg-cream: #F4F1EA;   /* Warna latar belakang krem dari gambar */
        --ibekami-white: #ffffff;
        --ibekami-gray: #6c757d;
    }

    .privacy_policy_main_area {
        padding: 80px 0;
        background-color: var(--ibekami-bg-cream);
        color: var(--ibekami-dark);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .privacy_header {
        margin-bottom: 50px;
        text-align: center;
    }

    .privacy_header h1 {
        font-weight: 800;
        color: var(--ibekami-dark);
        margin-bottom: 15px;
        font-size: 2.5rem;
        letter-spacing: -1px;
    }

    .last-updated {
        color: var(--ibekami-gray);
        font-size: 0.9rem;
    }

    /* Breadcrumb Customization */
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: var(--ibekami-terracotta);
        text-decoration: none;
        font-weight: 600;
    }
    
    .breadcrumb-item.active {
        color: var(--ibekami-gray);
    }

    /* Content Card */
    .privacy_card {
        background: var(--ibekami-white);
        border-radius: 8px; /* Lebih kotak sesuai style di gambar */
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 50px;
        margin-bottom: 30px;
    }

    .privacy_content h3 {
        color: var(--ibekami-dark);
        font-weight: 700;
        margin-top: 40px;
        margin-bottom: 20px;
        border-left: 6px solid var(--ibekami-terracotta);
        padding-left: 20px;
        font-size: 1.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .privacy_content h3:first-of-type {
        margin-top: 0;
    }

    .privacy_content p, .privacy_content li {
        line-height: 1.8;
        color: #444;
        font-size: 1.05rem;
    }

    .privacy_content ul {
        padding-left: 20px;
        margin-bottom: 25px;
    }

    .privacy_content ul li {
        margin-bottom: 12px;
        list-style-type: none;
        position: relative;
    }

    .privacy_content ul li::before {
        content: "→"; /* Arrow style */
        color: var(--ibekami-terracotta);
        font-weight: bold;
        display: inline-block; 
        width: 1.5em;
        margin-left: -1.5em;
    }

    /* Sticky Sidebar Navigation */
    .toc_sidebar {
        position: sticky;
        top: 120px;
        background: var(--ibekami-white);
        padding: 25px;
        border-radius: 8px;
        border: 1px solid #e0ddd5;
    }

    .toc_sidebar h5 {
        font-weight: 800;
        margin-bottom: 20px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--ibekami-terracotta);
    }

    .toc_sidebar ul {
        list-style: none;
        padding: 0;
    }

    .toc_sidebar ul li {
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
    }

    .toc_sidebar ul li a {
        color: var(--ibekami-dark);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        font-weight: 500;
        display: block;
    }

    .toc_sidebar ul li a:hover {
        color: var(--ibekami-terracotta);
        padding-left: 5px;
    }

    /* Contact Box */
    .contact_box {
        background: #fdfaf5;
        padding: 30px;
        border-radius: 8px;
        margin-top: 30px;
        border: 1px solid #e0ddd5;
    }

    .contact_box a {
        color: var(--ibekami-terracotta);
        font-weight: 700;
        text-decoration: none;
    }

    .lead {
        font-size: 1.25rem;
        font-weight: 500;
        color: var(--ibekami-dark);
        margin-bottom: 30px;
    }

    @media (max-width: 991px) {
        .toc_sidebar {
            display: none;
        }
        .privacy_card {
            padding: 30px 20px;
        }
    }
</style>

<section class="privacy_policy_main_area">
    <div class="container">
        <!-- Header Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="privacy_header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/">{{ __('privacy.breadcrumb_home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('privacy.breadcrumb_active') }}</li>
                        </ol>
                    </nav>
                    <h1>{{ __('privacy.page_title') }}</h1>
                    <p class="last-updated">{{ __('privacy.last_updated', ['date' => date('d F Y')]) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Nav (Desktop only) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="toc_sidebar">
                    <h5>{{ __('privacy.toc_title') }}</h5>
                    <ul>
                        <li><a href="#section-1">{{ __('privacy.toc_1') }}</a></li>
                        <li><a href="#section-2">{{ __('privacy.toc_2') }}</a></li>
                        <li><a href="#section-3">{{ __('privacy.toc_3') }}</a></li>
                        <li><a href="#section-4">{{ __('privacy.toc_4') }}</a></li>
                        <li><a href="#section-5">{{ __('privacy.toc_5') }}</a></li>
                        <li><a href="#section-6">{{ __('privacy.toc_6') }}</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="privacy_card">
                    <div class="privacy_content">
                        
                        <div id="section-0" class="mb-5">
                            <p class="lead">{{ __('privacy.intro') }}</p>
                        </div>

                        <div id="section-1">
                            <h3>{{ __('privacy.s1_title') }}</h3>
                            <p>{{ __('privacy.s1_desc') }}</p>
                            <ul>
                                <li>{!! __('privacy.s1_item1') !!}</li>
                                <li>{!! __('privacy.s1_item2') !!}</li>
                                <li>{!! __('privacy.s1_item3') !!}</li>
                            </ul>
                        </div>

                        <div id="section-2">
                            <h3>{{ __('privacy.s2_title') }}</h3>
                            <p>{{ __('privacy.s2_desc') }}</p>
                            <ul>
                                <li>{{ __('privacy.s2_item1') }}</li>
                                <li>{{ __('privacy.s2_item2') }}</li>
                                <li>{{ __('privacy.s2_item3') }}</li>
                                <li>{{ __('privacy.s2_item4') }}</li>
                            </ul>
                        </div>

                        <div id="section-3">
                            <h3>{{ __('privacy.s3_title') }}</h3>
                            <p>{{ __('privacy.s3_desc') }}</p>
                        </div>

                        <div id="section-4">
                            <h3>{{ __('privacy.s4_title') }}</h3>
                            <p>{{ __('privacy.s4_desc') }}</p>
                        </div>

                        <div id="section-5">
                            <h3>{{ __('privacy.s5_title') }}</h3>
                            <p>{{ __('privacy.s5_desc') }}</p>
                            <ul>
                                <li>{{ __('privacy.s5_item1') }}</li>
                                <li>{{ __('privacy.s5_item2') }}</li>
                                <li>{{ __('privacy.s5_item3') }}</li>
                            </ul>
                        </div>

                        <div id="section-6">
                            <h3>{{ __('privacy.s6_title') }}</h3>
                            <p>{!! __('privacy.s6_desc') !!}</p>
                            
                            <div class="contact_box">
                                <ul class="mb-0">
                                    <li><strong>{{ __('privacy.s6_email') }}:</strong> <a href="mailto:ibeka1011@gmail.com">ibeka1011@gmail.com</a></li>
                                    <li><strong>{{ __('privacy.s6_instagram') }}:</strong> <a href="https://instagram.com/ibekami.id" target="_blank">@ibekami.id</a></li>
                                    <li><strong>{{ __('privacy.s6_location') }}:</strong> {{ __('privacy.s6_loc_value') }}</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection