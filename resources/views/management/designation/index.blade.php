@extends('layout.main')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Designations List</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#designationmodal" id="addDesignationBtn">
                    Add Designation
                </button>
            </div>
            <div class="card-body">
                <table class="table" id="designationsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Designation Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Designation Modal -->
    <div class="modal fade" id="designationmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="designationForm">
                @csrf
                <input type="hidden" name="id" id="designation_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Designation</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Designation Name</label>
                            <input type="text" class="form-control" name="designation_name" id="designation_name" required>
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
            fetchDesignations();

            // Fetch all designations
            function fetchDesignations() {
                $.get("{{ route('designation.get_data') }}", function(res) {
                    let rows = '';
                    $.each(res, function(index, designation) {
                        rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${designation.designation_name}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="${designation.id}" data-name="${designation.designation_name}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${designation.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
                    });
                    $('#designationsTable tbody').html(rows);
                });
            }

            // Show modal for Add
            $('[data-target="#designationmodal"]').click(function() {
                $('#designationForm')[0].reset();
                $('#designation_id').val('');
            });

            // Save Designation
            $('#designationForm').submit(function(e) {
                e.preventDefault();
                let id = $('#designation_id').val();
                let url = id ? `/admin/management/designation/update/${id}` : "{{ route('designation.store') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('#designationForm').serialize(),
                    success: function(res) {
                        $('#designationmodal').modal('hide');
                        fetchDesignations();
                        if (id) {
                            toastr.success('Designation updated successfully');
                        } else {
                            toastr.success('Designation added successfully');
                        }
                    },
                    error: function(err) {
                        alert('Error occurred');
                    }
                });
            });

            // Edit Designation
            $(document).on('click', '.editBtn', function() {
                $('#designationmodal').modal('show');
                $('#designation_name').val($(this).data('name'));
                $('#designation_id').val($(this).data('id'));
            });

            // Delete Designation with SweetAlert
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This designation will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/management/designation/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                fetchDesignations();
                                toastr.success('Designation deleted successfully');
                            },
                            error: function() {
                                toastr.error('Failed to delete designation');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
