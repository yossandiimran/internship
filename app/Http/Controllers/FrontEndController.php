<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterDivisi;
use App\Models\MasterJurusan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use DateTime;
use DataTables;
use Validator;

class FrontEndController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function daftarInternship(){
        return view('frontend.registerInternship');

    }

    public function createTransaksi(Request $req){
        DB::beginTransaction();

        try{
            $kode = $this->generateBookingCode();
            $dt = new DateTime();
            $trx = Transaksi::create([
                'kode_booking' => $kode,
                'tgl_booking' => $dt->format('Y-m-d'),
                'tgl_berangkat' => $req->tgl_berangkat,
                'tgl_kembali' => $req->tgl_kembali,
                'nama_pelanggan' => $req->nama_pelanggan,
                'kontak_pelanggan' => $req->kontak_pelanggan,
                'status_booking' => 1,
            ]);

            foreach($req->idBus as $key => $bus){
                $trxDetail = TransaksiDetail::create([
                    'kode_booking' => $kode,
                    'id_bus' => $bus,
                    'tarif' => $req->tarifBus[$key]
                ]);
            }

            DB::commit();
            
            return $this->sendResponse($trx, 'Transaksi berhasil dibuat.');
        }catch(\Throwable $err){
            DB::rollback();
            return $this->sendError('Kesalahan sistem saat proses login, silahkan hubungi admin.');
        }
    }

    function generateBookingCode() {
        // Prefix
        $prefix = "BK";
    
        // Tanggal saat ini
        $today = new DateTime();
        $day = $today->format('d');
        $month = $today->format('m');
        $year = $today->format('y');
    
        // Tanggal dalam format ddmmyy
        $datePart = $day . $month . $year;
    
        // Karakter acak
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomChars = '';
        for ($i = 0; $i < 4; $i++) {
            $randomChars .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        // Menggabungkan semuanya
        $bookingCode = $prefix . $datePart . $randomChars;
    
        return $bookingCode;
    }

    function cekTransaksi(Request $req){
        try {
            $data = Transaksi::select('*')
            ->where('kontak_pelanggan', $req->no_hp)
            ->where('kode_booking', $req->kode_booking)
            ->first();

            if($data){
                return $this->sendResponse($data, "Berhasil mengambil data.");
            }else{
                return $this->sendError("Kode Booking tidak dapat ditemukan.");
            }
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Kode Booking tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }

}
