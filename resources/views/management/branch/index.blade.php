@extends('layout.main')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Branch List</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#branchmodal" id="addBranchBtn">
                    Add Branch
                </button>
            </div>
            <div class="card-body">
                <table class="table" id="branchesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Branch Name</th>
                            <th>Branch Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Branch Modal -->
    <div class="modal fade" id="branchmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document"><!-- modal-lg for wider modal -->
            <form id="branchForm" class="w-100">
                @csrf
                <input type="hidden" name="id" id="branch_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Branch</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- First Row -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" name="branch_name" id="branch_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Code</label>
                                        <input type="text" class="form-control" name="branch_code" id="branch_code" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Address</label>
                                        <input type="text" class="form-control" name="branch_address" id="branch_address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Location</label>
                                        <input type="text" class="form-control" name="branch_location" id="branch_location">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Slug</label>
                                        <input type="text" class="form-control" name="branch_slug" id="branch_slug">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" name="branch_status" id="branch_status">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Second Row -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <input type="text" class="form-control" name="branch_type" id="branch_type">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Is Head Office</label>
                                        <select class="form-control" name="is_head_office" id="is_head_office">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>User ID</label>
                                        <input type="number" class="form-control" name="user_id" id="user_id">
                                    </div>
                                </div>
                            </div>
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
            fetchBranches();

            // Fetch all branches
            function fetchBranches() {
                $.get("{{ route('branch.get_data') }}", function(res) {
                    let rows = '';
                    $.each(res, function(index, branch) {
                        rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${branch.branch_name ?? ''}</td>
                            <td>${branch.branch_code ?? ''}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn"
                                    data-id="${branch.id}"
                                    data-branch_name="${branch.branch_name ?? ''}"
                                    data-branch_code="${branch.branch_code ?? ''}"
                                    data-branch_address="${branch.branch_address ?? ''}"
                                    data-branch_location="${branch.branch_location ?? ''}"
                                    data-branch_slug="${branch.branch_slug ?? ''}"
                                    data-branch_status="${branch.branch_status ?? ''}"
                                    data-branch_type="${branch.branch_type ?? ''}"
                                    data-is_head_office="${branch.is_head_office ?? 0}"
                                    data-user_id="${branch.user_id ?? ''}"
                                ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="${branch.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                    });
                    $('#branchesTable tbody').html(rows);
                });
            }

            // Show modal for Add
            $('[data-target="#branchmodal"]').click(function() {
                $('#branchForm')[0].reset();
                $('#branch_id').val('');
            });

            // Save Branch
            $('#branchForm').submit(function(e) {
                e.preventDefault();
                let id = $('#branch_id').val();
                let url = id ? `/admin/management/branch/update/${id}` : "{{ route('branch.store') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('#branchForm').serialize(),
                    success: function(res) {
                        $('#branchmodal').modal('hide');
                        fetchBranches();
                        if (id) {
                            toastr.success('Branch updated successfully');
                        } else {
                            toastr.success('Branch added successfully');
                        }
                    },
                    error: function(err) {
                        alert('Error occurred');
                    }
                });
            });

            // Edit Branch
            $(document).on('click', '.editBtn', function() {
                $('#branchmodal').modal('show');
                $('#branch_id').val($(this).data('id'));
                $('#branch_name').val($(this).data('branch_name'));
                $('#branch_code').val($(this).data('branch_code'));
                $('#branch_address').val($(this).data('branch_address'));
                $('#branch_location').val($(this).data('branch_location'));
                $('#branch_slug').val($(this).data('branch_slug'));
                $('#branch_status').val($(this).data('branch_status'));
                $('#branch_type').val($(this).data('branch_type'));
                $('#is_head_office').val($(this).data('is_head_office'));
                $('#user_id').val($(this).data('user_id'));
            });

            // Delete Branch with SweetAlert
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This branch will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/management/branch/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                fetchBranches();
                                toastr.success('Branch deleted successfully');
                            },
                            error: function() {
                                toastr.error('Failed to delete branch');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
