@extends ('backend.layout.template')
@section ('content')

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
                                            <h5 class="m-b-10">Product Category</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html"><i
                                                        class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">Data Table</a></li>
                                            <li class="breadcrumb-item"><a href="#!">Basic Initialization</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->

                        <!-- [ Main Content ] start -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <p class="lead"></p>
                            </div>
                        </div>
                        <div class="row">
  
                        <!-- Zero config table start -->
                         <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Kategori Produk</h5>
                                    <a href="kategori-product/isi-kategori" class="btn btn-primary">Isi Kategori</a>
                                </div>
                                <div class="card-body">
                                    <div class="dt-responsive table-responsive">
                                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>JENIS PRODUK</th>
                                                    <th>KATEGORI PRODUK</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            @foreach ($kategoris as $item)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->type->name}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>
                                                        <a class="btn drp-icon btn-outline-primary" href="{{ route('kategori.edit', $item->id) }}" 
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
                                                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST">
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
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection
<!-- Zero config table end -->