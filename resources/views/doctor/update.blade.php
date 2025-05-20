@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('doctor.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Row 1 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name"
                                            value="{{ old('name', $doctor->name) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            value="{{ old('email', $doctor->email) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number"
                                            name="contact_number"
                                            value="{{ old('contact_number', $doctor->contact_number) }}">
                                    </div>
                                </div>
                                <!-- Row 2 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Department</label>
                                        <select class="form-control" name="department_id">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Designation</label>
                                        <select class="form-control" name="designation_id">
                                            <option value="">Select Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id', $doctor->designation_id) == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>License Number</label>
                                        <input type="text" class="form-control" placeholder="License Number"
                                            name="license_number"
                                            value="{{ old('license_number', $doctor->license_number) }}">
                                    </div>
                                </div>
                                <!-- Row 3 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Joining Date</label>
                                        <input type="date" class="form-control" name="joining_date"
                                            value="{{ old('joining_date', $doctor->joining_date) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Created At</label>
                                        <input type="text" class="form-control" name="created_at"
                                            value="{{ old('created_at', $doctor->created_at) }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Qualifications</label>
                                        <textarea class="form-control" placeholder="Qualifications" name="qualifications" rows="3">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                                    </div>
                                </div>
                                <!-- Row 4 -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Biography</label>
                                        <textarea class="form-control" placeholder="Biography" name="biography" rows="4">{{ old('biography', $doctor->biography) }}</textarea>
                                    </div>

                                </div>
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Profile Image</label>
                                        <div class="mb-2">
                                            <img id="currentImage"
                                                src="{{ $doctor->profile_image ? asset('/' . $doctor->profile_image) : asset('images/doctors/default.png') }}"
                                                alt="Doctor Image" class="img-thumbnail" width="100">
                                        </div>
                                        <input type="file" class="form-control" name="profile_image"
                                            id="profile_image" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="saveDoctorBtn"
                                        class="btn btn-primary m-t-15 waves-effect">Save</button>
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
    <script src="{{ asset('admin/js/image_preview.js') }}"></script>
@endsection
