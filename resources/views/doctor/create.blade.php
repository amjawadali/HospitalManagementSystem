@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('doctor.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Row 1 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number" name="contact_number">
                                    </div>
                                </div>
                                <!-- Row 2 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Department</label>
                                        <select class="form-control" name="department_id">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Designation</label>
                                        <select class="form-control" name="designation_id">
                                            <option value="">Select Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>License Number</label>
                                        <input type="text" class="form-control" placeholder="License Number" name="license_number">
                                    </div>
                                </div>
                                <!-- Row 3 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Qualifications</label>
                                        <input type="text" class="form-control" placeholder="Qualifications" name="qualifications">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Joining Date</label>
                                        <input type="date" class="form-control" name="joining_date">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Created At</label>
                                        <input type="date" class="form-control" name="created_at">
                                    </div>
                                </div>
                                <!-- Row 4 -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
                                        <small id="passwordHelp" class="form-text text-danger" style="display:none;">Passwords do not match.</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Biography</label>
                                        <textarea class="form-control" placeholder="Biography" name="biography" rows="3"></textarea>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Profile Image</label>
                                        <input type="file" class="form-control" name="profile_image" id="profile_image">
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="saveDoctorBtn" class="btn btn-primary m-t-15 waves-effect">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <!-- Include external JS file -->
    <script src="{{ asset('admin/js/password_confirm.js') }}"></script>
@endsection
