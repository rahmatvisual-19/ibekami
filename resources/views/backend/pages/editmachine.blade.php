@extends('backend.layout.template')

@section('content')
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
                                                <h3 class="m-b-10">Jenis Mesin Ikhtiar Berkah</h3>
                                            </div>
                                            <form action="{{route('machine.update', $machine->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/jenis-produk">Daftar Jenis Mesin</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Jenis Mesin</a>
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
                                            <h5>Edit Mesin</h5> 
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Mesin</label>
                                                        <div class="col-md-6">
                                                            <input class="mb-3 form-control" name="nama_mesin" type="text"
                                                                placeholder="" value="{{ old('name', $machine->title) }}">
                                                                @error('nama_mesin')
                                                                <div class="text-danger">{{$message}}</div>
                                                                @enderror
                                                        </div>
                                                
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Gambar Mesin</label>
                                                    <input type="file" class="form-control @error('gambar_mesin') is-invalid @enderror" 
                                                           id="gambar_mesin" name="gambar_mesin" onchange="previewImage()">
                                                    
                                                    <div class="mb-2">
                                                        @if($machine->image_url)
                                                            <img id="img-preview" class="img-preview img-fluid" style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                                 src="{{ asset('storage/machine_picture/' . $machine->image_url) }}" alt="Preview Gambar">
                                                        @else
                                                            <img id="img-preview" class="img-preview img-fluid" style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                                 src="" alt="Preview Gambar" style="display: none;">
                                                        @endif
                                                    </div>
                                                    
                                                    
                                                    
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success" title="btn btn-success" data-bs-toggle="tooltip">Update</button>
                                    <a href="{{route('machine.index')}}" class="btn btn-danger" title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
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
    <script>
  function previewImage() {
            const input = document.querySelector('#gambar_mesin');
            const imgPreview = document.querySelector('#img-preview');

            if (input.files && input.files[0]) {
                WebPConverter.convertToWebP(input.files[0]).then(function(blob) {
                    imgPreview.style.display = 'block';
                    imgPreview.src = URL.createObjectURL(blob);
                });
            } else {
                const oldImage = "{{ asset('storage/machine_picture/' . $machine->image_url) }}";
                imgPreview.style.display = 'block';
                imgPreview.src = oldImage;
            }
        }
</script>
@endsection
