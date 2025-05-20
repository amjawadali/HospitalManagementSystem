@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Row 1 -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC</label>
                                        <input type="number" class="form-control" placeholder="CNIC" name="cnic">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="form-group col-md-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number"
                                            name="contact_number">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Blood Type</label>
                                        <select class="form-control" name="blood_type">
                                            <option value="">Select Blood Type</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Row 3 -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" class="form-control" placeholder="Emergency Contact Name"
                                            name="emergency_contact_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Emergency Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Emergency Contact Number"
                                            name="emergency_contact_number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth">
                                    </div>
                                </div>
                                <!-- Row 4 (emergency + image, optional) -->



                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" name="address" rows="3"></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Allergies</label>
                                        <textarea class="form-control" placeholder="Allergies" name="allergies" rows="3"></textarea>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            placeholder="Confirm Password" required>
                                        <small id="passwordHelp" class="form-text text-danger"
                                            style="display:none;">Passwords do not match.</small>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-4">
                                        <label>Profile Image</label>
                                        <input type="file" class="form-control" name="profile_image" id="profile_image">
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
    <!-- Include external JS file -->
    <script src="{{ asset('admin/js/password_confirm.js') }}"></script>
@endsection
