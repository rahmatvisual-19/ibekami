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
    </style>

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Partnership Ikhtiar Berkah</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/jenis-produk">Daftar Partnership</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Tambah Daftar Partner</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Tambah Daftar Partner</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('partner.add') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <label class="col-sm-3 col-form-label">Product Type:</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control" name="category" required>
                                                        <option value="" selected disabled>-- Select Product Type --</option>
                                                        <option value="BUMN">BUMN</option>
                                                        <option value="Organization">Organization</option>
                                                    </select>
                                                </div>
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Gambar Logo Partner</label>
                                                    <input type="file" name="gambar_partner" id="gambar_partner" class="form-control"
                                                        accept="image/*" aria-label="file example" onchange="previewPartner()">
                                                    @error('gambar_partner')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="img-preview-partner" style="width:150px;height:150px;object-fit:contain;display:none;border:1px solid #ddd;" alt="Preview">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function previewPartner() {
        var input = document.getElementById('gambar_partner');
        var preview = document.getElementById('img-preview-partner');
        if (input.files && input.files[0]) {
            WebPConverter.convertToWebP(input.files[0]).then(function(blob) {
                preview.src = URL.createObjectURL(blob);
                preview.style.display = 'block';
            });
        }
    }
</script>
@endsection
