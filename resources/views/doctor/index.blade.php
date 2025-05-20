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
                                            <th>Profile Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Biography</th>
                                            <th>Qualifications</th>
                                            <th>License Number</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Joining Date</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doctors as $index => $doctor)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($doctor->profile_image)
                                                        <img src="{{ asset($doctor->profile_image) }}" alt="Profile Image" width="40" height="40" class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/default-profile.png') }}" alt="Default Image" width="40" height="40" class="rounded-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $doctor->name }}</td>
                                                <td>{{ $doctor->email ?? '-' }}</td>
                                                <td>{{ $doctor->contact_number ?? '-' }}</td>
                                                <td>{{ $doctor->biography ?? '-' }}</td>
                                                <td>{{ $doctor->qualifications ?? '-' }}</td>
                                                <td>{{ $doctor->license_number ?? '-' }}</td>
                                                <td>{{ $doctor->department->name ?? '-' }}</td>
                                                <td>{{ $doctor->designation->name ?? '-' }}</td>
                                                <td>{{ $doctor->joining_date ? \Carbon\Carbon::parse($doctor->joining_date)->format('Y-m-d') : '-' }}</td>
                                                <td>{{ $doctor->created_at ? $doctor->created_at->format('Y-m-d') : '-' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('doctor.edit', $doctor->id) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('doctor.destroy', $doctor->id) }}"
                                                        method="POST" style="display: inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
    <!-- Include external JS file -->
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>

@endsection
