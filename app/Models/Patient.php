<?php

namespace App\Models;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\DoctorScheduleSlot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use Notifiable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->patient_code = substr(str_pad(rand(0, '11' . round(microtime(true))), 17, "0", STR_PAD_LEFT), 9);
        });
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function slots()
    {
        return $this->hasMany(DoctorScheduleSlot::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function checkins()
    {
        return $this->hasMany(PatientCheckin::class);
    }

}
