<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    
}
