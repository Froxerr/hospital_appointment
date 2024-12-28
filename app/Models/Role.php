<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false; //otomatik timestampsleri ekleme

    public function user()
    {
        return $this->hasmany(User::class, 'role_id');
    }

}
