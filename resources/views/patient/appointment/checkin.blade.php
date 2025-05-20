@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Patient Check-in Process</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <ul class="nav nav-pills nav-fill" id="checkinSteps" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">
                                                <span class="badge badge-primary mr-1">1</span> Basic Information
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals" aria-selected="false">
                                                <span class="badge badge-primary mr-1">2</span> Vitals
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="medical-history-tab" data-toggle="tab" href="#medical-history" role="tab" aria-controls="medical-history" aria-selected="false">
                                                <span class="badge badge-primary mr-1">3</span> Medical History
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="chief-complaint-tab" data-toggle="tab" href="#chief-complaint" role="tab" aria-controls="chief-complaint" aria-selected="false">
                                                <span class="badge badge-primary mr-1">4</span> Chief Complaint
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">
                                                <span class="badge badge-primary mr-1">5</span> Review
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <form id="patientCheckinForm" action="{{ route('patient.checkin') }}" method="POST">
                                @csrf
                                <div class="tab-content" id="checkinStepsContent">
                                    <!-- Step 1: Basic Information -->
                                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Patient ID</label>
                                                    <input type="text" class="form-control" name="patient_id" readonly value="{{ $appointment->patient->id ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Appointment ID</label>
                                                    <input type="text" class="form-control" name="appointment_id" readonly value="{{ $appointment->id ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Patient Name</label>
                                                    <input type="text" class="form-control" name="patient_name" readonly value="{{ $appointment->patient->name ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="text" class="form-control" name="date_of_birth" readonly value="{{ $appointment->patient->date_of_birth ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contact Number</label>
                                                    <input type="text" class="form-control" name="contact_number" value="{{ $appointment->patient->contact_number ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $appointment->patient->email ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Addresss</label>
                                                    <input type="text" class="form-control" name="address" value="{{ $appointment->patient->insurance ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-primary next-step">Next: Vitals</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2: Vitals -->
                                    <div class="tab-pane fade" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Height (cm)</label>
                                                    <input type="number" step="0.01" class="form-control" name="height" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Weight (kg)</label>
                                                    <input type="number" step="0.01" class="form-control" name="weight" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Body Temperature (°C)</label>
                                                    <input type="number" step="0.1" class="form-control" name="temperature" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Blood Pressure (mmHg)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="systolic_bp" placeholder="Systolic" required>
                                                        <div class="input-group-prepend input-group-append">
                                                            <div class="input-group-text">/</div>
                                                        </div>
                                                        <input type="number" class="form-control" name="diastolic_bp" placeholder="Diastolic" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Pulse Rate (bpm)</label>
                                                    <input type="number" class="form-control" name="pulse_rate" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Respiratory Rate (breaths/min)</label>
                                                    <input type="number" class="form-control" name="respiratory_rate" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Oxygen Saturation (%)</label>
                                                    <input type="number" step="0.1" class="form-control" name="oxygen_saturation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Blood Glucose Level (mg/dL) (if applicable)</label>
                                                    <input type="number" class="form-control" name="blood_glucose">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary next-step">Next: Medical History</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3: Medical History -->
                                    <div class="tab-pane fade" id="medical-history" role="tabpanel" aria-labelledby="medical-history-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Current Medications</label>
                                                    <textarea class="form-control" name="current_medications" rows="3" placeholder="List all current medications including dosage and frequency"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Allergies</label>
                                                    <textarea class="form-control" name="allergies" rows="2" placeholder="List all known allergies including medication, food, and environmental allergies"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Past Medical History</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="diabetes" name="medical_history[]" value="Diabetes">
                                                                <label class="custom-control-label" for="diabetes">Diabetes</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="hypertension" name="medical_history[]" value="Hypertension">
                                                                <label class="custom-control-label" for="hypertension">Hypertension</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="asthma" name="medical_history[]" value="Asthma">
                                                                <label class="custom-control-label" for="asthma">Asthma</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="heart_disease" name="medical_history[]" value="Heart Disease">
                                                                <label class="custom-control-label" for="heart_disease">Heart Disease</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="stroke" name="medical_history[]" value="Stroke">
                                                                <label class="custom-control-label" for="stroke">Stroke</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="cancer" name="medical_history[]" value="Cancer">
                                                                <label class="custom-control-label" for="cancer">Cancer</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="thyroid" name="medical_history[]" value="Thyroid Disorder">
                                                                <label class="custom-control-label" for="thyroid">Thyroid Disorder</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="psychiatric" name="medical_history[]" value="Psychiatric Disorder">
                                                                <label class="custom-control-label" for="psychiatric">Psychiatric Disorder</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="other" name="medical_history[]" value="Other">
                                                                <label class="custom-control-label" for="other">Other</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="otherMedicalHistoryRow" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Specify Other Medical Conditions</label>
                                                    <textarea class="form-control" name="other_medical_history" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Surgical History</label>
                                                    <textarea class="form-control" name="surgical_history" rows="2" placeholder="List any previous surgeries with dates"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Family Medical History</label>
                                                    <textarea class="form-control" name="family_medical_history" rows="2" placeholder="List relevant family medical history"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary next-step">Next: Chief Complaint</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 4: Chief Complaint -->
                                    <div class="tab-pane fade" id="chief-complaint" role="tabpanel" aria-labelledby="chief-complaint-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Chief Complaint</label>
                                                    <textarea class="form-control" name="chief_complaint" rows="3" placeholder="Describe the main reason for today's visit" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Onset of Symptoms</label>
                                                    <input type="date" class="form-control" name="onset_date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Duration of Symptoms</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="duration_value">
                                                        <div class="input-group-append">
                                                            <select class="form-control" name="duration_unit">
                                                                <option value="hours">Hours</option>
                                                                <option value="days">Days</option>
                                                                <option value="weeks">Weeks</option>
                                                                <option value="months">Months</option>
                                                                <option value="years">Years</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Severity (1-10)</label>
                                                    <input type="range" class="form-control-range" name="severity" min="1" max="10" value="5" id="severityRange">
                                                    <div class="d-flex justify-content-between">
                                                        <span>1 (Mild)</span>
                                                        <span id="severityValue">5</span>
                                                        <span>10 (Severe)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Associated Symptoms</label>
                                                    <textarea class="form-control" name="associated_symptoms" rows="2" placeholder="List any other symptoms experienced alongside the main complaint"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Aggravating Factors</label>
                                                    <textarea class="form-control" name="aggravating_factors" rows="2" placeholder="What makes the symptoms worse?"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Relieving Factors</label>
                                                    <textarea class="form-control" name="relieving_factors" rows="2" placeholder="What makes the symptoms better?"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary next-step">Next: Review</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 5: Review -->
                                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="alert alert-info">
                                            <p>Please review all the information below before submitting. You can go back to any section to make changes.</p>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5>Basic Information</h5>
                                            </div>
                                            <div class="card-body" id="reviewBasicInfo">
                                                <!-- Will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5>Vitals</h5>
                                            </div>
                                            <div class="card-body" id="reviewVitals">
                                                <!-- Will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5>Medical History</h5>
                                            </div>
                                            <div class="card-body" id="reviewMedicalHistory">
                                                <!-- Will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5>Chief Complaint</h5>
                                            </div>
                                            <div class="card-body" id="reviewChiefComplaint">
                                                <!-- Will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-success">Submit Check-in</button>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Handle next button clicks
            $('.next-step').click(function() {
            var activeTab = $('.nav-link.active');
            var nextTab = activeTab.parent().next().find('a');
            nextTab.tab('show');
            });

            // Handle previous button clicks
            $('.prev-step').click(function() {
            var activeTab = $('.nav-link.active');
            var prevTab = activeTab.parent().prev().find('a');
            prevTab.tab('show');
            });

            // Show "Other" medical history field when selected
            $('#other').change(function() {
            if($(this).is(':checked')) {
                $('#otherMedicalHistoryRow').show();
            } else {
                $('#otherMedicalHistoryRow').hide();
            }
            });

            // Update severity value display
            $('#severityRange').on('input', function() {
            $('#severityValue').text($(this).val());
            });

            // Populate review tab when it's shown
            $('#review-tab').on('show.bs.tab', function() {
            // Basic Info Review
            var basicInfoHtml = '';
            basicInfoHtml += '<p><strong>Patient ID:</strong> ' + $('input[name="patient_id"]').val() + '</p>';
            basicInfoHtml += '<p><strong>Patient Name:</strong> ' + $('input[name="patient_name"]').val() + '</p>';
            basicInfoHtml += '<p><strong>Date of Birth:</strong> ' + $('input[name="date_of_birth"]').val() + '</p>';
            basicInfoHtml += '<p><strong>Contact Number:</strong> ' + $('input[name="contact_number"]').val() + '</p>';
            basicInfoHtml += '<p><strong>Email:</strong> ' + $('input[name="email"]').val() + '</p>';
            basicInfoHtml += '<p><strong>Address:</strong> ' + $('input[name="address"]').val() + '</p>';
            $('#reviewBasicInfo').html(basicInfoHtml);

            // Vitals Review
            var vitalsHtml = '';
            vitalsHtml += '<p><strong>Height:</strong> ' + $('input[name="height"]').val() + ' cm</p>';
            vitalsHtml += '<p><strong>Weight:</strong> ' + $('input[name="weight"]').val() + ' kg</p>';
            vitalsHtml += '<p><strong>Temperature:</strong> ' + $('input[name="temperature"]').val() + ' °C</p>';
            vitalsHtml += '<p><strong>Blood Pressure:</strong> ' + $('input[name="systolic_bp"]').val() + '/' + $('input[name="diastolic_bp"]').val() + ' mmHg</p>';
            vitalsHtml += '<p><strong>Pulse Rate:</strong> ' + $('input[name="pulse_rate"]').val() + ' bpm</p>';
            vitalsHtml += '<p><strong>Respiratory Rate:</strong> ' + $('input[name="respiratory_rate"]').val() + ' breaths/min</p>';
            vitalsHtml += '<p><strong>Oxygen Saturation:</strong> ' + $('input[name="oxygen_saturation"]').val() + '%</p>';
            if($('input[name="blood_glucose"]').val()) {
                vitalsHtml += '<p><strong>Blood Glucose:</strong> ' + $('input[name="blood_glucose"]').val() + ' mg/dL</p>';
            }
            $('#reviewVitals').html(vitalsHtml);

            // Medical History Review
            var medicalHistoryHtml = '';
            medicalHistoryHtml += '<p><strong>Current Medications:</strong> ' + $('textarea[name="current_medications"]').val() + '</p>';
            medicalHistoryHtml += '<p><strong>Allergies:</strong> ' + $('textarea[name="allergies"]').val() + '</p>';

            var medicalHistoryList = [];
            $('input[name="medical_history[]"]:checked').each(function() {
                medicalHistoryList.push($(this).val());
            });

            medicalHistoryHtml += '<p><strong>Past Medical History:</strong> ' + (medicalHistoryList.length > 0 ? medicalHistoryList.join(', ') : 'None specified') + '</p>';

            if($('#other').is(':checked')) {
                medicalHistoryHtml += '<p><strong>Other Medical Conditions:</strong> ' + $('textarea[name="other_medical_history"]').val() + '</p>';
            }

            medicalHistoryHtml += '<p><strong>Surgical History:</strong> ' + $('textarea[name="surgical_history"]').val() + '</p>';
            medicalHistoryHtml += '<p><strong>Family Medical History:</strong> ' + $('textarea[name="family_medical_history"]').val() + '</p>';

            $('#reviewMedicalHistory').html(medicalHistoryHtml);

            // Chief Complaint Review
            var chiefComplaintHtml = '';
            chiefComplaintHtml += '<p><strong>Chief Complaint:</strong> ' + $('textarea[name="chief_complaint"]').val() + '</p>';
            chiefComplaintHtml += '<p><strong>Onset of Symptoms:</strong> ' + $('input[name="onset_date"]').val() + '</p>';
            chiefComplaintHtml += '<p><strong>Duration:</strong> ' + $('input[name="duration_value"]').val() + ' ' + $('select[name="duration_unit"]').val() + '</p>';
            chiefComplaintHtml += '<p><strong>Severity:</strong> ' + $('input[name="severity"]').val() + '/10</p>';
            chiefComplaintHtml += '<p><strong>Associated Symptoms:</strong> ' + $('textarea[name="associated_symptoms"]').val() + '</p>';
            chiefComplaintHtml += '<p><strong>Aggravating Factors:</strong> ' + $('textarea[name="aggravating_factors"]').val() + '</p>';
            chiefComplaintHtml += '<p><strong>Relieving Factors:</strong> ' + $('textarea[name="relieving_factors"]').val() + '</p>';

            $('#reviewChiefComplaint').html(chiefComplaintHtml);
            });

            // Form validation and submission
            $('#patientCheckinForm').submit(function(e) {
            // Optionally add client-side validation here

            // Allow the form to submit normally to the appointment.checkin route
            // (Remove e.preventDefault() so the form submits)
            });
        });
    </script>
@endsection
