<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    // İlçe ilişki
    public function district()
    {
        return $this->hasMany(District::class);
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
}
