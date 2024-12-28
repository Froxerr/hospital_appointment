<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalAppointment extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    protected $primaryKey = 'hospital_appointment_id';
    protected $fillable = [
        "patient_id",
        "hospital_address_id",
        "hospital_appointment_floor_id",
        "doctor_id",
        "specialties_id",
        "appointment_name",
        "appointment_date_start",
        "appointment_date_end",
        "appointment_status"
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id', 'patients_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    public function hospitalAddress()
    {
        return $this->belongsTo(Address::class, 'hospital_address_id', 'address_id');
    }

    public function floor()
    {
        return $this->belongsTo(HospitalAppointmentFloor::class, 'hospital_appointment_floor_id', 'hospital_appointment_floor_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialties_id', 'specialty_id');
    }
}
