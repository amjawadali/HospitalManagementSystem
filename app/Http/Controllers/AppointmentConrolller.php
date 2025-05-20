<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorScheduleSlot;
use App\Models\Patient;
use App\Models\PatientCheckin;
use App\Models\PatientChiefComplaint;
use App\Models\PatientMedicalCondition;
use App\Models\PatientMedicalHistory;
use App\Models\PatientVital;
use App\Notifications\AppointmentApprovalNotification;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentConrolller extends Controller
{
    public function availability()
    {
        $patients = Patient::get();
        $doctors = Doctor::with('schedules', 'department', 'designation')->paginate(6);

        // Change to paginate with 5 doctors per page
        return view('patient.appointment.index', compact('doctors', 'patients'));
    }

    public function list()
    {
        if (Auth::user()->role_id == 2) {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
                ->where('doctor_id', Auth::user()->doctor->id)
                ->with('doctor', 'patient', 'slot')
                ->get();
        } elseif (Auth::user()->role_id == 4) {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
                ->where('patient_id', Auth::user()->patient->id)
                ->with('doctor', 'patient', 'slot')
                ->get();
        } else {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
                ->with('doctor', 'patient', 'slot')
                ->get();
        }

        return view('patient.appointment.list', compact('appointments'));
    }
    public function approvedList()
    {
        if (Auth::user()->role_id == 2) {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
            ->where('doctor_id', Auth::user()->doctor->id)
            ->with('doctor', 'patient', 'slot')
            ->get();
        } elseif (Auth::user()->role_id == 4) {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
            ->where('patient_id', Auth::user()->patient->id)
            ->with('doctor', 'patient', 'slot')
            ->get();
        } else {
            $appointments = Appointment::whereNotIn('status', ['pending','cancel','rejected'])
            ->with('doctor', 'patient', 'slot')
            ->get();
        }

        return view('patient.appointment.approved', compact('appointments'));
    }

    public function getDoctorEvents($doctorId)
    {
        $doctor = Doctor::with('schedules.slots')->findOrFail($doctorId);
        $events = [];

        foreach ($doctor->schedules as $schedule) {
            $weekDays = json_decode($schedule->week_days, true);

            $availableSlots = $schedule->slots()
                ->where('status', 'available')
                ->whereDate('slot_date', '>=', now()->toDateString())
                ->get()
                ->groupBy('slot_date');

            $startDate = \Carbon\Carbon::parse($schedule->valid_from);
            $endDate = \Carbon\Carbon::parse($schedule->valid_to);

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if (in_array($date->format('l'), $weekDays)) {

                    $slotsForDate = $availableSlots->get($date->toDateString());

                    if ($slotsForDate) {
                        foreach ($slotsForDate as $slot) {
                            $startDateTime = \Carbon\Carbon::parse($slot->slot_date . ' ' . $slot->slot_start);
                            $endDateTime = $startDateTime->copy()->addMinutes($schedule->appointment_duration);

                            $events[] = [
                                'start' => $startDateTime->toDateTimeString(),
                                'end' => $endDateTime->toDateTimeString(),
                                'title' => 'Available',
                                'backgroundColor' => '#28a745',
                                'borderColor' => '#28a745',
                                'textColor' => '#fff',
                                'padding' => 0,
                                'extendedProps' => [
                                    'doctor_id' => $doctor->id,
                                    'schedule_id' => $schedule->id,
                                    'slot_id' => $slot->id,
                                ],
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:doctor_schedule_slots,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:doctor_schedules,id',
            'reason_for_visit' => 'nullable|string|max:1000',
        ]);

        // Determine patient_id
        if ($request->patient_id) {
            $patient_id = $request->patient_id;
        } else {
            $patient = Auth::user()->patient;
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found.'
                ]);
            }
            $patient_id = $patient->id;
        }

        // Check if slot is still available
        $slot = DoctorScheduleSlot::where('id', $request->slot_id)->where('status', 'available')->first();
        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Selected slot is no longer available.'
            ]);
        }

        // Create appointment
        $appointment = Appointment::create([
            'slot_id' => $request->slot_id,
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $request->schedule_id,
            'patient_id' => $patient_id,
            'appointment_date' => \Carbon\Carbon::parse($request->slot_date ?? now()),
            'reason_for_visit' => $request->reason_for_visit,
            'status' => 'pending',
        ]);

        // Update slot status to 'booked'
        $slot->update(['status' => 'booked']);

        $doctor = $appointment->doctor; // make sure this relationship is defined
        $doctor->notify(new NewAppointmentNotification($appointment));

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully.'
        ]);
    }

    public function UpdateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)->first();

        if (!$appointment) {
            toastr()->error('Appointment not found.');
            return redirect()->back();
        }

        $slot = DoctorScheduleSlot::where('id', $appointment->slot_id)->first();

        if (!$slot) {
            toastr()->error('Slot not found.');
            return redirect()->back();
        }

        $newStatus = $request->status;

        // Update the appointment status
        $appointment->update(['status' => $newStatus]);
        $patient = $appointment->patient;
        if ($patient) {
            $patient->notify(new AppointmentApprovalNotification($newStatus, $appointment->id));
        }

        // Update the slot status based on the appointment status
        if ($newStatus === 'approved') {
            $slot->update(['status' => 'completed']);
        } elseif (in_array($newStatus, ['rejected', 'cancel'])) {
            $slot->update(['status' => 'available']);
        }

        toastr()->success('Appointment status updated successfully.');
        return redirect()->back();
    }

    public function checkin(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)->first();
        $patient = $appointment->patient;
        return view('patient.appointment.checkin', compact('id', 'patient', 'appointment'));
    }

    /**
     * Store patient check-in information in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
public function PatientCheckin(Request $request)
{
    DB::beginTransaction();
    try {
        // 1. Patient Checkin
        $checkin = PatientCheckin::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => $request->patient_id,
            'checked_in_by' => Auth::id(),
            'checkin_date' => now(),
            'status' => 'progress',
            'notes' => $request->notes ?? null,
        ]);

        // 2. Patient Vitals
        $heightInMeters = $request->height / 100;
        $bmi = $request->weight / ($heightInMeters * $heightInMeters);

        PatientVital::create([
            'checkin_id' => $checkin->id,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => round($bmi, 2),
            'temperature' => $request->temperature,
            'systolic_bp' => $request->systolic_bp,
            'diastolic_bp' => $request->diastolic_bp,
            'pulse_rate' => $request->pulse_rate,
            'respiratory_rate' => $request->respiratory_rate,
            'oxygen_saturation' => $request->oxygen_saturation,
            'blood_glucose' => $request->blood_glucose,
        ]);

        // 3. Medical History
        PatientMedicalHistory::create([
            'checkin_id' => $checkin->id,
            'current_medications' => $request->current_medications,
            'allergies' => $request->allergies,
            'surgical_history' => $request->surgical_history,
            'family_medical_history' => $request->family_medical_history,
        ]);

        // 4. Medical Conditions
        if ($request->has('medical_history')) {
            foreach ($request->medical_history as $condition) {
                PatientMedicalCondition::create([
                    'checkin_id' => $checkin->id,
                    'condition_name' => $condition,
                    'additional_details' => $condition === 'Other' && $request->has('other_medical_history')
                        ? $request->other_medical_history
                        : null,
                ]);
            }
        }

        // 5. Chief Complaint
        PatientChiefComplaint::create([
            'checkin_id' => $checkin->id,
            'complaint' => $request->chief_complaint,
            'onset_date' => $request->onset_date,
            'duration_value' => $request->duration_value,
            'duration_unit' => $request->duration_unit,
            'severity' => $request->severity,
            'associated_symptoms' => $request->associated_symptoms,
            'aggravating_factors' => $request->aggravating_factors,
            'relieving_factors' => $request->relieving_factors,
        ]);

        // 6. Update Appointment Status
        Appointment::where('id', $request->appointment_id)->update([
            'status' => 'processing',
        ]);
        Patient::where('id', $request->patient_id)->update([
            'last_visit_date' => now(),
        ]);

        DB::commit();
        toastr()->success('Patient check-in completed successfully.');
        return redirect()->route('appointment.approve.list');
    } catch (\Exception $e) {
        DB::rollBack();
        toastr()->error('Error during check-in: ' . $e->getMessage());
        return redirect()->back();
    }
}

}
