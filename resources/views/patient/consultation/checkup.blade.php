@extends('layout.main')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Patient Consultation</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">Appointment Date: {{ date('d M Y', strtotime($checkin->appointment->appointment_date)) }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Patient Information -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                @if($checkin->appointment->patient->profile_image)
                                    <img src="{{ asset($checkin->appointment->patient->profile_image) }}" alt="Patient" class="rounded-circle mb-3" width="120" height="120">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Patient" class="rounded-circle mb-3" width="120">
                                @endif
                                <h5>{{ $checkin->appointment->patient->name }}</h5>
                                <div class="text-muted">Patient ID: {{ $checkin->appointment->patient->patient_code }}</div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="text-small text-muted">Age/Gender</div>
                                        <div>
                                            @if($checkin->appointment->patient->date_of_birth)
                                                {{ \Carbon\Carbon::parse($checkin->appointment->patient->date_of_birth)->age }} years /
                                            @endif
                                            {{ ucfirst($checkin->appointment->patient->gender) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="text-small text-muted">Blood Type</div>
                                        <div>{{ $checkin->appointment->patient->blood_type ?? 'Not specified' }}</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="text-small text-muted">Contact</div>
                                        <div>{{ $checkin->appointment->patient->contact_number }}</div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="text-small text-muted">Reason for Visit</div>
                                        <div>{{ $checkin->appointment->reason_for_visit }}</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="text-small text-muted">Status</div>
                                        <div><span class="badge badge-warning">{{ ucfirst($checkin->status) }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Vitals and Details Tabs -->
                        <ul class="nav nav-tabs" id="patientDetailTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-selected="true">Vitals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="complaint-tab" data-toggle="tab" href="#complaint" role="tab" aria-selected="false">Chief Complaint</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-selected="false">Medical History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="conditions-tab" data-toggle="tab" href="#conditions" role="tab" aria-selected="false">Medical Conditions</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="patientDetailTabsContent">
                            <!-- Vitals Tab -->
                            <div class="tab-pane fade show active" id="vitals" role="tabpanel">
                                <div class="row pt-3">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Height/Weight</h6>
                                                <h5>{{ $checkin->vitals->height ?? 'N/A' }} cm / {{ $checkin->vitals->weight ?? 'N/A' }} kg</h5>
                                                <div class="small">BMI: {{ $checkin->vitals->bmi ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Blood Pressure</h6>
                                                <h5>{{ $checkin->vitals->systolic_bp ?? 'N/A' }}/{{ $checkin->vitals->diastolic_bp ?? 'N/A' }}</h5>
                                                <div class="small">mmHg</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Temperature</h6>
                                                <h5>{{ $checkin->vitals->temperature ?? 'N/A' }}</h5>
                                                <div class="small">°C</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Pulse Rate</h6>
                                                <h5>{{ $checkin->vitals->pulse_rate ?? 'N/A' }}</h5>
                                                <div class="small">bpm</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Respiratory Rate</h6>
                                                <h5>{{ $checkin->vitals->respiratory_rate ?? 'N/A' }}</h5>
                                                <div class="small">breaths/min</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">O₂ Saturation</h6>
                                                <h5>{{ $checkin->vitals->oxygen_saturation ?? 'N/A' }}</h5>
                                                <div class="small">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="text-muted">Blood Glucose</h6>
                                                <h5>{{ $checkin->vitals->blood_glucose ?? 'N/A' }}</h5>
                                                <div class="small">mg/dL</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chief Complaint Tab -->
                            <div class="tab-pane fade" id="complaint" role="tabpanel">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="25%">Complaint</th>
                                                <td>{{ $chiefComplaint->complaint ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Duration</th>
                                                <td>{{ $chiefComplaint->duration_value ?? 'N/A' }} {{ $chiefComplaint->duration_unit ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Severity (1-10)</th>
                                                <td>{{ $chiefComplaint->severity ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Associated Symptoms</th>
                                                <td>{{ $chiefComplaint->associated_symptoms ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Aggravating Factors</th>
                                                <td>{{ $chiefComplaint->aggravating_factors ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Relieving Factors</th>
                                                <td>{{ $chiefComplaint->relieving_factors ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Medical History Tab -->
                            <div class="tab-pane fade" id="history" role="tabpanel">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="25%">Current Medications</th>
                                                <td>{{ $medicalHistory->current_medications ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Allergies</th>
                                                <td>{{ $medicalHistory->allergies ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Surgical History</th>
                                                <td>{{ $medicalHistory->surgical_history ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Family Medical History</th>
                                                <td>{{ $medicalHistory->family_medical_history ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Medical Conditions Tab -->
                            <div class="tab-pane fade" id="conditions" role="tabpanel">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Condition</th>
                                                <th>Additional Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($medicalCondition && $medicalCondition->count())
                                                @foreach($medicalCondition as $condition)
                                                    <tr>
                                                        <td>{{ $condition->condition_name }}</td>
                                                        <td>{{ $condition->additional_details ?? 'No additional details' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center">No medical conditions recorded</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor's Consultation Form -->
                        <form action="{{ route('consultation.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $checkin->appointment_id }}">
                            <input type="hidden" name="checkin_id" value="{{ $checkin->id }}">
                            <input type="hidden" name="patient_id" value="{{ $checkin->patient_id }}">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Doctor's Consultation</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="diagnosis"><strong>Diagnosis</strong></label>
                                        <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" {{ $doctorDiagnosis ? 'readonly' : '' }}>{{$doctorDiagnosis->diagnosis ?? ''}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="prescription"><strong>Prescription</strong></label>
                                        <textarea name="prescription" id="prescription" class="form-control" rows="5"{{ $doctorDiagnosis ? 'readonly' : '' }}>{{$doctorDiagnosis->prescription ?? ''}}</textarea>
                                        <small class="form-text text-muted">Include medication names, dosages, frequency, and duration</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="advice"><strong>Medical Advice</strong></label>
                                        <textarea name="advice" id="advice" class="form-control" rows="3" {{ $doctorDiagnosis ? 'readonly' : '' }}>{{$doctorDiagnosis->advice ?? ''}}</textarea>
                                        <small class="form-text text-muted">Include lifestyle changes, follow-up instructions, etc.</small>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                @if (Auth::user()->role_id == "2" && !$doctorDiagnosis)

                                    <button type="submit" class="btn btn-primary">Complete Consultation</button>
                                    @endif
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
<!-- Include external JS file -->
<script src="{{ asset('admin/js/password_confirm.js') }}"></script>
@endsection
