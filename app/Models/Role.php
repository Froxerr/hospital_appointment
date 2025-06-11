<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    public $timestamps = false; //otomatik timestampsleri ekleme

    protected $fillable = [
        'role_id',
        'role_name',
        'role_status'
    ];

    public function user()
    {
        return $this->hasmany(User::class, 'role_id');
    }

}
