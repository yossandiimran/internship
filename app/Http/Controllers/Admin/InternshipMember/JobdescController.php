<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobDesc;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Validator;

class JobdescController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.internshipMember.jobdesc.index');
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $usr = Auth::user()->load('jurusanDetail');
        $data = Jobdesc::with([
            'assignTo.divisi',
        ])
            ->where('assign_to', $usr->email)
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
                $key = encrypt("jobdesc" . $val->id);
                if ($val->status == 1) {
                    return '<div class="btn-group">' .
                        '<button class="btn btn-warning btn-sm btn-kerjakan" data-key="' . $key . '" title="Kerjakan"><i class="fas fa-pen"></i> Kerjakan Tugas</button>' .
                        '<button class="btn btn-danger btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i> Batalkan Tugas</button>';

                    '</div>';
                } else if ($val->status == 2) {
                    return '<div class="btn-group">' .
                        '<button class="btn btn-success btn-sm btn-selesaikan" data-key="' . $key . '" title="Selesaikan"><i class="fas fa-check"></i> Selesaikan Tugas</button>' .
                        '<button class="btn btn-danger btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i> Batalkan Tugas</button>';

                    '</div>';
                } else if ($val->status == 3) {
                    return '<div class="btn-group"> # </div>';
                } else if ($val->status == 4) {
                    return '<div class="btn-group"> # </div>';
                } else if ($val->status == 5) {
                    return '<div class="btn-group"> # </div>';
                }
            })
            ->rawColumns(['action', 'waktu_mulai', 'waktu_akhir', 'status', 'pekerjaan'])
            ->make(true);
    }

    /**
     * Return sap bus settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("jobdesc", "", decrypt($req->key));
            $data = JobDesc::select('*')->whereId($key)->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }


    /**
     * Store create or update sap bus settings
     */
    public function store(Request $req)
    {
        $pwRules = 'nullable';

        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
            'divisi' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        if ($req->file('foto')) {
            $foto = $req->file('foto')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if (empty($req->key)) {
                // Create Data
                $data = JobDesc::create([
                    'divisi' => $req->divisi,
                    'lokasi' => $req->lokasi,
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("jobdesc", "", decrypt($req->key));
                $data = JobDesc::findOrFail($key);

                // Update Data
                $data->update([
                    'divisi' => $req->divisi,
                    'lokasi' => $req->lokasi,
                ]);
            }
            return $this->sendResponse(null, "Berhasil memproses data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
        }
    }

    public function destroy(Request $req)
    {
        try {
            // Validation
            $key = str_replace("jobdesc", "", decrypt($req->key));
            $data = JobDesc::findOrFail($key);
            // Delete Process
            $data->delete();
            return $this->sendResponse(null, "Berhasil menghapus data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function kerjakan(Request $req)
    {
        try {
            if ($req->file('gambar_awal')) {
                $file = $req->file('gambar_awal')->store('uploads', 'public');
            }
            $key = str_replace("jobdesc", "", decrypt($req->key));
            $data = JobDesc::findOrFail($key);
            $data->update([
                'status' => 2,
                'gambar_awal' => $file,
                'waktu_mulai' => now(),
            ]);
            return $this->sendResponse(null, "Berhasil Mengerjakan Tugas.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            dd($err);
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function selesaikan(Request $req)
    {
        try {
            if ($req->file('gambar_akhir')) {
                $file = $req->file('gambar_akhir')->store('uploads', 'public');
            }
            $key = str_replace("jobdesc", "", decrypt($req->key));
            $data = JobDesc::findOrFail($key);
            $data->update([
                'status' => 3,
                'gambar_akhir' => $file,
                'waktu_akhir' => now(),
            ]);
            return $this->sendResponse(null, "Berhasil Mengerjakan Tugas.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            dd($err);
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function cancel(Request $req)
    {
        try {
            $key = str_replace("jobdesc", "", decrypt($req->key));
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
}
