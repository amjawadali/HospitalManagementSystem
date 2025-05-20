<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PatientVital;
use App\Models\PatientChiefComplaint;
use App\Models\PatientMedicalHistory;
use App\Models\PatientMedicalCondition;
use Illuminate\Database\Eloquent\Model;

class PatientCheckin extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function vitals()
    {
        return $this->hasOne(PatientVital::class,'checkin_id');
    }


    public function chiefComplaint()
    {
        return $this->hasOne(PatientChiefComplaint::class,'checkin_id');
    }


    public function medicalHistory()
    {
        return $this->hasOne(PatientMedicalHistory::class,'checkin_id');
    }


    public function medicalCondition()
    {
        return $this->hasOne(PatientMedicalCondition::class,'checkin_id');
    }

}
