@extends('layout.main')
{{-- For Title --}}

<style>
    .table-customBorder td {
        padding: 1px !important;
    }

    /* .table-customBorder td, tr, th{
            border: none !important;
        } */
    .table-customBorder th {
        text-align: center !important;
        font-size: 12px !important;
        vertical-align: middle !important;
    }

    .table-customBorder span {
        font-size: 13px !important;
    }

    .for-text {
        font-size: 12px !important;
    }

    .table-customBorder td {
        text-align: center !important;
        padding: 1px !important;
    }
</style>
{{-- Main Content --}}
@section('content')
    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3" >
                        <h4 class="mb-0 text-white" style="font-weight: 600;">Assign Permissions</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3 align-items-end">
                            {{ csrf_field() }}
                            <div class="col-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger p-2 mb-2">
                                        <ul class="mb-0" style="font-size: 13px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="role_id" class="form-label fw-semibold">Role</label>
                                <select class="form-control chosen-select roleId" name="role_id" id="role_id">
                                    <option selected>--Select Role--</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="module_id" class="form-label fw-semibold">Module</label>
                                <select class="form-control chosen-select moduleId" name="module_id" id="module_id">
                                    <option selected>--Select Module--</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-customBorder align-middle mb-0 bg-white">
                                <thead class="thead-light" style="color: #333;">
                                    <tr>
                                        <th style="min-width: 180px;">Menu Name</th>
                                        <th style="width: 110px;">Select All</th>
                                        <th style="width: 110px;">Can View</th>
                                        <th style="width: 110px;">Can Add</th>
                                        <th style="width: 110px;">Can Edit</th>
                                        <th style="width: 110px;">Can Delete</th>
                                    </tr>
                                </thead>
                                <tbody style="color: #333; font-size: 13px;">
                                    {{-- Dynamic rows will be loaded here via AJAX --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        console.log("Permission Page Loaded");

        $('.moduleId').change(function() {
            GetPermission();
        });

        $('.roleId').change(function() {
            // Also trigger permission refresh when role changes
            if ($('.moduleId').val() != '--Select Module--') {
                GetPermission();
            }
        });

        function GetPermission() {
            var roleId = $('.roleId').val();
            var moduleId = $('.moduleId').val();

            // Validate selections
            if (roleId == '--Select Role--' || moduleId == '--Select Module--') {
                // Don't proceed if either dropdown is not selected
                return;
            }

            // Show loading indicator
            $('.table-customBorder tbody').html('<tr><td colspan="6" class="text-center">Loading permissions...</td></tr>');

            $.ajax({
                url: '{{ route('permission.get_role') }}',
                type: 'GET',
                data: {
                    role_id: roleId,
                    module_id: moduleId
                },
                dataType: 'json',
                success: function(response) {
                    console.log("API Response:", response);

                    // Clear previous table data
                    $('.table-customBorder tbody').empty();
                    $('#assignPermissionButtonRow').remove();

                    // Check if we have data
                    if (response.length === 0) {
                        $('.table-customBorder tbody').html(
                            '<tr><td colspan="6" class="text-center">No permissions found for this module</td></tr>'
                        );
                        return;
                    }

                    // Iterate through each submodule
                    $.each(response, function(index, submodule) {
                        var moduleName = submodule.submodule_name;
                        var rowId = 'submodule-' + index;

                        // Get CRUD permissions
                        var listPermission = submodule.permissions.list || null;
                        var createPermission = submodule.permissions.create || null;
                        var updatePermission = submodule.permissions.update || null;
                        var deletePermission = submodule.permissions.delete || null;

                        // Generate table row for each submodule
                        var row = '<tr id="' + rowId + '">' +
                            '<td class="text-left">' + moduleName + '</td>';

                        // Add Select All checkbox
                        row += '<td>' +
                            '<div class="checkboxStyle">' +
                            '<input type="checkbox" class="form-check-input select-all-row" data-row="' + rowId + '">' +
                            '</div>' +
                            '</td>';

                        // Add checkbox for list/view permission
                        row += '<td>' + getCheckboxHtml(listPermission, rowId) + '</td>';

                        // Add checkbox for create permission
                        row += '<td>' + getCheckboxHtml(createPermission, rowId) + '</td>';

                        // Add checkbox for update permission
                        row += '<td>' + getCheckboxHtml(updatePermission, rowId) + '</td>';

                        // Add checkbox for delete permission
                        row += '<td>' + getCheckboxHtml(deletePermission, rowId) + '</td>';

                        row += '</tr>';

                        // Append row to table body
                        $('.table-customBorder tbody').append(row);
                    });

                    // Add event handlers for "Select All" checkboxes
                    setupSelectAllHandlers();

                    // Append button after adding table rows, aligned to the right
                    var buttonRow = `
                        <div class="row" id="assignPermissionButtonRow">
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <input type="button" onclick="InsertPermission()" class="btn btn-info" value="Assign Permission">
                            </div>
                        </div>
                    `;
                    $('.table-responsive').after(buttonRow);
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('.table-customBorder tbody').html(
                        '<tr><td colspan="6" class="text-center text-danger">Error loading permissions. Please try again.</td></tr>'
                    );

                    // Show error message
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        Object.values(errors).forEach(function(error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error('Failed to load permissions. Please try again.');
                    }
                }
            });
        }

        // Helper function to generate checkbox HTML
        function getCheckboxHtml(permission, rowId) {
            if (!permission) {
                return '<span class="text-muted">N/A</span>';
            }

            return '<div class="checkboxStyle">' +
                '<input name="permission[]" class="form-check-input permission-checkbox" type="checkbox" ' +
                'data-row="' + rowId + '" value="' + permission.permission_id + '"' +
                (permission.isChecked ? ' checked' : '') + '>' +
                '</div>';
        }

        // Setup event handlers for "Select All" checkboxes
        function setupSelectAllHandlers() {
            // When "Select All" checkbox is clicked
            $('.select-all-row').on('change', function() {
                var rowId = $(this).data('row');
                var isChecked = $(this).prop('checked');

                // Select or deselect all checkboxes in this row
                $('#' + rowId + ' .permission-checkbox').prop('checked', isChecked);
            });

            // Update "Select All" checkbox when individual permissions are clicked
            $('.permission-checkbox').on('change', function() {
                var rowId = $(this).data('row');
                var totalCheckboxes = $('#' + rowId + ' .permission-checkbox').length;
                var checkedCheckboxes = $('#' + rowId + ' .permission-checkbox:checked').length;

                // Update the "Select All" checkbox based on the state of the permission checkboxes
                $('#' + rowId + ' .select-all-row').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            // Initial state of "Select All" checkboxes
            $('.select-all-row').each(function() {
                var rowId = $(this).data('row');
                var totalCheckboxes = $('#' + rowId + ' .permission-checkbox').length;
                var checkedCheckboxes = $('#' + rowId + ' .permission-checkbox:checked').length;

                // Set the initial state of the "Select All" checkbox
                $(this).prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
            });
        }

        function InsertPermission() {
            var role_id = $('.roleId').val();
            var moduleId = $('.moduleId').val();

            // Validate selections
            if (role_id == '--Select Role--' || moduleId == '--Select Module--') {
                toastr.error('Please select both a role and a module');
                return;
            }

            // Get all checked permission IDs
            var permissionIds = [];
            $('input[name="permission[]"]:checked').each(function() {
                permissionIds.push($(this).val());
            });

            // Show loading state
            var btnEl = $('#assignPermissionButtonRow input[type="button"]');
            var originalBtnText = btnEl.val();
            btnEl.val('Saving...').prop('disabled', true);

            $.ajax({
                url: '{{ route('permission.assign') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    role_id: role_id,
                    permission: permissionIds,
                    module_id: moduleId
                },
                dataType: 'json',
                success: function(response) {
                    btnEl.val(originalBtnText).prop('disabled', false);

                    if (response.status === 200) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        window.location.reload();
                        // Refresh the permissions after successful assignment
                        GetPermission();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    btnEl.val(originalBtnText).prop('disabled', false);

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        Object.values(errors).forEach(function(error) {
                            toastr.error(error[0]);
                        });
                    } else if (xhr.status === 403) {
                        Swal.fire({
                            title: 'Warning!',
                            text: xhr.responseJSON.msg,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred during the request.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }
    </script>
@endsection
