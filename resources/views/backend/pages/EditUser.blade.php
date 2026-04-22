@extends ("backend.layout.template")
@section("content") 

  <section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#!">Daftar User</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Profile</a></li>
                        </ul>
                        <div class="card">
                            <div class="card-header">
                                <h5>Edit Profile</h5>
                            </div>
                            <form action="{{ route('user.update', $users->username) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <form method="POST" action="{{ url(path: 'update-profile') }}">
@csrf <!-- Pastikan ada CSRF token untuk Laravel -->
<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" name="username_user" required  value="{{ old('username', $users->username) }}">
    @error('username_user')
    <div class="text-danger">{{$message}}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Name Admin</label>
    <input type="text" class="form-control" name="name_user"  required value="{{ old('name', $users->name) }}">
    @error('name_user')
    <div class="text-danger">{{$message}}</div>
    @enderror
    </div>
    
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" class="form-control" name="password_user" minlength="8" maxlength="30" class="form-control" id="exampleInputPassword1"placeholder="Password"><small>Your password must be between 8 and 30 characters.</small>
        @error ('password_user')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-footer">
    <button type="submit" class="btn btn-success" title="btn btn-success" data-bs-toggle="tooltip">Update</button>
    <a href="/dashboard/Daftar-User" class="btn btn-danger" title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
    </div>
</form>
</div>
                            
@endsection