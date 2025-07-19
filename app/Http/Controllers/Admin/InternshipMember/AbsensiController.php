<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Auth;
use Validator;

class AbsensiController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.internshipMember.absensi.index');
    }

    /**
     * Return sap bus data for datatables
     */
    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $usr = Auth::user()->load('jurusanDetail');
        $data = Kehadiran::with([
            'user',
        ])
            ->where('id_user', $usr->id)
            ->orderBy('id', 'DESC')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('tanggal', function ($val) {
                $tanggal = \Carbon\Carbon::parse($val->created_at)->translatedFormat('d F Y');
                return '
                    <div style="text-align:left;">
                       <div><strong>' . $tanggal . '</strong></div>
                    </div>
                ';
            })
            ->addColumn('waktu_mulai', function ($val) {
                if ($val->jam_masuk != null) {
                    $imgUrl = asset('storage/' . $val->foto_masuk);
                    $tanggal = \Carbon\Carbon::parse($val->jam_masuk)->translatedFormat('d F Y');
                    $jam = \Carbon\Carbon::parse($val->jam_masuk)->format('H:i');
                    return '
                        <div style="text-align:center;">
                            <img src="' . $imgUrl . '" alt="gambar awal"
                                style="height: 60px; margin-bottom: 5px; cursor: pointer;"
                                data-toggle="modal" data-target="#imgModal" data-img="' . $imgUrl . '"><br>
                            <div><strong>' . $jam . '</strong></div>
                            <div><i>' . $val->kehadiran . '</i></div><br>
                        </div>
                    ';
                } else {
                    return '-';
                }
            })
            ->addColumn('waktu_akhir', function ($val) {
                if ($val->jam_keluar != null) {
                    $imgUrl = asset('storage/' . $val->foto_keluar);
                    $tanggal = \Carbon\Carbon::parse($val->jam_keluar)->translatedFormat('d F Y');
                    $jam = \Carbon\Carbon::parse($val->jam_keluar)->format('H:i');
                    return '
                        <div style="text-align:center;">
                            <img src="' . $imgUrl . '" alt="gambar awal"
                                style="height: 60px; margin-bottom: 5px; cursor: pointer;"
                                data-toggle="modal" data-target="#imgModal" data-img="' . $imgUrl . '"><br>
                            <div><strong>' . $jam . '</strong></div><br>
                            <div><i>' . $val->keterangan . '</i></div><br>
                        </div>
                    ';
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($val) {
                $jam = \Carbon\Carbon::parse($val->jam_masuk)->format('H:i');
                if ($jam > '08:00') {
                    $html = '<button class="btn btn-warning btn-sm" title="Tugas Baru"><i class="fas fa-clock"></i>&nbsp;&nbsp; Terlambat</button>';
                } else {
                    $html = '<button class="btn btn-success btn-sm" title="Edit"><i class="fas fa-check"></i>&nbsp;&nbsp; Hadir</button>';
                }

                return $html;
            })
            ->rawColumns(['waktu_mulai', 'waktu_akhir', 'status', 'tanggal'])
            ->make(true);
    }

    public function absensi(Request $req)
    {
        $pwRules = 'nullable';

        $validator = Validator::make($req->all(), [
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'keterangan' => 'required|string|max:255',
        ]);

        if ($req->file('foto')) {
            $foto = $req->file('foto')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        $usr = Auth::user()->load('jurusanDetail');

        try {
            $check = Kehadiran::where('id_user', $usr->id)
                ->whereDate('created_at', now()->toDateString())
                ->first();

            if ($check) {
                Kehadiran::where('id_user', $usr->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->update([
                        'keterangan' => $req->keterangan,
                        'jam_keluar' => now(),
                        'foto_keluar' => $foto
                    ]);
            } else {
                Kehadiran::create([
                    'id_user' => $usr->id,
                    'kehadiran' => $req->keterangan,
                    'jam_masuk' => now(),
                    'foto_masuk' => $foto
                ]);
            }
            return $this->sendResponse(null, "Berhasil Melakukan Absensi.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
        }
    }
}
