<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentCapacity extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme
    protected $primaryKey = 'appointment_capacity_id';

}
