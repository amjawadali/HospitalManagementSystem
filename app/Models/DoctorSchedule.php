<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DoctorScheduleSlot;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $guarded = [];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function slots()
    {
        return $this->hasMany(DoctorScheduleSlot::class, 'schedule_id');
    }
}
