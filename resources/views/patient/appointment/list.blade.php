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
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Doctor Name</th>
                                            <th>Action</th> <!-- New column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointments as $index => $appointment)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($appointment->patient && $appointment->patient->profile_image)
                                                        <img src="{{ asset($appointment->patient->profile_image) }}"
                                                            alt="Profile Image" width="40" height="40"
                                                            class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/default-profile.png') }}"
                                                            alt="Default Image" width="40" height="40"
                                                            class="rounded-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $appointment->patient->name ?? '-' }}</td>
                                                <td>{{ $appointment->appointment_date ?? ($appointment->slot->slot_date ?? '-') }}
                                                </td>
                                                <td>
                                                    @if (isset($appointment->slot))
                                                        {{ \Carbon\Carbon::parse($appointment->slot->slot_start)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($appointment->slot->slot_end)->format('H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $appointment->doctor->name ?? '-' }}</td>
                                                <td>
                                                    <form action="{{ route('appointment.updatestatus', $appointment->id) }}" method="POST" class="update-status-form d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        @if (Auth::user()->role_id == 2)
                                                            @if ($appointment->status == 'pending')
                                                                <button type="submit" name="status" value="approved" class="btn btn-success btn-sm" title="Approve">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </button>
                                                                <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm" title="Reject">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </button>
                                                            @elseif ($appointment->status == 'approved')
                                                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Approved</span>
                                                            @elseif ($appointment->status == 'rejected')
                                                                <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                                                        @endif
                                                    </form>
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
