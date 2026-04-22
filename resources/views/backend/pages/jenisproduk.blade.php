@extends('backend.layout.template')
@section('content')

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@if(session('delete'))
    <script>
        alert("{{ session('delete') }}");
    </script>
@endif

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
                                                <h4 class="m-b-10">Daftar Jenis Produk Ikhtiar Berkah</h4>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Daftar Jenis Produk</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <!-- [ Main Content ] start -->
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <p class="lead">Types Product</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header"
                                            style="display: flex; justify-content: space-between; align-items: center">
                                            <h4>Daftar Jenis Produk yang Tersedia</h4>
                                            <div class="card-tools">
                                                <button style="float: right; padding: 10px 20px" type="button"
                                                    onclick="location.href='jenis-produk/add'" class="btn btn-primary"
                                                    title="btn btn-primary">Tambah Jenis</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Types Product</th> 
                                                            <th>image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($jeniss as $item)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td>
                                                                @if ($item->image_url)
                                                                    <img src="{{ asset('storage/gambar_jenis/' . $item->image_url) }}" alt="{{ $item->name }}" style="max-width: 150px; max-height: 150px;">
                                                                @else
                                                                    <span>No Image</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a class="btn drp-icon btn-outline-primary" href="{{ route('jenis.edit', $item->id) }}" 
                                                                type="button"><i class="feather icon-edit"></i></a>
                                                                <a class="btn drp-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $item->id }}"
                                                                    type="button"><i class="feather icon-trash"></i></a>
                                                                    <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Apakah Anda yakin ingin menghapus kategori ini?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                    <form action="{{ route('jenis.destroy', $item->id) }}" method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </td>
                                                        </tr>
                                                    </tbody> 
                                                        @endforeach
                                                </table>
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
