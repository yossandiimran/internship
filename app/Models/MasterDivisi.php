<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDivisi extends Model
{
    protected $table = 'master_divisi';

    protected $guarded = [];

    public function internship()
    {
        return $this->hasMany(SuratBalasanPemohon::class, 'id_divisi', 'id');
    }
    
}
