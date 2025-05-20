@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Patient Image</th>
                                            <th>Patient Name</th>
                                            <th>Check-in Date</th>
                                            <th>Appointment Date</th>
                                            <th>Doctor Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($checkins as $index => $checkin)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    @if (isset($checkin->appointment->patient) && $checkin->appointment->patient->profile_image)
                                                        <img src="{{ asset($checkin->appointment->patient->profile_image) }}"
                                                            alt="Profile Image" width="40" height="40"
                                                            class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/default-profile.png') }}"
                                                            alt="Default Image" width="40" height="40"
                                                            class="rounded-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $checkin->appointment->patient->name ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($checkin->checkin_date)->format('Y-m-d H:i') }}</td>
                                                <td>{{ $checkin->appointment->appointment_date ?? '-' }}</td>
                                                <td>{{ $checkin->appointment->doctor->name ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ ucfirst($checkin->status) }}</span>
                                                </td>

                                                <td>
                                                    @if ($checkin->status == 'completed')
                                                            {{-- <a href="{{ route('consultation.checkup', $checkin->id) }}" class="btn btn-info btn-sm" title="View Diagnosis">
                                                                <i class="fas fa-eye"></i>
                                                            </a> --}}
                                                            <a href="{{ route('consultation.prescription', $checkin->id) }}" class="btn btn-warning btn-sm" title="View Prescription">
                                                                <i class="fas fa-file-prescription"></i>
                                                            </a>
                                                    @else
                                                        <a href="{{ route('consultation.checkup', $checkin->id) }}" class="btn btn-primary btn-sm">
                                                            Checkup
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>
@endsection
