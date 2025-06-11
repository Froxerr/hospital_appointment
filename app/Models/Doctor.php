<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'doctor_id';
    
    protected $fillable = [
        'doctor_name',
        'doctor_surname',
        'doctor_email',
        'doctor_phone',
        'specialties_id',
        'address_id'
    ];

    public $timestamps = false; //otomatik timestampsleri ekleme
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialties_id');
    }
}
