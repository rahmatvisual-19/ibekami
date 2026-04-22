@extends("backend.layout.template")
@section("content")

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Breadcrumb -->
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Daftar User</a></li>
                            <li class="breadcrumb-item active">Create Admin</li>
                        </ul>

                        <!-- Card -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Create Admin Account</h5>
                            </div>

                            <form action="{{ route('user.add') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username_user" class="form-control">
                                        @error('username_user')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name_user" class="form-control">
                                        @error('name_user')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password_user" class="form-control" placeholder="Password">
                                        <small class="form-text text-muted">
                                            Your password must be between 8 and 30 characters.
                                        </small>
                                        @error('password_user')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection