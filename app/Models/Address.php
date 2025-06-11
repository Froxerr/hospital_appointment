<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    
    protected $fillable = [
        'address_name',
        'address_district_id'
    ];

    public $timestamps = false; //otomatik timestampsleri ekleme

    // İlçe ilişki
    public function district()
    {
        return $this->belongsTo(District::class, 'address_district_id', 'district_id');
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(HospitalAppointment::class, 'hospital_address_id', 'address_id');
    }
}
