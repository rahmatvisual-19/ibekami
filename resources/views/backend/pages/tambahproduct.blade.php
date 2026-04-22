@extends('backend.layout.template')
@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            border: 1px solid;
            border-radius: 7px;
            size: 15px;
        }

        input[type="text"] {
            width: 100;
            padding: 10px;
            margin: auto;
            border: 1px solid;
            border-radius: 5px;
        }

        image {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <style>
        #preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <style>
        #previewContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-box {
            width: 120px;
            height: 120px;
            border: 2px dashed #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f8f8f8;
            position: relative;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
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
                                                <h3 class="m-b-10">Product List In Ikhtiar Berkah</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/dashboard/daftar-product">Product List</a>
                                                <li class="breadcrumb-item"><a href="#!">Add Product Data</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Product Data</h5>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route("product.tambah") }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product Type:</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="jenis_produk" id="jenis_produk" required>
                                                    <option value="" selected disabled>-- Pilih Jenis Produk --</option>
                                                    @foreach ($jenis as $item)
                                                        <option value="{{ $item->id }}" data-categories='@json($item->categories)'>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Category Product:</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="kategori_produk" id="kategori_produk" required disabled>
                                                    <option value="" selected disabled>-- Pilih Kategori Produk --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product
                                                Name:</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="nama_produk"
                                                    placeholder="Product Name">
                                                @error('nama_produk')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product
                                                Description :</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="deskripsi_produk"
                                                    placeholder="Product Description">
                                                @error('deskripsi_produk')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product Status:</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="" selected disabled>-- Select Product Status --
                                                    </option>
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product Details:</label>
                                            <div class="col-sm-5">
                                                <div id="detailsContainer">
                                                </div>
                                                <button type="button" id="addDetailBtn" class="btn btn-sm btn-secondary mt-2">
                                                    <i class="feather icon-plus"></i> Add Detail
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product
                                                Picture:</label>
                                            <div class="col-sm-5">
                                                <input type="file" class="form-control" id="gambar_produk"
                                                    name="gambar_produk[]" accept="image/*" multiple>
                                                <em property="italic" style="color: red; size: 5px;">Pastikan ukuran
                                                    gambar sudah 1:1 dengan minimal 800px:800px</em>
                                            </div>
                                        </div>
                                        <div id="previewContainer"></div>
                                        <div class="justify-content-between" style="margin-top: 10px;">
                                            <button type="submit" class="btn btn-primary" class="col-sm-12"
                                                style="border: none;">
                                                Save Product Data<strong> </strong>
                                            </button>
                                            <button type="reset" class="btn btn-light text-muted">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                                const jenisSelect = document.getElementById('jenis_produk');
                                                const kategoriSelect = document.getElementById('kategori_produk');

                                                jenisSelect.addEventListener('change', function () {
                                                    kategoriSelect.innerHTML = '<option value="" selected disabled>-- Pilih Kategori Produk --</option>';
                                                    kategoriSelect.disabled = true;

                                                    const selectedOption = this.options[this.selectedIndex];
                                                    if (selectedOption.value) {
                                                        const categories = JSON.parse(selectedOption.getAttribute('data-categories'));

                                                        categories.forEach(category => {
                                                            const option = new Option(category.name, category.id);
                                                            kategoriSelect.add(option);
                                                        });

                                                        kategoriSelect.disabled = false;
                                                    }
                                                });
                                            });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection