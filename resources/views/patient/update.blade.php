@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('patient.update', $patient->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Row 1 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name"
                                            value="{{ old('name', $patient->name) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            value="{{ old('email', $patient->email) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number"
                                            name="contact_number"
                                            value="{{ old('contact_number', $patient->contact_number) }}">
                                    </div>
                                </div>
                                <!-- Row 2 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male"
                                                {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other"
                                                {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth"
                                            value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Blood Type</label>
                                        <select class="form-control" name="blood_type">
                                            <option value="">Select Blood Type</option>
                                            <option value="A+"
                                                {{ old('blood_type', $patient->blood_type) == 'A+' ? 'selected' : '' }}>A+
                                            </option>
                                            <option value="A-"
                                                {{ old('blood_type', $patient->blood_type) == 'A-' ? 'selected' : '' }}>A-
                                            </option>
                                            <option value="B+"
                                                {{ old('blood_type', $patient->blood_type) == 'B+' ? 'selected' : '' }}>B+
                                            </option>
                                            <option value="B-"
                                                {{ old('blood_type', $patient->blood_type) == 'B-' ? 'selected' : '' }}>B-
                                            </option>
                                            <option value="AB+"
                                                {{ old('blood_type', $patient->blood_type) == 'AB+' ? 'selected' : '' }}>
                                                AB+</option>
                                            <option value="AB-"
                                                {{ old('blood_type', $patient->blood_type) == 'AB-' ? 'selected' : '' }}>
                                                AB-</option>
                                            <option value="O+"
                                                {{ old('blood_type', $patient->blood_type) == 'O+' ? 'selected' : '' }}>O+
                                            </option>
                                            <option value="O-"
                                                {{ old('blood_type', $patient->blood_type) == 'O-' ? 'selected' : '' }}>O-
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Row 3 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" class="form-control" placeholder="Emergency Contact Name"
                                            name="emergency_contact_name"
                                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Emergency Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Emergency Contact Number"
                                            name="emergency_contact_number"
                                            value="{{ old('emergency_contact_number', $patient->emergency_contact_number) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date"
                                            value="{{ old('registration_date', $patient->registration_date) }}">
                                    </div>
                                </div>
                                <!-- Row 4 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" name="address" rows="3">{{ old('address', $patient->address) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Allergies</label>
                                        <textarea class="form-control" placeholder="Allergies" name="allergies" rows="3">{{ old('allergies', $patient->allergies) }}</textarea>
                                    </div>


                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <img id="currentImage"
                                                    src="{{ $patient->profile_image ? asset('/' . $patient->profile_image) : asset('images/patients/default.png') }}"
                                                    alt="patient Image" class="img-thumbnail" width="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="profile_image"
                                                    id="profile_image" accept="image/*" onchange="previewImage(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="savePatientBtn"
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
