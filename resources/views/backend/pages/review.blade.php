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
                                                <h3 class="m-b-10">Ibeka Review List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/dashboard">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Review List</a></li>
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
                                            <h5>Review List</h5>
                                            <a href="{{ route('review.add') }}" class="btn btn-primary">Add New Review</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Reviewer Name</th>
                                                            <th>The Review</th>
                                                            <th>Stars</th>
                                                            <th>Review Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reviews as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->name }}</td>
                                                                <td>{{ $row->review }}</td>
                                                                <td>{{ $row->star }}</td>
                                                                <td>{{ $row->review_date }}</td>
                                                                <td>
                                                                    <a class="btn drp-icon btn-outline-primary"
                                                                        href="{{ route('review.edit', $row->id) }}"
                                                                        type="button"><i class="feather icon-edit"></i></a>
                                                                    <a class="btn drp-icon btn-outline-danger"
                                                                        href="#" type="button"><i
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
                                                                                    Are you sure to delete this review?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                                    <form
                                                                                        action="{{ route('review.destroy', $row->id) }}"
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
                            @endsection
