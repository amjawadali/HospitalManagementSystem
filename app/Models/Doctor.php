<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Doctor extends Model
{
    use Notifiable; 
   protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
