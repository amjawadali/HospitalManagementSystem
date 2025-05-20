@extends('layout.main')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Users List</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usermodal" id="addRoleBtn">
                    Add User
                </button>

            </div>
            <div class="card-body">
                <table class="table" id="rolesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Role Modal -->
    <!-- Add this Modal inside your Blade view -->
    <div class="modal fade" id="usermodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="roleForm">
                @csrf
                <input type="hidden" name="id" id="role_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Role</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            fetchRoles();

            // Fetch all roles
            function fetchRoles() {
                $.get("{{ route('role.get_data') }}", function(res) {
                    let rows = '';
                    $.each(res, function(index, role) {
                        rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${role.name}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="${role.id}" data-name="${role.name}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${role.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
                    });
                    $('#rolesTable tbody').html(rows);
                });
            }

            // Show modal for Add
            $('[data-target="#usermodal"]').click(function() {
                $('#roleForm')[0].reset();
                $('#role_id').val('');
            });

            // Save Role
            $('#roleForm').submit(function(e) {
                e.preventDefault();
                let id = $('#role_id').val();
                let url = id ? `/admin/management/role/update/${id}` : "{{ route('role.store') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('#roleForm').serialize(),
                    success: function(res) {
                        $('#usermodal').modal('hide');
                        fetchRoles();
                        if (id) {
                            toastr.success('Role updated successfully');
                        } else {
                            toastr.success('Role added successfully');
                        }
                    },
                    error: function(err) {
                        alert('Error occurred');
                    }
                });
            });

            // Edit Role
            $(document).on('click', '.editBtn', function() {
                $('#usermodal').modal('show');
                $('#name').val($(this).data('name'));
                $('#role_id').val($(this).data('id'));
            });

            // Delete Role with SweetAlert
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This role will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/management/roles/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                fetchRoles();
                                toastr.success('Role deleted successfully');
                            },
                            error: function() {
                                toastr.error('Failed to delete role');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
