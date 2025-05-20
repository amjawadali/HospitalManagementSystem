@extends('layout.main')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Users List</h4>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usermodal">Add
                                    User</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Branch</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role ? $user->role->name : '-' }}</td>
                                                <td>{{ $user->department ? $user->department->department_name : '-' }}</td>
                                                <td>{{ $user->designation ? $user->designation->designation_name : '-' }}
                                                </td>
                                                <td>{{ $user->branch ? $user->branch->branch_name : '-' }}</td>
                                                <td>
                                                    @if ($user->user_status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="swal-6" action="{{ route('users.destroy', $user->id) }}"
                                                        method="POST" style="display: inline;">
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
    @include('management.users.create')
@endsection

@section('scripts')
    <!-- Include external JS file -->
    <script src="{{ asset('admin/js/management/users.js') }}"></script>
    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>

@endsection
