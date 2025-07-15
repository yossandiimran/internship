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
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('status', function ($val) {
                if ($val->status == 1) {
                    $html = '<button class="btn btn-primary btn-sm" title="Tugas Baru"><i class="fas fa-star"></i>&nbsp;&nbsp; Task Baru</button>';
                } else if ($val->status == 2) {
                    $html = '<button class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-clock"></i>&nbsp;&nbsp; Sedang Dikerjakan</button>';
                } else if ($val->status == 3) {
                    $html = '<button class="btn btn-success btn-sm" title="Edit"><i class="fas fa-check"></i>&nbsp;&nbsp; Selesai</button>';
                } else if ($val->status == 4) {
                    $html = '<button class="btn btn-danger btn-sm" title="Edit"><i class="fas fa-times"></i>&nbsp;&nbsp; Dibatalkan</button>';
                } else if ($val->status == 5) {
                    $html = '<button class="btn btn-secondary btn-sm" title="Edit"><i class="fas fa-clock"></i>&nbsp;&nbsp; Pending</button>';
                }

                return $html;
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("Jobdesc" . $val->id);
                $html = '<div class="btn-group">';
                if ($val->status == 1) {
                    $html .= '<button class="btn btn-primary btn-sm btn-edit" data-key="' . $key . '" title="Edit"><i class="fas fa-edit"></i></button>';
                    $html .= '<button class="btn btn-warning btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 2) {
                    $html .= '<button class="btn btn-primary btn-sm btn-edit" data-key="' . $key . '" title="Edit"><i class="fas fa-edit"></i></button>';
                    $html .= '<button class="btn btn-warning btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 3) {
                    $html .= '<button class="btn btn-primary btn-sm btn-edit" data-key="' . $key . '" title="Edit"><i class="fas fa-edit"></i></button>';
                    $html .= '<button class="btn btn-warning btn-sm btn-cancel" data-key="' . $key . '" title="Batalkan"><i class="fas fa-times"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 4) {
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                } else if ($val->status == 5) {
                    $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                }


                $html .= '</div>';
                return $html;
            })
            ->addColumn('created_at', function ($val) {
                return Carbon::parse($val->created_at)->format('d-m-Y H:i');
            })
            ->rawColumns(['action', 'foto', 'status', 'pemohon_lain'])
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
}
