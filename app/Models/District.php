<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    function city()
    {
        return $this->belongsTo(City::class);
    }

    function address()
    {
        return $this->belongsTo(Address::class);
    }
}
