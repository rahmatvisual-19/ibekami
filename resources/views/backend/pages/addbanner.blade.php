@extends('backend.layout.template')

@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            border-radius: 7px;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

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
                                                <h3 class="m-b-10">Banner in Ibeka</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner
                                                        list</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Add New Media</a>
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
                                            <h4>Add New Media (Video/Image)</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('banner.add') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Upload Video or Image</label>
                                                    <input type="file" name="banner_picture" class="form-control"
                                                        aria-label="file example" accept="image/*,video/mp4,video/webm">
                                                    <em style="color: red; font-size: 13px;">Make sure the resolution is vertical (9:16) like 720x1280px for the best result.</em>
                                                    @error('banner_picture')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Save Data</button>
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
@endsection