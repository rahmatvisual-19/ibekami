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
                                                <li class="breadcrumb-item"><a href="/dashboard"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/dashboard/partnership">Daftar Partnership</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Daftar Partner</a>
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
                                            <h5>Edit Daftar Partner</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('partner.update', $partner->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <label class="col-sm-3 col-form-label">Product Type:</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control" name="category" required>
                                                        <option value="" selected disabled>-- Select Product Type --</option>
                                                        <option value="BUMN" {{ $partner->category === 'BUMN' ? 'selected' : '' }}>BUMN</option>
                                                        <option value="Organization" {{ $partner->category === 'Organization' ? 'selected' : '' }}>Organization</option>
                                                    </select>
                                                </div>
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Gambar Logo Partner</label>
                                                    <input type="file"
                                                        class="form-control @error('gambar_partner') is-invalid @enderror"
                                                        id="gambar_partner" name="gambar_partner" onchange="previewImage()"
                                                        accept="image/*" aria-label="file example">
                                                    @error('gambar_partner')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    @if ($partner->image_url)
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="{{ asset('storage/gambar_partner/' . $partner->image_url) }}"
                                                            alt="Preview Gambar">
                                                    @else
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="" alt="Preview Gambar" style="display: none;">
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Simpan Data</button>
                                                </div>
                                            </form>

                                            <script>
                                                function previewImage() {
                                                    const input = document.querySelector('#gambar_partner');
                                                    const imgPreview = document.querySelector('#img-preview');

                                                    if (input.files && input.files[0]) {
                                                        const reader = new FileReader();

                                                        reader.onload = function(e) {
                                                            imgPreview.style.display = 'block';
                                                            imgPreview.src = e.target.result;
                                                        };

                                                        reader.readAsDataURL(input.files[0]);
                                                    } else {
                                                        // Menampilkan gambar lama jika ada
                                                        const oldImage = "{{ asset('storage/gambar_partner/' . $partner->image_url) }}";
                                                        imgPreview.style.display = 'block';
                                                        imgPreview.src = oldImage;
                                                    }
                                                }
                                            </script>
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
