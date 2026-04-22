@extends ('backend.layout.template')
@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        
                    <div class="card">
                        <div class="card-header">
                            <h5>Kategori Produk</h5>
                        </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="validationTextarea" class="form-label">Jenis Produk:</label>
                                <div class="col-md-6">
                                    <select class="mb-0 form-control" name="jenis_produk">
                                    <option value="" selected disabled>-- Pilih Jenis Produk --</option>
                                        @foreach ($jenis as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_produk')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="validationTextarea" class="form-label">Kategori Produk:</label>
                                <div class="col-md-6">
                                    <input class="mb-3 form-control" type="text" name="nama_kategori" placeholder="Masukkan Nama Kategori">
                                    @error('nama_kategori')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-success" title="btn btn-success" data-bs-toggle="tooltip">Save Changes</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-danger" title="btn btn-danger" data-bs-toggle="tooltip">Close</a>
                        </div>
                    </form>
                </div>
@endsection