@extends ('backend.layout.template')
@section('content')
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    @if (session('delete'))
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
                                                <h4 class="m-b-10">Product List In Ikhtiar Berkah</h4>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="index.html">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Product List</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <!-- [ Main Content ] start -->

                            <div class="row mb-3">
                                <div class="col-md-8">
                                </div>
                            </div>
                            <div class="row">
                                <!-- Zero config table start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>Product List</h5>
                                            <a href="{{ route('product.add') }}" class="btn btn-primary">Add Product
                                                Data</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                @php use Illuminate\Support\Str; @endphp
                                                <table id="simpletable" class="table table-striped table-bordered nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Product Name</th>
                                                            <th>Product Type</th>
                                                            <th>Category</th>
                                                            <th>Image</th>
                                                            <!--<th>Detail</th>-->
                                                            <!--<th>Desc</th>-->
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($products as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{Str::limit ($row->name, 10, '...') }}</td>
                                                                <td>{{Str::limit ($row->type_name, 10, '...') }}</td>
                                                                <td>{{ $row->category_name }}</td>
                                                                <td>
                                                                    @if ($row->image_url)
                                                                        @foreach ($row->image_url as $image)
                                                                            <img src="{{ asset('storage/gambar_produk/' . $image) }}" style="max-width: 50px; max-height: 50px;" />
                                                                        @endforeach
                                                                    @else
                                                                        no image
                                                                    @endif
                                                                </td>
                                                                <!--<td>-->
                                                                <!--    @if ($row->detail)-->
                                                                <!--        @foreach ($row->detail as $key => $value)-->
                                                                <!--            </ul> {{ ucfirst($key) }} : {{ $value }}<ul>-->
                                                                <!--        @endforeach-->
                                                                <!--    @else-->
                                                                <!--            no detail-->
                                                                <!--    @endif-->
                                                                <!--</td>-->
                                                               
                                                                <!--<td>{{Str::limit ($row->description, 20, '...') }}</td>-->
                                                                <td>{{ $row->status }}</td>
                                                                <td>
                                                                    <a class="btn drp-icon btn-outline-primary"
                                                                        href="{{ route('product.edit', $row->product_id) }}"
                                                                        type="button"><i class="feather icon-edit"></i></a>
                                                                    <a class="btn drp-icon btn-outline-danger"
                                                                        href="#" type="button"><i
                                                                            data-bs-toggle="modal"
                                                                         data-bs-target="#confirmDeleteModal-{{ $row->product_id }}"
                                                                         type="button"><i
                                                                             class="feather icon-trash"></i></a>
                                                                     <div class="modal fade"
                                                                         id="confirmDeleteModal-{{ $row->product_id }}"
                                                                         tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                         aria-hidden="true">
                                                                         <div class="modal-dialog">
                                                                             <div class="modal-content">
                                                                                 <div class="modal-header">
                                                                                     <h5 class="modal-title">Konfirmasi Hapus
                                                                                     </h5>
                                                                                     <button type="button" class="btn-close"
                                                                                         data-bs-dismiss="modal"
                                                                                         aria-label="Close"></button>
                                                                                 </div>
                                                                                 <div class="modal-body">
                                                                                     Apakah Anda yakin ingin menghapus
                                                                                     produk ini?
                                                                                 </div>
                                                                                 <div class="modal-footer">
                                                                                     <button type="button"
                                                                                         class="btn btn-secondary"
                                                                                         data-bs-dismiss="modal">Batal</button>
                                                                                     <form
                                                                                         action="{{ route('produk.destroy', $row->product_id) }}"
                                                                                         method="POST">
                                                                                         @csrf
                                                                                         @method('DELETE')
                                                                                         <button type="submit"
                                                                                             class="btn btn-danger">Hapus</button>
                                                                                     </form>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
@endsection
