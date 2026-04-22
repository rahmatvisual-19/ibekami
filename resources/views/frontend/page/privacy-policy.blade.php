@extends('layout.WebLayout')

@section('title', 'Kebijakan Privasi IBEKAMI')

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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                    <h1>Kebijakan Privasi IBEKAMI</h1>
                    <p class="last-updated">Terakhir diperbarui: {{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Nav (Desktop only) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="toc_sidebar">
                    <h5>Daftar Isi</h5>
                    <ul>
                        <li><a href="#section-1">1. Informasi Koleksi</a></li>
                        <li><a href="#section-2">2. Penggunaan Data</a></li>
                        <li><a href="#section-3">3. Keamanan Data</a></li>
                        <li><a href="#section-4">4. Pihak Ketiga</a></li>
                        <li><a href="#section-5">5. Hak Pelanggan</a></li>
                        <li><a href="#section-6">6. Kontak Kami</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="privacy_card">
                    <div class="privacy_content">
                        
                        <div id="section-0" class="mb-5">
                            <p class="lead">Di IBEKAMI, kami sangat menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan kami.</p>
                        </div>

                        <div id="section-1">
                            <h3>1. Informasi yang Kami Kumpulkan</h3>
                            <p>Kami mengumpulkan informasi yang Anda berikan secara langsung saat melakukan pemesanan atau konsultasi desain:</p>
                            <ul>
                                <li><strong>Identitas Pribadi:</strong> Nama lengkap dan alamat pengiriman untuk keperluan logistik produk (plakat, tumbler, banner).</li>
                                <li><strong>Informasi Kontak:</strong> Alamat email dan nomor telepon/WhatsApp untuk koordinasi pesanan.</li>
                                <li><strong>Data Desain:</strong> File logo, foto, atau materi desain yang Anda kirimkan untuk kebutuhan cetak kustom.</li>
                            </ul>
                        </div>

                        <div id="section-2">
                            <h3>2. Penggunaan Informasi Anda</h3>
                            <p>Informasi yang kami kumpulkan digunakan secara eksklusif untuk:</p>
                            <ul>
                                <li>Memproses dan menyelesaikan pesanan produk digital printing atau souvenir Anda.</li>
                                <li>Berkomunikasi terkait status pesanan atau pertanyaan teknis desain.</li>
                                <li>Mengatur pengiriman barang agar sampai tepat waktu ke lokasi Anda.</li>
                                <li>Meningkatkan kualitas layanan berdasarkan umpan balik pelanggan.</li>
                            </ul>
                        </div>

                        <div id="section-3">
                            <h3>3. Keamanan Data Pelanggan</h3>
                            <p>Kami berkomitmen untuk menjaga keamanan data Anda. File desain yang Anda kirimkan untuk kebutuhan produksi hanya akan digunakan untuk kepentingan produksi pesanan Anda dan tidak akan disebarluaskan.</p>
                        </div>

                        <div id="section-4">
                            <h3>4. Layanan Pihak Ketiga</h3>
                            <p>Kami bekerja sama dengan platform e-commerce dan mitra logistik. Harap dicatat bahwa saat bertransaksi melalui marketplace, kebijakan privasi platform tersebut juga berlaku.</p>
                        </div>

                        <div id="section-5">
                            <h3>5. Hak Anda sebagai Pelanggan</h3>
                            <p>Anda memiliki kontrol penuh atas data Anda, termasuk hak untuk:</p>
                            <ul>
                                <li>Meminta rincian data pribadi yang kami simpan.</li>
                                <li>Memperbarui atau memperbaiki data kontak dan alamat yang salah.</li>
                                <li>Meminta penghapusan data Anda dari sistem kami dengan menghubungi admin.</li>
                            </ul>
                        </div>

                        <div id="section-6">
                            <h3>6. Jam Operasional dan Kontak</h3>
                            <p>Jika ada pertanyaan lebih lanjut, tim support kami siap membantu pada jam operasional <strong>(Senin – Sabtu: 08:30 – 17:00 WIB)</strong> melalui:</p>
                            
                            <div class="contact_box">
                                <ul class="mb-0">
                                    <li><strong>Email:</strong> <a href="mailto:ibeka1011@gmail.com">ibeka1011@gmail.com</a></li>
                                    <li><strong>Instagram:</strong> <a href="https://instagram.com/ibekami.id" target="_blank">@ibekami.id</a></li>
                                    <li><strong>Lokasi:</strong> Medan, Indonesia</li>
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