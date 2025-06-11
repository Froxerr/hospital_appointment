<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentCapacity extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme
    protected $primaryKey = 'appointment_capacity_id';
    
    protected $fillable = [
        'appointment_hospital_id',
        'number_of_appointment',
        'max_capacity',
        'available_capacity'
    ];

    public function hospitalAddress()
    {
        return $this->belongsTo(Address::class, 'appointment_hospital_id', 'address_id');
    }
}
