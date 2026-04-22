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
                                                <h3 class="m-b-10">Jenis Produk Ikhtiar Berkah</h3>
                                            </div>
                                            <form action="{{ route('jenis.update', $jeniss->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="/jenis-produk">Daftar Jenis Produk</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Jenis Produk Plakat</a>
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
                                            <h5>Edit Jenis Produk</h5> 
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Jenis Produk</label>
                                                        <div class="col-md-6">
                                                            <input class="mb-3 form-control" name="nama_jenis" type="text"
                                                                placeholder="" value="{{ old('name', $jeniss->name) }}">
                                                                @error('nama_jenis')
                                                                <div class="text-danger">{{$message}}</div>
                                                                @enderror
                                                        </div>
                                                
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Gambar Jenis Produk</label>
                                                    <input type="file" class="form-control @error('gambar_jenis') is-invalid @enderror" 
                                                           id="gambar_jenis" name="gambar_jenis" onchange="previewImage()">
                                                    
                                                    <div class="mb-2">
                                                        @if($jeniss->image_url)
                                                            <img id="img-preview" class="img-preview img-fluid" style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                                 src="{{ asset('storage/gambar_jenis/' . $jeniss->image_url) }}" alt="Preview Gambar">
                                                        @else
                                                            <img id="img-preview" class="img-preview img-fluid" style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                                 src="" alt="Preview Gambar" style="display: none;">
                                                        @endif
                                                    </div>
                                                    
                                                    
                                                    
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success" title="btn btn-success" data-bs-toggle="tooltip">Update</button>
                                    <a href="/dashboard/jenis-produk" class="btn btn-danger" title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
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
            const input = document.querySelector('#gambar_jenis');
            const imgPreview = document.querySelector('#img-preview');
        
            if (input.files && input.files[0]) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    imgPreview.style.display = 'block';
                    imgPreview.src = e.target.result;
                };
        
                reader.readAsDataURL(input.files[0]);
            }
        
     else {
      // Menampilkan gambar lama jika ada
      const oldImage = "{{ asset('storage/gambar_jenis/' . $jeniss->image_url) }}";
      imgPreview.style.display = 'block';
      imgPreview.src = oldImage;
    }
  }

</script>
@endsection
