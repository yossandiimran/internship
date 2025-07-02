<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }

}
