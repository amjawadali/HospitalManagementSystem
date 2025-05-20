/**
 * User Management JavaScript
 * This file handles all the AJAX requests for user operations
 */

// Wait for the document to be fully loaded
$(document).ready(function () {

    // CSRF Token setup for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Create notification element if it doesn't exist
    if ($('#notification-container').length === 0) {
        $('body').append('<div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
    }

    // Function to show notification
    function showNotification(type, message) {
        let alertClass = 'alert-info';
        if (type === 'success') alertClass = 'alert-success';
        if (type === 'error') alertClass = 'alert-danger';
        if (type === 'warning') alertClass = 'alert-warning';

        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);

        $('#notification-container').append(notification);

        // Auto dismiss after 3 seconds
        setTimeout(function () {
            notification.alert('close');
        }, 3000);
    }

$('#saveUserBtn').on('click', function (e) {
    e.preventDefault();

    $(this).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    $(this).attr('disabled', true);

    let formData = new FormData($('#userForm')[0]);

    $.ajax({
        type: 'POST',
        url: '/admin/management/user/store',
        data: formData,
        contentType: false, // Must be false to let jQuery set the correct boundary
        processData: false, // Prevent jQuery from processing the data
        success: function (response) {
            if (response.status == 'success') {
                showNotification('success', response.message || 'User added successfully!');
                $('#userForm')[0].reset();
                $('#usermodal').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                showNotification('error', response.message || 'Something went wrong!');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '<ul>';
                $.each(errors, function (key, value) {
                    errorMessage += '<li>' + value + '</li>';
                });
                errorMessage += '</ul>';
                $('#usermodal').find('.modal-body').prepend(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validation Error!</strong>
                        ${errorMessage}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                showNotification('error', 'Something went wrong! Please try again later.');
            }
        },
        complete: function () {
            $('#saveUserBtn').html('Save');
            $('#saveUserBtn').attr('disabled', false);
        }
    });
});




});


