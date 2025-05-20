<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\DoctorScheduleSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorScheduleController extends Controller
{
    /**
     * Display the list of doctors
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('doctor.schedule.create', compact('doctors'));
    }

    public function list()
    {
        if (Auth::user()->role_id == 2) {
            $doctors = Doctor::where('id', Auth::user()->doctor->id)->get();
        } else {
            $doctors = Doctor::all();
        }
        $schedules = DoctorSchedule::with('doctor', 'department')->whereIn('doctor_id', $doctors->pluck('id'))->get();
        // return [$schedules, $doctors];
        return view('doctor.schedule.list', compact('doctors', 'schedules'));
    }

    /**
     * Show the schedule management page for a specific doctor
     */
    // public function show(Doctor $doctor)
    // {
    //     return view('doctor.schedule.show', compact('doctor'));
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'per_patient_time' => 'required|integer|min:1|max:480',
            'doctor_id' => 'required|exists:doctors,id',
            'break_after_patient' => 'required|integer|min:0|max:120',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'days' => 'required|array',
            'days.*.day' => 'required|string',
            'days.*.available' => 'sometimes|boolean',
            'days.*.from' => 'required_if:days.*.available,1|nullable|string',
            'days.*.to' => 'required_if:days.*.available,1|nullable|string',
        ]);

        $existingSchedule = DoctorSchedule::where('doctor_id', $data['doctor_id'])
            ->where(function ($query) use ($data) {
                if ($data['from_date'] && $data['to_date']) {
                    $query->whereBetween('valid_from', [$data['from_date'], $data['to_date']])
                        ->orWhereBetween('valid_to', [$data['from_date'], $data['to_date']]);
                }
            })
            ->exists();
        if ($existingSchedule) {
            toastr()->error('Schedule already exists for the selected date range.');
            return redirect()->back();
        }

        foreach ($data['days'] as $index => $day) {
            if (!empty($day['available']) && $day['available'] == 1) {
                if (strtotime($day['to']) <= strtotime($day['from'])) {
                    return redirect()->back()
                        ->withErrors(["days.$index.to" => "The 'to' time must be after the 'from' time."])
                        ->withInput();
                }
            }
        }

        $doctor_id = Auth::user()->role === 'doctor' ? Auth::user()->doctor->id : $data['doctor_id'];

        try {
            DB::beginTransaction();

            $appointmentDuration = $data['per_patient_time'];
            $breakDuration = $data['break_after_patient'];

            $availableDayNames = [];
            $fullDaySchedules = [];

            $availableDays = collect($data['days'])->filter(function ($day) {
                return isset($day['available']) && $day['available'] == 1;
            })->values()->all();

            foreach ($availableDays as $day) {
                $availableDayNames[] = $day['day'];
                $fullDaySchedules[$day['day']] = [
                    'from' => $day['from'],
                    'to' => $day['to'],
                ];
            }

            $schedule = DoctorSchedule::create([
                'doctor_id' => $doctor_id,
                'week_days' => json_encode($availableDayNames),
                'appointment_duration' => $appointmentDuration,
                'break_duration' => $breakDuration,
                'valid_from' => $data['from_date'] ?? null,
                'valid_to' => $data['to_date'] ?? null,
                'is_active' => true,
            ]);

            if ($data['from_date'] && $data['to_date']) {
                $this->generateScheduleSlots($schedule, $fullDaySchedules);
            } else {
                toastr()->info('Schedule created without date range. No time slots were generated.');
            }

            DB::commit();
            toastr()->success('Schedule created successfully.');
            return redirect()->route('doctor.schedule.list');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error creating schedule: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    private function generateScheduleSlots(DoctorSchedule $schedule, array $weekDays)
    {
        $startDate = Carbon::parse($schedule->valid_from);
        $endDate = Carbon::parse($schedule->valid_to);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->format('l'); // e.g. Monday

            if (isset($weekDays[$dayOfWeek])) {
                $daySchedule = $weekDays[$dayOfWeek];

                $startTimeStr = $daySchedule['from'];
                $endTimeStr = $daySchedule['to'];

                $currentSlotStart = Carbon::parse($date->format('Y-m-d') . ' ' . $startTimeStr);
                $slotEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $endTimeStr);

                $appointmentDuration = (int) $schedule->appointment_duration;
                $breakDuration = (int) $schedule->break_duration;

                while ($currentSlotStart->lt($slotEnd)) {
                    $currentSlotEnd = $currentSlotStart->copy()->addMinutes($appointmentDuration);

                    if ($currentSlotEnd->gt($slotEnd)) {
                        break;
                    }

                    DoctorScheduleSlot::create([
                        'schedule_id' => $schedule->id,
                        'slot_date' => $date->format('Y-m-d'),
                        'slot_start' => $currentSlotStart->format('H:i:s'),
                        'slot_end' => $currentSlotEnd->format('H:i:s'),
                        'status' => 'available'
                    ]);

                    $currentSlotStart->addMinutes($appointmentDuration + $breakDuration);
                }
            }
        }
    }
}
