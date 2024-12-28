<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
