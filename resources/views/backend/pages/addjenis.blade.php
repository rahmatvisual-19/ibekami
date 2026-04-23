@extends('backend.layout.template')

@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            
            border-radius: 7px;
            size: 15px;
        }

        input[type="text"] {
            width: 100;
            padding: 10px;
            margin: auto;

            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ breadcrumb ] start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Jenis Produk Ikhtiar Berkah</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/jenis-produk">Daftar Jenis Produk</a>
                                                </li>
                                                <!-- <li class="breadcrumb-item"><a href="#!">Plakat</a></li> -->
                                                <li class="breadcrumb-item"><a href="#!">Tambah Jenis Produk</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Tambah Jenis Produk</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Jenis Produk</label>
                                                        <input type="text" name="nama_jenis" class="form-control" id="exampleInputEmail1"
                                                            aria-describedby="emailHelp" placeholder="Nama Jenis Barang">
                                                            @error('nama_jenis')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="form-file mb-3">
                                                <label class="form-label">Gambar Jenis Produk</label>
                                                    <input type="file" name="gambar_jenis" id="gambar_jenis" class="form-control" aria-label="file example" onchange="previewJenis()">
                                                    @error('gambar_jenis')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="img-preview-jenis" style="width:150px;height:150px;object-fit:contain;display:none;border:1px solid #ddd;" alt="Preview">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Simpan Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function previewJenis() {
        var input = document.getElementById('gambar_jenis');
        var preview = document.getElementById('img-preview-jenis');
        if (input.files && input.files[0]) {
            WebPConverter.convertToWebP(input.files[0]).then(function(blob) {
                preview.src = URL.createObjectURL(blob);
                preview.style.display = 'block';
            });
        }
    }
</script>
@endsection
