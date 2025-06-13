<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterStatusSurat extends Model
{
    protected $table = 'master_status_surat';

    protected $guarded = [];

    public function suratBalasan()
    {
        return $this->hasMany(SuratBalasan::class, 'status_surat', 'id');
    }
    
}
