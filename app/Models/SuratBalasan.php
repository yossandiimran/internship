<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBalasan extends Model
{
    protected $table = 'surat_balasan';

    protected $guarded = [];

    public function pemohon()
    {
        return $this->hasMany(SuratBalasanPemohon::class, 'id_surat', 'id');
    }

    public function statusDetail()
    {
        return $this->hasOne(MasterStatusSurat::class, 'id', 'status_surat');
    }
    
    
}
