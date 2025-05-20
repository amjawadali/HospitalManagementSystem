@extends('layout.main')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="container">
            <h2 class="mb-4">🩺 Patient Medical History</h2>

            @forelse ($data as $entry)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Check-in: {{ $entry->checkin_date ? \Carbon\Carbon::parse($entry->checkin_date)->format('F d, Y - h:i A') : 'N/A' }}</h5>
                    <small>Status: <span class="badge badge-success text-uppercase">{{ $entry->status ?? 'Unknown' }}</span></small>
                </div>

                <div class="card-body">

                    {{-- Vitals --}}
                    <h6 class="text-info mb-3">📊 Vitals</h6>
                    @if ($entry->vitals)
                    <div class="row mb-4">
                        <div class="col-md-3"><strong>Height:</strong> {{ $entry->vitals->height ?? 'N/A' }} cm</div>
                        <div class="col-md-3"><strong>Weight:</strong> {{ $entry->vitals->weight ?? 'N/A' }} kg</div>
                        <div class="col-md-3"><strong>BMI:</strong> {{ $entry->vitals->bmi ?? 'N/A' }}</div>
                        <div class="col-md-3"><strong>Temperature:</strong> {{ $entry->vitals->temperature ?? 'N/A' }} °C</div>
                        <div class="col-md-3"><strong>Blood Pressure:</strong> {{ $entry->vitals->systolic_bp ?? 'N/A' }}/{{ $entry->vitals->diastolic_bp ?? 'N/A' }} mmHg</div>
                        <div class="col-md-3"><strong>Pulse Rate:</strong> {{ $entry->vitals->pulse_rate ?? 'N/A' }} bpm</div>
                        <div class="col-md-3"><strong>Respiratory Rate:</strong> {{ $entry->vitals->respiratory_rate ?? 'N/A' }} breaths/min</div>
                        <div class="col-md-3"><strong>Oxygen Saturation:</strong> {{ $entry->vitals->oxygen_saturation ?? 'N/A' }}%</div>
                        <div class="col-md-3"><strong>Blood Glucose:</strong> {{ $entry->vitals->blood_glucose ?? 'N/A' }} mg/dL</div>
                    </div>
                    @else
                    <p>No vitals recorded.</p>
                    @endif

                    {{-- Chief Complaint --}}
                    <h6 class="text-info mb-3">😷 Chief Complaint</h6>
                    @if ($entry->chiefComplaint)
                    <div class="mb-3">
                        <p><strong>Complaint:</strong> {{ $entry->chiefComplaint->complaint ?? 'N/A' }}</p>
                        <p><strong>Onset Date:</strong> {{ $entry->chiefComplaint->onset_date ? \Carbon\Carbon::parse($entry->chiefComplaint->onset_date)->format('F d, Y') : 'N/A' }}</p>
                        <p><strong>Duration:</strong> {{ $entry->chiefComplaint->duration_value ?? 'N/A' }} {{ $entry->chiefComplaint->duration_unit ?? '' }}</p>
                        <p><strong>Severity:</strong> {{ $entry->chiefComplaint->severity ?? 'N/A' }}/10</p>
                        <p><strong>Associated Symptoms:</strong> {{ $entry->chiefComplaint->associated_symptoms ?? 'N/A' }}</p>
                        <p><strong>Aggravating Factors:</strong> {{ $entry->chiefComplaint->aggravating_factors ?? 'N/A' }}</p>
                        <p><strong>Relieving Factors:</strong> {{ $entry->chiefComplaint->relieving_factors ?? 'N/A' }}</p>
                    </div>
                    @else
                    <p>No chief complaint recorded.</p>
                    @endif

                    {{-- Medical History --}}
                    <h6 class="text-info mb-3">📚 Medical History</h6>
                    @if ($entry->medicalHistory)
                    <div class="mb-3">
                        <p><strong>Medications:</strong> {{ $entry->medicalHistory->current_medications ?? 'N/A' }}</p>
                        <p><strong>Allergies:</strong> {{ $entry->medicalHistory->allergies ?? 'N/A' }}</p>
                        <p><strong>Surgical History:</strong> {{ $entry->medicalHistory->surgical_history ?? 'N/A' }}</p>
                        <p><strong>Family History:</strong> {{ $entry->medicalHistory->family_medical_history ?? 'N/A' }}</p>
                    </div>
                    @else
                    <p>No medical history recorded.</p>
                    @endif

                    {{-- Medical Condition --}}
                    <h6 class="text-info mb-3">🧬 Medical Condition</h6>
                    @if ($entry->medicalCondition)
                    <div>
                        <p><strong>Condition:</strong> {{ $entry->medicalCondition->condition_name ?? 'N/A' }}</p>
                        @if (!empty($entry->medicalCondition->additional_details))
                        <p><strong>Details:</strong> {{ $entry->medicalCondition->additional_details }}</p>
                        @endif
                    </div>
                    @else
                    <p>No medical conditions recorded.</p>
                    @endif

                </div>
            </div>
            @empty
                <p>No medical history available.</p>
            @endforelse

        </div>
    </div>
</section>
@endsection
