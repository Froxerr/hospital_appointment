<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    public function doctor()
    {
        return $this->hasmany(Doctor::class);
    }
}
