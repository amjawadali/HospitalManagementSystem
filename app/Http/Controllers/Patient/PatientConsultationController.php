<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientCheckin;
use App\Models\PatientChiefComplaint;
use App\Models\PatientConsultation;
use App\Models\PatientMedicalCondition;
use App\Models\PatientMedicalHistory;
use App\Models\PatientVital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientConsultationController extends Controller
{
    public function checkinPatient()
    {
        if (Auth::user()->role_id == 4) {
            $checkins = PatientCheckin::where('patient_id', Auth::user()->patient->id)
                ->with(['appointment.doctor'])
                ->get();
        } else {
            $checkins = PatientCheckin::with(['appointment.doctor'])
                ->get();
        }


        return view('patient.consultation.CheckinList', compact('checkins'));
    }
    public function consultationPatient()
    {
        $consultations = Appointment::where('patient_id', Auth::user()->id)
            ->with(['consultation', 'doctor'])
            ->get();

        return view('patient.consultations.index', compact('consultations'));
    }
    public function checkup($id, Request $request)
    {
        $checkin = PatientCheckin::where('id', $id)
            ->with('appointment.patient', 'vitals')
            ->first();

        $chiefComplaint = PatientChiefComplaint::where('checkin_id', $id)->first();
        $medicalHistory = PatientMedicalHistory::where('checkin_id', $id)->first();
        $medicalCondition = PatientMedicalCondition::where('checkin_id', $id)->get();

        $doctorDiagnosis = PatientConsultation::where('checkin_id', $id)->first() ?? null;

        // return $chiefComplaint;
        return view('patient.consultation.checkup', compact('checkin', 'chiefComplaint', 'medicalHistory', 'medicalCondition', 'doctorDiagnosis'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'checkin_id' => 'required|exists:patient_checkins,id',
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'advice' => 'nullable|string',
        ]);

        //if checkin status is completed give error
        $checkinStatus = PatientCheckin::where('id', $request->checkin_id)
            ->value('status');
        if ($checkinStatus == 'completed') {
            toastr()->error('Checkin already completed.');
            return redirect()->back();
        }

        try {

            //take doctor id from appointment
            $doctorId = Appointment::where('id', $request->appointment_id)
                ->value('doctor_id');

            // Create the consultation record
            $consultation = PatientConsultation::create([
                'appointment_id' => $request->appointment_id,
                'checkin_id' => $request->checkin_id,
                'doctor_id' => $doctorId,
                'patient_id' => $request->patient_id,
                'diagnosis' => $request->diagnosis,
                'prescription' => $request->prescription,
                'advice' => $request->advice,
            ]);

            // Update checkin status to 'completed'
            PatientCheckin::where('id', $request->checkin_id)
                ->update(['status' => 'completed']);

            // Update appointment status to 'completed'
            Appointment::where('id', $request->appointment_id)
                ->update(['status' => 'completed']);


            toastr()->success('Consultation saved successfully.');
            return redirect()->route('doctor.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function prescription($id)
    {
        $prescriptions = PatientConsultation::where('checkin_id', $id)
            ->with(['appointment.doctor'])
            ->get();
        $checkin = PatientCheckin::where('id', $id)
            ->with('appointment.patient')
            ->first();
        $chiefComplaint = PatientChiefComplaint::where('checkin_id', $id)->first();
        $medicalHistory = PatientMedicalHistory::where('checkin_id', $id)->first();
        $medicalCondition = PatientMedicalCondition::where('checkin_id', $id)->get();
        $doctorDiagnosis = PatientConsultation::where('checkin_id', $id)->first() ?? null;
        $vitals = PatientVital::where('checkin_id', $id)->first();

        return view('patient.consultation.prescription', compact('prescriptions', 'checkin', 'chiefComplaint', 'medicalHistory', 'medicalCondition', 'doctorDiagnosis', 'vitals'));
    }
}
