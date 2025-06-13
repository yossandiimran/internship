<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJurusan extends Model
{
    protected $table = 'master_jurusan';

    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(SuratBalasanPemohon::class, 'id_jurusan', 'id');
    }
    
}
