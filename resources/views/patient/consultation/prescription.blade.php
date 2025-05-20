@extends('layout.main')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Medical Prescription</h4>
                        {{-- <div class="card-header-action">
                            <button class="btn btn-icon btn-light" onclick="window.print()"><i class="fas fa-print"></i></button>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <!-- Doctor & Hospital Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <img src="{{ asset( $prescriptions[0]->appointment->doctor->profile_image) }}" alt="Doctor" class="rounded-circle" width="80" height="80" style="object-fit: cover">
                                    </div>
                                    <div>
                                        <h4 class="mb-1">Dr. {{ $prescriptions[0]->appointment->doctor->name }}</h4>
                                        <p class="text-muted mb-0">License #: {{ $prescriptions[0]->appointment->doctor->license_number }}</p>
                                        <p class="text-muted mb-0">{{ $prescriptions[0]->appointment->doctor->qualifications }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <h5 class="text-primary mb-1">City Medical Center</h5>
                                <p class="text-muted mb-0">123 Healthcare Ave, Medical District</p>
                                <p class="text-muted mb-0">Phone: (555) 123-4567</p>
                                <p class="text-muted mb-0">Email: info@citymedical.com</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Patient Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="mr-3">
                                        <img src="{{ asset( $checkin->appointment->patient->profile_image) }}" alt="Patient" class="rounded-circle" width="60" height="60" style="object-fit: cover">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $checkin->appointment->patient->name }}</h5>
                                        <p class="text-muted mb-0">Patient ID: {{ $checkin->appointment->patient->patient_code }}</p>
                                        <p class="text-muted mb-0">
                                            {{ \Carbon\Carbon::parse($checkin->appointment->patient->date_of_birth)->age }} years |
                                            {{ ucfirst($checkin->appointment->patient->gender) }} |
                                            Blood: {{ $checkin->appointment->patient->blood_type }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <div class="badge badge-success px-3 py-2 mb-2">Visit: {{ \Carbon\Carbon::parse($checkin->appointment->appointment_date)->format('M d, Y') }}</div>
                                <p class="text-muted mb-0">Appointment #: {{ $checkin->appointment_id }}</p>
                                <p class="text-muted mb-0">Check-in Time: {{ \Carbon\Carbon::parse($checkin->checkin_date)->format('h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Vitals -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="font-weight-bold mb-0"><i class="fas fa-heartbeat text-danger mr-2"></i>Vital Signs</h6>
                            </div>
                            <div class="card-body py-3">
                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-weight text-primary"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->weight }} kg</h6>
                                            <small class="text-muted">Weight</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-ruler-vertical text-primary"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->height }} cm</h6>
                                            <small class="text-muted">Height</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-calculator text-primary"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->bmi }}</h6>
                                            <small class="text-muted">BMI</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-thermometer-half text-danger"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->temperature }}°F</h6>
                                            <small class="text-muted">Temperature</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-heart text-danger"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->pulse_rate }} bpm</h6>
                                            <small class="text-muted">Pulse</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block rounded-circle bg-light p-3">
                                                <i class="fas fa-lungs text-primary"></i>
                                            </div>
                                            <h6 class="mt-2 mb-0">{{ $vitals->respiratory_rate }}/min</h6>
                                            <small class="text-muted">Resp. Rate</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light p-2 mr-3">
                                                <i class="fas fa-tint text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Blood Pressure</h6>
                                                <p class="mb-0 text-muted">{{ $vitals->systolic_bp }}/{{ $vitals->diastolic_bp }} mmHg</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light p-2 mr-3">
                                                <i class="fas fa-wind text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Oxygen Saturation</h6>
                                                <p class="mb-0 text-muted">{{ $vitals->oxygen_saturation }}%</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light p-2 mr-3">
                                                <i class="fas fa-cookie-bite text-warning"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Blood Glucose</h6>
                                                <p class="mb-0 text-muted">{{ $vitals->blood_glucose }} mg/dL</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chief Complaint & Medical History -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="font-weight-bold mb-0"><i class="fas fa-exclamation-circle text-warning mr-2"></i>Chief Complaint</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Complaint:</h6>
                                            <p>{{ $chiefComplaint->complaint }}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Onset Date:</h6>
                                                    <p>{{ \Carbon\Carbon::parse($chiefComplaint->onset_date)->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Duration:</h6>
                                                    <p>{{ $chiefComplaint->duration_value }} {{ $chiefComplaint->duration_unit }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Severity (1-10):</h6>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-{{ $chiefComplaint->severity <= 3 ? 'success' : ($chiefComplaint->severity <= 7 ? 'warning' : 'danger') }}"
                                                     role="progressbar"
                                                     style="width: {{ $chiefComplaint->severity * 10 }}%;"
                                                     aria-valuenow="{{ $chiefComplaint->severity }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="10">{{ $chiefComplaint->severity }}/10</div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Associated Symptoms:</h6>
                                            <p>{{ $chiefComplaint->associated_symptoms }}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Aggravating Factors:</h6>
                                                    <p>{{ $chiefComplaint->aggravating_factors }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Relieving Factors:</h6>
                                                    <p>{{ $chiefComplaint->relieving_factors }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="font-weight-bold mb-0"><i class="fas fa-file-medical-alt text-info mr-2"></i>Medical History</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Current Medications:</h6>
                                            <p>{{ $medicalHistory->current_medications }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Allergies:</h6>
                                            <p>{{ $medicalHistory->allergies }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Surgical History:</h6>
                                            <p>{{ $medicalHistory->surgical_history }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Family Medical History:</h6>
                                            <p>{{ $medicalHistory->family_medical_history }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Medical Conditions:</h6>
                                            <div class="d-flex flex-wrap">
                                                @foreach($medicalCondition as $condition)
                                                    <span class="badge badge-light border mr-2 mb-2 p-2">
                                                        @if($condition->condition_name == 'Diabetes')
                                                            <i class="fas fa-syringe text-warning mr-1"></i>
                                                        @elseif($condition->condition_name == 'Asthma')
                                                            <i class="fas fa-lungs text-info mr-1"></i>
                                                        @elseif($condition->condition_name == 'Heart Disease')
                                                            <i class="fas fa-heartbeat text-danger mr-1"></i>
                                                        @elseif($condition->condition_name == 'Cancer')
                                                            <i class="fas fa-ribbon text-pink mr-1"></i>
                                                        @elseif($condition->condition_name == 'Psychiatric Disorder')
                                                            <i class="fas fa-brain text-purple mr-1"></i>
                                                        @else
                                                            <i class="fas fa-notes-medical text-primary mr-1"></i>
                                                        @endif
                                                        {{ $condition->condition_name }}
                                                        @if($condition->additional_details)
                                                            <small class="d-block text-muted">{{ $condition->additional_details }}</small>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor's Diagnosis & Prescription -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary py-2">
                                <h6 class="font-weight-bold text-white mb-0"><i class="fas fa-stethoscope mr-2"></i>Doctor's Diagnosis & Prescription</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card border border-primary h-100">
                                            <div class="card-header bg-primary-light">
                                                <h6 class="mb-0"><i class="fas fa-diagnoses mr-2"></i>Diagnosis</h6>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $doctorDiagnosis->diagnosis }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border border-primary h-100">
                                            <div class="card-header bg-primary-light">
                                                <h6 class="mb-0"><i class="fas fa-prescription-bottle-alt mr-2"></i>Prescription</h6>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $doctorDiagnosis->prescription }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border border-primary h-100">
                                            <div class="card-header bg-primary-light">
                                                <h6 class="mb-0"><i class="fas fa-comment-medical mr-2"></i>Advice</h6>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $doctorDiagnosis->advice }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer & Signature -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="alert alert-light border">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <i class="fas fa-info-circle fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Important Notes</h6>
                                            <p class="mb-0 small">Please follow the prescription as directed. Contact the doctor immediately if you experience any adverse reactions. Schedule a follow-up appointment as recommended.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="border-top pt-3 mt-3">
                                    <img src="{{ asset('images/signature.png') }}" alt="Signature" height="50" class="mb-2">
                                    <p class="mb-0 font-weight-bold">Dr. {{ $prescriptions[0]->appointment->doctor->name }}</p>
                                    <p class="text-muted small mb-0">{{ $prescriptions[0]->appointment->doctor->qualifications }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer bg-whitesmoke text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="" class="btn btn-outline-primary mr-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                                </a>
                                <button class="btn btn-outline-success" onclick="window.print()">
                                    <i class="fas fa-print mr-1"></i> Print Prescription
                                </button>
                            </div>
                            <div>
                                <small class="text-muted">Generated on {{ now()->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>
                    </div> --}}
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
        // Print styling
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .card-header-action, .card-footer {
                display: none !important;
            }
        }
    });
</script>
@endsection
