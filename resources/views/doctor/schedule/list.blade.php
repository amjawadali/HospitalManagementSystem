@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Users List</h4>
                            </div>
                            <div>
                                <a href="{{ route('patient.create') }}" class="btn btn-primary">Add User</a>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Doctor</th>
                                            <th>Days</th>
                                            <th>Duration (min)</th>
                                            <th>Break (min)</th>
                                            <th>Valid From</th>
                                            <th>Valid To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schedules as $index => $schedule)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $schedule->doctor->name ?? 'N/A' }}</td>
                                                <td>
                                                    {{ is_array(json_decode($schedule->week_days)) ? implode(', ', json_decode($schedule->week_days)) : $schedule->week_days }}
                                                </td>
                                                <td>{{ $schedule->appointment_duration }}</td>
                                                <td>{{ $schedule->break_duration }}</td>
                                                <td>{{ $schedule->valid_from }}</td>
                                                <td>{{ $schedule->valid_to }}</td>
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
    <!-- Include external JS file -->
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>
@endsection
