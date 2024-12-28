<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme
    protected $fillable = [
        "insurance_type_id",
        "insurance_date_start",
        "insurance_date_end"
    ];
}
