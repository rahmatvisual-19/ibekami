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
                                                <h3 class="m-b-10">Ibeka Banner List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Banner List</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Banner List</h4>
                                            <a href="{{ route('banner.add') }}" class="btn btn-primary">Add New Banner</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Media (Image/Video)</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($banner as $row)
                                                            <tr>
                                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                                <td>
                                                                    @if($row->image_url)
                                                                        @php
                                                                            $ext = strtolower(pathinfo($row->image_url, PATHINFO_EXTENSION));
                                                                        @endphp
                                                                        
                                                                        @if(in_array($ext, ['mp4', 'webm', 'ogg']))
                                                                            <video src="{{ asset('storage/banner_picture/' . $row->image_url) }}" style="max-width: 150px; max-height: 150px; border-radius: 5px;" autoplay loop muted playsinline></video>
                                                                        @else
                                                                            <img src="{{ asset('storage/banner_picture/' . $row->image_url) }}" alt="Banner" style="max-width: 150px; max-height: 150px; border-radius: 5px; object-fit: cover;">
                                                                        @endif
                                                                    @else
                                                                        <span>No Media</span>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle">
                                                                    <a class="btn drp-icon btn-outline-primary"
                                                                        href="{{ route('banner.edit', $row->id) }}"
                                                                        type="button"><i class="feather icon-edit"></i></a>
                                                                    <a class="btn drp-icon btn-outline-danger"
                                                                        href="#" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#confirmDeleteModal-{{ $row->id }}"
                                                                            type="button"><i
                                                                                class="feather icon-trash"></i></a>
                                                                    <div class="modal fade"
                                                                        id="confirmDeleteModal-{{ $row->id }}"
                                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Confirm Delete
                                                                                    </h5>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Are you sure to delete this banner?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                                    <form
                                                                                        action="{{ route('banner.destroy', $row->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger">Delete</button>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection