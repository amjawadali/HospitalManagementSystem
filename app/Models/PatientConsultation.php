<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientConsultation extends Model
{
    protected $guarded = [];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
