<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SuratBalasanPemohon;
use App\Models\Jobdesc;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Carbon;
use Validator;

class JobDescController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        $pemohon = SuratBalasanPemohon::with([
            'divisi',
            'jurusan',
            'pemohon',
            'header.statusDetail',
        ])
            ->join('surat_balasan as sb', 'sb.id', '=', 'surat_balasan_pemohon.id_surat')
            ->where('sb.status_surat', '=', 5)
            ->select('surat_balasan_pemohon.*')
            ->get();

        return view('admin.jobdesc.index', [
            'pemohon' => $pemohon,
        ]);
    }


    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = Jobdesc::with([
            'assignTo.divisi',
        ])
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('waktu_mulai', function ($val) {
                if ($val->waktu_mulai != null) {
                    $imgUrl = asset('storage/' . $val->gambar_awal);
                    $tanggal = \Carbon\Carbon::parse($val->waktu_mulai)->translatedFormat('d F Y');
                    $jam = \Carbon\Carbon::parse($val->waktu_mulai)->format('H:i');
                    return '
                        <div style="text-align:center;">
                            <img src="' . $imgUrl . '" alt="gambar awal"
                                style="height: 60px; margin-bottom: 5px; cursor: pointer;"
                                data-toggle="modal" data-target="#imgModal" data-img="' . $imgUrl . '"><br>
                            <div><strong>' . $tanggal . '</strong></div>
                            <div><strong>' . $jam . '</strong></div>
                        </div>
                    ';
                } else {
                    return '-';
                }
            })
            ->addColumn('pekerjaan', function ($val) {
                $tanggal = \Carbon\Carbon::parse($val->created_at)->translatedFormat('d F Y');
                $jam = \Carbon\Carbon::parse($val->created_at)->format('H:i');
                return '
                    <div style="text-align:left;">
                        <div>' . $val->pekerjaan . '</div>
                       <div><i>Ditugaskan pada : <strong>' . $tanggal . ' ' . $jam . '</strong></i></div>
                    </div>
                ';
            })
            ->addColumn('waktu_akhir', function ($val) {
                if ($val->waktu_akhir != null) {
                    $imgUrl = asset('storage/' . $val->gambar_akhir);
                    $tanggal = \Carbon\Carbon::parse($val->waktu_akhir)->translatedFormat('d F Y');
                    $jam = \Carbon\Carbon::parse($val->waktu_akhir)->format('H:i');
                    return '
                        <div style="text-align:center;">
                            <img src="' . $imgUrl . '" alt="gambar awal"
                                style="height: 60px; margin-bottom: 5px; cursor: pointer;"
                                data-toggle="modal" data-target="#imgModal" data-img="' . $imgUrl . '"><br>
                            <div><strong>' . $tanggal . '</strong></div>
                            <div><strong>' . $jam . '</strong></div>
                        </div>
                    ';
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($val) {
                if ($val->status == 1) {
                    $html = '<button class="btn btn-primary btn-sm" title="Tugas Baru"><i class="fas fa-star"></i>&nbsp;&nbsp; Task Baru</button>';
                } else if ($val->status == 2) {
                    $html = '<button class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-clock"></i>&nbsp;&nbsp; Sedang Dikerjakan</button>';
                } else if ($val->status == 3) {
                    $html = '<button class="btn btn-secondary btn-sm" title="Edit"><i class="fas fa-check"></i>&nbsp;&nbsp; Selesai</button>';
                } else if ($val->status == 4) {
                    $html = '<button class="btn btn-danger btn-sm" title="Edit"><i class="fas fa-times"></i>&nbsp;&nbsp; Dibatalkan / Ditolak</button>';
                } else if ($val->status == 5) {
                    $html = '<button class="btn btn-success btn-sm" title="Edit"><i class="fas fa-check"></i>&nbsp;&nbsp; Selesai & Sudah Di Verifikasi</button>';
                }

                return $html;
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("Jobdesc" . $val->id);
                $html = '<div class="btn-group">';
                if ($val->status == 1) {
                    $html .= '<button class="btn btn-warning btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 2) {
                    $html .= '<button class="btn btn-warning btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 3) {
                    $html .= '<button class="btn btn-success btn-sm btn-selesai" data-key="' . $key . '" title="Verifikasi"><i class="fas fa-check"></i></button>';
                    $html .= '<button class="btn btn-secondary btn-sm btn-cancel" data-key="' . $key . '" title="Tolak"><i class="fas fa-times"></i></button>';
                } else if ($val->status == 4) {
                } else if ($val->status == 5) {
                }


                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'waktu_mulai', 'waktu_akhir', 'status', 'pekerjaan'])
            ->make(true);
    }

    public function store(Request $req)
    {
        $pwRules = 'nullable';
        $user = Auth::user();

        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if (empty($req->key)) {
                // Create Data
                $data = Jobdesc::create([
                    "assign_to" => $req->assign_to,
                    "pekerjaan" => $req->pekerjaan,
                    "status" => '1',
                ]);
            } else {
                // Validation
                $key = str_replace("Jobdesc", "", decrypt($req->key));
                $data = Jobdesc::findOrFail($key);

                // Update Data
                $data->update([
                    "assign_to" => $req->assign_to,
                    "pekerjaan" => $req->pekerjaan,
                    "status" => $req->status,
                ]);
            }
            return $this->sendResponse(null, "Berhasil memproses data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            dd($err);
            return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
        }
    }

    public function detail(Request $req)
    {
        try {
            $key = str_replace("Jobdesc", "", decrypt($req->key));
            $data = Jobdesc::with([
                'user',
            ])->whereId($key)->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }

    public function destroy(Request $req)
    {
        try {
            $key = str_replace("Jobdesc", "", decrypt($req->key));
            $data = Jobdesc::findOrFail($key);
            $data->delete();
            return $this->sendResponse(null, "Berhasil menghapus data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function cancel(Request $req)
    {
        try {
            $key = str_replace("Jobdesc", "", decrypt($req->key));
            $data = Jobdesc::findOrFail($key);
            $data->update([
                'status' => 4,
            ]);
            return $this->sendResponse(null, "Berhasil Membatalkan Jobdesc.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses update data, silahkan hubungi admin");
        }
    }

    public function verifikasi(Request $req)
    {
        try {
            $key = str_replace("Jobdesc", "", decrypt($req->key));
            $data = Jobdesc::findOrFail($key);
            $data->update([
                'status' => 5,
            ]);
            return $this->sendResponse(null, "Berhasil Memverifikasi Jobdesc.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses update data, silahkan hubungi admin");
        }
    }
}
