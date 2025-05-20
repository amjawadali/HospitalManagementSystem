@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Patient Scheduling</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('doctor.schedule.store') }}" method="POST">
                    @csrf

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select id="doctor_id" required name="doctor_id"
                                class="form-control @error('doctor_id') is-invalid @enderror">
                                <option value="">Select Doctor</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="per-patient-time" class="form-label">Per Patient Time (minutes)</label>
                            <input type="number" required id="per-patient-time" name="per_patient_time"
                                class="form-control @error('per_patient_time') is-invalid @enderror"
                                value="{{ old('per_patient_time', 15) }}" min="1" max="480">
                            @error('per_patient_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="break-after-patient" class="form-label">Break After Each Patient (minutes)</label>
                            <input type="number" required id="break-after-patient" name="break_after_patient"
                                class="form-control @error('break_after_patient') is-invalid @enderror"
                                value="{{ old('break_after_patient', 5) }}" min="0" max="120">
                            @error('break_after_patient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">From Date</label>
                            <input type="date" required name="from_date"
                                class="form-control @error('from_date') is-invalid @enderror"
                                value="{{ old('from_date') }}">
                            @error('from_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">To Date</label>
                            <input type="date" required name="to_date" class="form-control @error('to_date') is-invalid @enderror"
                                value="{{ old('to_date') }}">
                            @error('to_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Day</th>
                                    <th>Available</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Monday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Monday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="monday-available"
                                                name="days[0][available]" value="1" checked>
                                            <input type="hidden" name="days[0][day]" value="Monday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[0][from]" value="{{ old('days.0.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[0][to]" value="{{ old('days.0.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Tuesday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Tuesday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="tuesday-available"
                                                name="days[1][available]" value="1" checked>
                                            <input type="hidden" name="days[1][day]" value="Tuesday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[1][from]" value="{{ old('days.1.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[1][to]" value="{{ old('days.1.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Wednesday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Wednesday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="wednesday-available"
                                                name="days[2][available]" value="1" checked>
                                            <input type="hidden" name="days[2][day]" value="Wednesday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[2][from]" value="{{ old('days.2.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[2][to]" value="{{ old('days.2.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Thursday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Thursday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="thursday-available"
                                                name="days[3][available]" value="1" checked>
                                            <input type="hidden" name="days[3][day]" value="Thursday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[3][from]" value="{{ old('days.3.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[3][to]" value="{{ old('days.3.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Friday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Friday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="friday-available"
                                                name="days[4][available]" value="1" checked>
                                            <input type="hidden" name="days[4][day]" value="Friday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[4][from]" value="{{ old('days.4.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[4][to]" value="{{ old('days.4.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Saturday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Saturday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="saturday-available"
                                                name="days[5][available]" value="1" checked>
                                            <input type="hidden" name="days[5][day]" value="Saturday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[5][from]" value="{{ old('days.5.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[5][to]" value="{{ old('days.5.to', '20:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                                <!-- Sunday -->
                                <tr>
                                    <td><span class="badge bg-light text-dark">Sunday</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="day-available" type="checkbox" id="sunday-available"
                                                name="days[6][available]" value="1" checked>
                                            <input type="hidden" name="days[6][day]" value="Sunday">
                                        </div>
                                    </td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[6][from]" value="{{ old('days.6.from', '08:00') }}"></td>
                                    <td><input type="time" class="form-control form-control-sm time-input"
                                            name="days[6][to]" value="{{ old('days.6.to', '14:00') }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary copy-time"><i
                                                class="bi bi-clipboard"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-3">
                        <button type="submit" class="btn btn-primary">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle availability of time inputs based on checkbox state
            const availabilityToggles = document.querySelectorAll('.day-available');

            availabilityToggles.forEach(toggle => {
                // Initial setup
                const row = toggle.closest('tr');
                const timeInputs = row.querySelectorAll('.time-input');

                // Set initial state
                updateTimeInputsState(toggle, timeInputs);

                // Add event listener for changes
                toggle.addEventListener('change', function() {
                    updateTimeInputsState(this, timeInputs);
                });
            });

            // Function to update time inputs state
            function updateTimeInputsState(toggle, inputs) {
                const isDisabled = !toggle.checked;
                inputs.forEach(input => {
                    input.disabled = isDisabled;
                    // Add visual indication for disabled state
                    if (isDisabled) {
                        input.classList.add('text-muted', 'bg-light');
                    } else {
                        input.classList.remove('text-muted', 'bg-light');
                    }
                });
            }

            // Copy button functionality
            const copyButtons = document.querySelectorAll('.copy-time');

            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const fromTime = row.querySelector('input[name$="[from]"]').value;
                    const toTime = row.querySelector('input[name$="[to]"]').value;

                    // Apply this time to all days
                    document.querySelectorAll('tr').forEach(tr => {
                        const fromInput = tr.querySelector('input[name$="[from]"]');
                        const toInput = tr.querySelector('input[name$="[to]"]');

                        if (fromInput && toInput) {
                            fromInput.value = fromTime;
                            toInput.value = toTime;
                        }
                    });

                    // Show feedback
                    button.innerHTML = '<i class="bi bi-check2"></i>';
                    setTimeout(() => {
                        button.innerHTML = '<i class="bi bi-clipboard"></i>';
                    }, 1500);
                });
            });

            // Convert time inputs to minutes when submitting the form
            document.querySelector('form').addEventListener('submit', function(event) {
                // Form validation can be added here if needed
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.querySelector('input[name="from_date"]');
            const toDateInput = document.querySelector('input[name="to_date"]');
            const tableRows = document.querySelectorAll('tbody tr');

            // Map weekday names to numbers (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            const dayNameToIndex = {
                'Sunday': 0,
                'Monday': 1,
                'Tuesday': 2,
                'Wednesday': 3,
                'Thursday': 4,
                'Friday': 5,
                'Saturday': 6,
            };

            function filterDaysByDateRange() {
                const fromDateValue = fromDateInput.value;
                const toDateValue = toDateInput.value;

                if (!fromDateValue || !toDateValue) {
                    // Show all rows and don't change checkboxes if no valid range
                    tableRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }

                const fromDate = new Date(fromDateValue);
                const toDate = new Date(toDateValue);

                tableRows.forEach(row => {
                    // Get day name from hidden input field
                    const dayNameInput = row.querySelector('input[type="hidden"][name$="[day]"]');
                    if (!dayNameInput) return; // safety check

                    const dayName = dayNameInput.value;
                    const dayIndex = dayNameToIndex[dayName];

                    // Find first date in range matching this weekday
                    let checkDate = new Date(fromDate);
                    while (checkDate.getDay() !== dayIndex) {
                        checkDate.setDate(checkDate.getDate() + 1);
                    }

                    // Show row only if that date <= toDate
                    if (checkDate <= toDate) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';

                        // Uncheck the checkbox inside this row if exists
                        const checkbox = row.querySelector('input[type="checkbox"][name$="[available]"]');
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                    }
                });
            }

            // Run once on page load
            filterDaysByDateRange();

            // Run on date changes
            fromDateInput.addEventListener('change', filterDaysByDateRange);
            toDateInput.addEventListener('change', filterDaysByDateRange);
        });
    </script>
@endsection
