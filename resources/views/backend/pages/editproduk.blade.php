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
                                                    <h3 class="m-b-10">Edit Product - {{ $product->name }}</h3>
                                                </div>
                                                <ul class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="/"><i
                                                                class="feather icon-home"></i></a></li>
                                                    <li class="breadcrumb-item"><a href="/dashboard/daftar-product">Product
                                                            List</a></li>
                                                    <li class="breadcrumb-item"><a href="#!">Edit Product</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ breadcrumb ] end -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Edit Product Data</h5>
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
                                        <form action="{{ route('product.update', $product->product_id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Type:</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control" name="jenis_produk" id="jenis_produk">
                                                        <option value="" disabled>-- Pilih Jenis Produk --</option>
                                                        @foreach ($jenis as $item)
                                                            <option value="{{ $item->id }}" {{ $product->product_type == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('jenis_produk')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Category Product:</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control" name="kategori_produk" id="kategori_produk">
                                                        <option value="" disabled>-- Pilih Kategori Produk --</option>
                                                        @foreach ($category as $item)
                                                            <option value="{{ $item->id }}" 
                                                                {{ $product->category_type == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('kategori_produk')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Name:</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="nama_produk"
                                                        value="{{ old('nama_produk', $product->name) }}"
                                                        placeholder="Product Name">
                                                    @error('nama_produk')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Description:</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="deskripsi_produk"
                                                        value="{{ old('deskripsi_produk', $product->description) }}"
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
                                                        <option value="" disabled>-- Select Product Status --</option>
                                                        <option value="Aktif" {{ $product->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Tidak Aktif" {{ $product->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Details:</label>
                                                <div class="col-sm-5">
                                                    <div id="detailsContainer">
                                                        <!-- Existing details will be populated here -->
                                                        @if(isset($product->detail) && !empty($product->detail))
                                                            @foreach($product->detail as $key => $value)
                                                                <div class="detail-group input-group mb-2" id="detail_{{ $loop->index }}">
                                                                    <input type="text" class="form-control" name="details[detail_{{ $loop->index }}][key]"
                                                                        value="{{ $key }}" placeholder="Detail name (e.g., Color)" required>
                                                                    <input type="text" class="form-control" name="details[detail_{{ $loop->index }}][value]"
                                                                        value="{{ $value }}" placeholder="Detail value (e.g., Red)" required>
                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-danger remove-detail">
                                                                            <i class="feather icon-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" id="addDetailBtn" class="btn btn-sm btn-secondary mt-2">
                                                        <i class="feather icon-plus"></i> Add Detail
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Images:</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="gambar_produk" name="gambar_produk[]" accept="image/*" multiple>
                                                    <em style="color: red; size: 5px;">Pastikan ukuran gambar sudah 1:1 dengan minimal 800px:800px</em>
                                                    <div id="previewContainer" class="d-flex flex-wrap mt-3"></div>
                                                    <input type="hidden" name="remaining_images" id="remainingImages"
                                                        value="{{ json_encode(array_map('basename', $product->image_url)) }}">
                                                </div>
                                            </div>
                                            <div class="justify-content-between" style="margin-top: 10px;">
                                                <button type="submit" class="btn btn-primary" style="border: none;">
                                                    Update Product Data
                                                </button>
                                                <a href="{{ route('product.index') }}" class="btn btn-light text-muted">
                                                    Cancel
                                                </a>
                                            </div>
                                        </form>

                                        <script>
                                            const productType = document.getElementById('jenis_produk');
                                            const categoryProduct = document.getElementById('kategori_produk');

                                            function validateFields() {
                                                categoryProduct.disabled = !productType.value;
                                            }

                                            productType.addEventListener('change', validateFields);
                                            validateFields();
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    @endsection