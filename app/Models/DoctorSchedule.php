<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedules';
    protected $primaryKey = 'schedule_id';
    
    protected $fillable = [
        'doctor_id',
        'work_time_start',
        'work_time_end',
        'status'
    ];

    public $timestamps = false; //otomatik timestampsleri ekleme

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
