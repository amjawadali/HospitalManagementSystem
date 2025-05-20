<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalHistory extends Model
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
}
