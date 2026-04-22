@extends ('backend.layout.template')
@section('content')

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Kategori Produk</h5>
                        </div>
                        <form action="{{ route('kategori.update', $kategoris->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="validationTextarea" class="form-label">Jenis Produk:</label>
                                                    <div class="col-md-6">
                                                    <select class="mb-0 form-control" name="jenis_produk">
                                                        @foreach ($jenis as $item)
                                                        <option value="{{ $item->id }}" 
                                                        {{ old('jenis_produk', $kategoris->type_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="validationTextarea" class="form-label">Kategori Produk:</label>
                                                    <div class="col-md-6">
                                                <input class="mb-3 form-control" name="nama_kategori" type="text" value="{{ old('name', $kategoris->name) }}">
                                                    @error('nama_kategori')
                                                    <div class="text-danger">{{$message}}</div>
                                                    @enderror
                                            </div>
                                                </div>
                                    </div>
                                    <div class="card-body">
                                    <button type="submit" class="btn btn-success" title="btn btn-success" data-bs-toggle="tooltip">Update</button>
                                    <a href="/dashboard/kategori-product" class="btn btn-danger" title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
                                </div>
                            </div>
                                
@endsection