    @extends('layout.main')

    @section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Update User</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <input value="{{ $user->name }}" type="text" class="form-control"
                                        placeholder="Full Name" name="name">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </div>
                                    </div>
                                    <input value="{{ $user->username }}" type="text" class="form-control"
                                        placeholder="Username" name="username">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input value="{{ $user->email }}" type="email" class="form-control" placeholder="Email"
                                        name="email">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Role</label>
                                <select class="form-control" name="role_id">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Department</label>
                                <select class="form-control" name="department_id">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ $department->id == $user->department_id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Designation</label>
                                <select class="form-control" name="designation_id">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ $designation->id == $user->designation_id ? 'selected' : '' }}>
                                            {{ $designation->designation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-group">
                                    <img id="currentImage" src="{{ $user->user_image ? asset('/' . $user->user_image) : asset('images/users/default.png') }}" alt="User Image"
                                        class="img-thumbnail" width="100">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="user_image" id="user_image" accept="image/*" onchange="previewImage(event)">
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                        </div>    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script src="{{ asset('admin/js/image_preview.js') }}"></script>
    @endsection
