<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBalasanPemohon extends Model
{
    protected $table = 'surat_balasan_pemohon';

    protected $guarded = [];

    public function header()
    {
        return $this->hasOne(SuratBalasan::class, 'id', 'id_surat');
    }

    public function pemohon()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public function jurusan()
    {
        return $this->hasOne(MasterJurusan::class, 'id', 'id_jurusan');
    }

}
