<?php

namespace App\Models;

use App\Models\PatientCheckin;
use App\Models\DoctorScheduleSlot;
use App\Models\PatientConsultation;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function slot()
    {
        return $this->belongsTo(DoctorScheduleSlot::class);
    }
    public function checkin()
    {
        return $this->hasOne(PatientCheckin::class);
    }
    public function consultation()
{
    return $this->hasOne(PatientConsultation::class);
}

}
