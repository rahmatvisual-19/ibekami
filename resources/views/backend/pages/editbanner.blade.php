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
                                                <h3 class="m-b-10">Banner Ibeka</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner
                                                        List</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Media</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Edit Media (Video/Image)</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('banner.update', $banner->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-file mb-3">
                                                    <div class="form-file mb-3">
                                                        <label class="form-label">Update Video or Image</label>
                                                        <input type="file" id="banner_picture" name="banner_picture" class="form-control @error('banner_picture') is-invalid @enderror"
                                                            aria-label="file example" accept="image/*,video/mp4,video/webm" onchange="previewMedia()">
                                                        <em style="color: red; font-size: 13px;">Make sure the resolution is vertical (9:16) like 720x1280px for the best result.</em>
                                                        @error('banner_picture')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4 mt-3">
                                                        <label class="form-label d-block">Current Media Preview:</label>
                                                        @php
                                                            $ext = strtolower(pathinfo($banner->image_url, PATHINFO_EXTENSION));
                                                            $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                                                        @endphp
                                                        
                                                        <img id="img-preview" class="img-preview img-fluid rounded shadow-sm"
                                                            style="max-width: 250px; max-height: 400px; object-fit: contain; {{ $isVideo ? 'display: none;' : 'display: block;' }}"
                                                            src="{{ $banner->image_url ? asset('storage/banner_picture/' . $banner->image_url) : '' }}"
                                                            alt="Preview Gambar">
                                                            
                                                        <video id="video-preview" class="rounded shadow-sm"
                                                            style="max-width: 250px; max-height: 400px; {{ $isVideo ? 'display: block;' : 'display: none;' }}" 
                                                            src="{{ $isVideo ? asset('storage/banner_picture/' . $banner->image_url) : '' }}" 
                                                            controls autoplay loop muted></video>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success"
                                                            title="btn btn-success" data-bs-toggle="tooltip">Update Data</button>
                                                        <a href="{{ route('banner.index') }}" class="btn btn-danger"
                                                            title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
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
    <script>
        function previewMedia() {
            const input = document.querySelector('#banner_picture');
            const imgPreview = document.querySelector('#img-preview');
            const videoPreview = document.querySelector('#video-preview');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (file.type.startsWith('video/')) {
                        imgPreview.style.display = 'none';
                        videoPreview.style.display = 'block';
                        videoPreview.src = e.target.result;
                    } else {
                        videoPreview.style.display = 'none';
                        imgPreview.style.display = 'block';
                        imgPreview.src = e.target.result;
                    }
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection