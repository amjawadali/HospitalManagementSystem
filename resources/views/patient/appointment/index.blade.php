@extends('layout.main')

@section('content')
    <div class="container">

        <div class="row">
            <!-- Doctor List with Pagination -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Quick Search</h6>
                        <div class="input-group">
                            <input type="text" id="doctorSearch" class="form-control" placeholder="Doctor's name...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Select a Doctor</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="doctor-list">
                            @forelse ($doctors as $doctor)
                                <div class="doctor-card p-3 border-bottom {{ $loop->last ? '' : 'border-bottom' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="doctor-avatar me-3">
                                            <img src="{{ $doctor->profile_image ? asset('images/doctors/' . basename($doctor->profile_image)) : asset('default-doctor.png') }}"
                                                alt="{{ $doctor->name }}" class="rounded-circle"
                                                style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                        </div>
                                        <div class="doctor-info flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $doctor->name }}</h6>
                                            <p class="text-muted small mb-0">{{ Str::limit($doctor->biography, 60) }}</p>
                                            <p class="text-muted small mb-0">
                                                <strong>Department:</strong>
                                                {{ $doctor->department ? $doctor->department->department_name : 'N/A' }}
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <strong>Designation:</strong>
                                                {{ $doctor->designation ? $doctor->designation->designation_name : 'N/A' }}
                                            </p>
                                            <button class="btn btn-primary btn-sm check-availability-btn w-100"
                                                data-doctor-id="{{ $doctor->id }}">
                                                <i class="fas fa-calendar-check me-1"></i> Check Availability
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="text-muted">No doctors available at the moment.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination Links -->
                        <div class="pagination-container p-3">
                            {{ $doctors->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

                <!-- Quick Search Box -->

            </div>

            <!-- Calendar -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Availability Calendar</h5>
                        <div class="calendar-controls">
                            <button id="prevWeek" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="nextWeek" class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                        <div id="calendarPlaceholder" class="text-center py-5 d-none">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Select a doctor to view availability</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Booking Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" method="POST" action="{{ route('patient.appointment.store') }}">
                        @csrf
                        <input type="hidden" name="slot_id" id="slot_id">
                        <input type="hidden" name="doctor_id" id="doctor_id">
                        <input type="hidden" name="schedule_id" id="schedule_id">


                        @if (Auth::user()->role_id != 4 )
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Select Patient</label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="reason_for_visit" class="form-label">Symptoms</label>
                            <textarea class="form-control" id="reason_for_visit" name="reason_for_visit" rows="3" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize UI state
            const calendarEl = document.getElementById('calendar');
            const calendarPlaceholder = document.getElementById('calendarPlaceholder');

            // Show the placeholder initially
            calendarPlaceholder.classList.remove('d-none');

            // Initialize FullCalendar
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                allDaySlot: false,
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                height: 'auto',
                headerToolbar: {
                    left: 'today',
                    center: 'title',
                    right: ''
                },
                events: [],
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                }
            });

            calendar.render();

            // Custom prev/next week buttons
            document.getElementById('prevWeek').addEventListener('click', function() {
                calendar.prev();
            });

            document.getElementById('nextWeek').addEventListener('click', function() {
                calendar.next();
            });

            // Doctor search functionality
            const doctorSearch = document.getElementById('doctorSearch');
            doctorSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const doctorCards = document.querySelectorAll('.doctor-card');

                doctorCards.forEach(card => {
                    const doctorName = card.querySelector('h6').textContent.toLowerCase();
                    if (doctorName.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Listen to all "Check Availability" buttons
            document.querySelectorAll('.check-availability-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Show loading state
                    this.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...';
                    this.disabled = true;

                    // Highlight the selected doctor
                    document.querySelectorAll('.doctor-card').forEach(card => {
                        card.classList.remove('selected-doctor');
                    });
                    this.closest('.doctor-card').classList.add('selected-doctor');

                    const doctorId = this.getAttribute('data-doctor-id');

                    // Hide the placeholder
                    calendarPlaceholder.classList.add('d-none');

                    fetch(`{{ route('patient.appointment.list', ['doctor' => 'DOCTOR_ID_PLACEHOLDER']) }}`
                            .replace('DOCTOR_ID_PLACEHOLDER', doctorId))
                        .then(response => response.json())
                        .then(data => {
                            calendar.removeAllEvents();

                            // Format events with better styling
                            const formattedEvents = data.map(event => ({
                                ...event,
                                backgroundColor: event.status === 'available' ?
                                    '#4CAF50' : '#F44336',
                                borderColor: event.status === 'available' ?
                                    '#4CAF50' : '#F44336',
                                textColor: '#FFFFFF'
                            }));

                            calendar.addEventSource(formattedEvents);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            // Show error notification
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load doctor availability. Please try again.'
                            });
                        })
                        .finally(() => {
                            // Reset button state
                            this.innerHTML =
                                '<i class="fas fa-calendar-check me-1"></i> Check Availability';
                            this.disabled = false;
                        });
                });
            });

            // Event click handler for booking
            calendar.on('eventClick', function(info) {

                info.jsEvent.preventDefault();

                const props = info.event.extendedProps;
                document.getElementById('slot_id').value = props.slot_id;
                document.getElementById('doctor_id').value = props.doctor_id;
                document.getElementById('schedule_id').value = props.schedule_id;
                document.getElementById('reason_for_visit').value = '';

                const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                appointmentModal.show();
            });

            // Handle form submission with success message
            document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = this;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Hide modal if open
                        // const modal = bootstrap.Modal.getInstance(document.getElementById(
                        //     'appointmentModal'));
                        // if (modal) modal.hide();

                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Appointment Booked',
                            text: data.message ||
                                'Your appointment has been scheduled successfully!',
                            confirmButtonText: 'Great!'
                        })
                        window.location.reload();
                    } else {
                        // Show error alert from server
                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            text: data.message || 'An error occurred. Please try again.',
                        });
                    }
                } catch (error) {
                    // Catch fetch or JSON errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Error',
                        text: error.message || 'Something went wrong. Please try again.',
                    });
                }
            });


        });
    </script>

    <style>
        .doctor-card {
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            background-color: #f8f9fa;
        }

        .selected-doctor {
            background-color: #e8f4fe !important;
            border-left: 4px solid #0d6efd !important;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
        }

        .pagination-container .pagination {
            margin-bottom: 0;
        }

        /* Custom styling for calendar events */
        .fc-event {
            cursor: pointer;
            border-radius: 4px;
            padding: 2px 4px;
        }

        /* Better responsive behavior */
        @media (max-width: 767.98px) {

            .col-md-4,
            .col-md-8 {
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <script src="{{ asset('admin/js/sweet_alert.js') }}"></script>
    <!-- Make sure Font Awesome is included in your layout -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
@endsection
