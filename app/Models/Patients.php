<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    protected $fillable = [
        "patients_insurances_id",
        "patients_name",
        "patients_surname",
        "patients_phone",
        "patients_gender",
        "patients_email"
    ];
}
