<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobdesc extends Model
{
    protected $table = 'jobdesc';

    protected $guarded = [];

    public function assignTo()
    {
        return $this->hasOne(SuratBalasanPemohon::class, 'email', 'assign_to');
    }
    
    
}
