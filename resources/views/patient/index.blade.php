@extends('layout.main')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            @if ($patients->count() > 0)

            @foreach ($patients as $patient)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm patient-card hover-shadow rounded-3">
                        <div class="position-relative">
                            <img
                                src="{{ $patient->profile_image ? asset($patient->profile_image) : asset('images/default-profile.png') }}"
                                class="card-img-top rounded-top"
                                alt="Profile Image"
                                style="object-fit: cover; height: 200px;"
                            >
                            <!-- Blood Group Badge - top-right corner -->
                            <span class="badge bg-primary text-white position-absolute" style="top: 10px; right: 10px;">
                                {{ $patient->blood_type ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="card-body py-3">
                            <h5 class="card-title mb-1 text-truncate">{{ $patient->name ?? 'Unnamed Patient' }}</h5>
                            <p class="text-muted small mb-2 text-truncate">{{ $patient->contact_number ?? 'No contact info' }}</p>

                            <ul class="list-unstyled mb-3 small">
                                <li>
                                    <i class="fas fa-phone-alt me-1 text-secondary"></i>
                                    <strong>Emergency:</strong> {{ $patient->emergency_contact_number ?? '-' }}
                                </li>
                                <li>
                                    <i class="fas fa-calendar-check me-1 text-secondary"></i>
                                    <strong>Last Visit:</strong>
                                    {{ $patient->last_visit_date ? \Carbon\Carbon::parse($patient->last_visit_date)->format('Y-m-d') : '-' }}
                                </li>
                            </ul>

                            <a href="{{ route('patient.medical.history', $patient->id) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="fas fa-notes-medical me-1"></i> View Medical History
                            </a>
                        </div>

                        <div class="card-footer bg-white border-top d-flex justify-content-between px-3 py-2">
                            <a href="#" class="text-info" title="View Profile">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('patient.edit', $patient->id) }}" class="text-warning" title="Edit Patient">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('patient.destroy', $patient->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 m-0" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this patient?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No patients found.
                    </div>
                </div>
            @endif


        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>
@endsection
