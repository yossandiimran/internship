<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MasterJurusan;
use App\Models\MasterStatusSurat;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'group_user' => 1,
            'alamat' => 'Bandung',
            'kode_pos' => '40535',
            'kelurahan' => 'cibereum',
            'kecamatan' => 'Cimahi Selatan',
            'kota' => 'Cimahi',
            'provinsi' => 'Jawa Barat',
            'no_hp' => '081224580918',
        ]);

        MasterJurusan::create([
            'jurusan' => 'Teknik Informatika',
        ]);

        MasterJurusan::create([
            'jurusan' => 'Desain Komunikasi Visual',
        ]);

        MasterJurusan::create([
            'jurusan' => 'Teknik Komputer',
        ]);

        MasterJurusan::create([
            'jurusan' => 'Akuntansi',
        ]);

        MasterStatusSurat::create([
            'status' => 'Dikirim',
        ]);
        MasterStatusSurat::create([
            'status' => 'Diproses',
        ]);
        MasterStatusSurat::create([
            'status' => 'Ditolak',
        ]);
        MasterStatusSurat::create([
            'status' => 'Ditinjau',
        ]);
        MasterStatusSurat::create([
            'status' => 'Aktif',
        ]);
        MasterStatusSurat::create([
            'status' => 'Selesai',
        ]);
    }
}
