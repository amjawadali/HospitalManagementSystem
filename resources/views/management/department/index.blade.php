@extends('layout.main')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Departments List</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#departmentmodal" id="addDepartmentBtn">
                    Add Department
                </button>
            </div>
            <div class="card-body">
                <table class="table" id="departmentsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Department Modal -->
    <div class="modal fade" id="departmentmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="departmentForm">
                @csrf
                <input type="hidden" name="id" id="department_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Department</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department Name</label>
                            <input type="text" class="form-control" name="department_name" id="department_name" required>
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
            fetchDepartments();

            // Fetch all departments
            function fetchDepartments() {
                $.get("{{ route('department.get_data') }}", function(res) {
                    let rows = '';
                    $.each(res, function(index, department) {
                        rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${department.department_name}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="${department.id}" data-name="${department.department_name}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${department.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
                    });
                    $('#departmentsTable tbody').html(rows);
                });
            }

            // Show modal for Add
            $('[data-target="#departmentmodal"]').click(function() {
                $('#departmentForm')[0].reset();
                $('#department_id').val('');
            });

            // Save Department
            $('#departmentForm').submit(function(e) {
                e.preventDefault();
                let id = $('#department_id').val();
                let url = id ? `/admin/management/department/update/${id}` : "{{ route('department.store') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('#departmentForm').serialize(),
                    success: function(res) {
                        $('#departmentmodal').modal('hide');
                        fetchDepartments();
                        if (id) {
                            toastr.success('Department updated successfully');
                        } else {
                            toastr.success('Department added successfully');
                        }
                    },
                    error: function(err) {
                        alert('Error occurred');
                    }
                });
            });

            // Edit Department
            $(document).on('click', '.editBtn', function() {
                $('#departmentmodal').modal('show');
                $('#department_name').val($(this).data('name'));
                $('#department_id').val($(this).data('id'));
            });

            // Delete Department with SweetAlert
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This department will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/management/department/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                fetchDepartments();
                                toastr.success('Department deleted successfully');
                            },
                            error: function() {
                                toastr.error('Failed to delete department');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
