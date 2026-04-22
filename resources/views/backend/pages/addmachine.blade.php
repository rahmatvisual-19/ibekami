@extends('backend.layout.template')

@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;

            border-radius: 7px;
            size: 15px;
        }

        input[type="text"] {
            width: 100;
            padding: 10px;
            margin: auto;

            border-radius: 5px;
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
                                                <h3 class="m-b-10">Machine in Ibeka</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('machine.index') }}">Machine
                                                        list</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Add New Machine</a>
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
                                            <h4>Add New Machine</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Machine Title</label>
                                                    <input type="text" name="machine_title" class="form-control"
                                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                                        placeholder="Fill in the banner title here">
                                                    @error('machine_title')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
              
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Machine Picture</label>
                                                    <input type="file" name="machine_picture" class="form-control"
                                                        aria-label="file example" accept="image/*"><em property="italic" style="color: red; size: 5px;">Make sure the image resolution is 1280px:720px</em>
                                                    @error('machine_picture')
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
