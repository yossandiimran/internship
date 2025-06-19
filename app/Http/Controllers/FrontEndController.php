<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DateTime;
use Hash;

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

    public function createAkun(Request $req){
        try{

            $existingUser = User::where('email', $req->email)->first();
            $existingUsername = User::where('username', $req->username)->first();
            $existingHandphone = User::where('no_hp', $req->no_hp)->first();
            
            if ($existingUser) {
                return redirect()->back()->with('error', 'Email sudah terdaftar!');
            }

            if ($existingUsername) {
                return redirect()->back()->with('error', 'Username sudah terdaftar!');
            }
            
            if ($existingHandphone) {
                return redirect()->back()->with('error', 'Nomor Handphone sudah terdaftar!');
            }

            $data =  User::create([
                'name' => $req->name,
                'username' => $req->username,
                'email' => $req->email,
                'no_hp' => $req->no_hp,
                'asal_sekolah' => $req->asal_sekolah,
                'nim' => $req->nim,
                'jurusan' => $req->jurusan,
                'alamat' => "-",
                'kode_pos' => "-",
                'kelurahan' => "-",
                'kecamatan' => "-",
                'kota' => "-",
                'provinsi' => "-",
                'group_user' => '2',
                'is_internship' => true,
                'password' => Hash::make($req->password),
            ]);
             return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
        }catch(\Throwable $err){
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
