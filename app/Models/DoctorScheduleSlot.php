<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorScheduleSlot extends Model
{
    protected $guarded = [];

    protected $table = 'doctor_schedule_slots';

    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function blockedBy()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }
}
