@extends ('backend.layout.template')
@section('content')
    @if (session('success'))
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
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Ibeka Review</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/dashboard"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('review') }}">Review List</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Review Data</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Add New Review</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('review.update', $review->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="validationTextarea" class="form-label">Reviewer Name:</label>
                                            <div class="col-md-6">
                                                <input class="mb-3 form-control" type="text" name="reviewer_name"
                                                    placeholder="Enter Reviewer Name"
                                                    value="{{ old('name', $review->name) }}">
                                                @error('reviewer_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationTextarea" class="form-label">Text Review:</label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" type="text" name="text_review"
                                                    placeholder="Enter Text Review">{{ old('name', $review->review) }}</textarea>
                                                @error('text_review')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationTextarea" class="form-label">Rating Review:</label>
                                            <div class="col-md-6">
                                                <select class="mb-0 form-control" name="rating_review">
                                                    <option value="" selected disabled>Choose Rating Review</option>
                                                    <option value="0" {{ old('rating_review', $review->star) == 0 ? 'selected' : '' }}>0</option>
                                                    <option value="1" {{ old('rating_review', $review->star) == 1 ? 'selected' : '' }}>1</option>
                                                    <option value="2" {{ old('rating_review', $review->star) == 2 ? 'selected' : '' }}>2</option>
                                                    <option value="3" {{ old('rating_review', $review->star) == 3 ? 'selected' : '' }}>3</option>
                                                    <option value="4" {{ old('rating_review', $review->star) == 4 ? 'selected' : '' }}>4</option>
                                                    <option value="5" {{ old('rating_review', $review->star) == 5 ? 'selected' : '' }}>5</option>
                                                </select>
                                                @error('rating_review')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationTextarea" class="form-label">Date Review:</label>
                                            <div class="col-md-6">
                                                <input class="mb-3 form-control" type="date" name="review_date"
                                                    value="{{ old('review_date', $review->review_date) }}">
                                                @error('review_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                </div>
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success" title="btn btn-success"
                                        data-bs-toggle="tooltip">Save Changes</button>
                                    <a href="{{ route('review') }}" class="btn btn-danger" title="btn btn-danger"
                                        data-bs-toggle="tooltip">Close</a>
                                </div>
                                </form>
                            </div>
                        @endsection
