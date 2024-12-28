<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
