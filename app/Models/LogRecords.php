<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRecords extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    protected $fillable = [
        'user_id',
        'log_description',
        'user_name',
        'user_email',
        'badge',
        'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
