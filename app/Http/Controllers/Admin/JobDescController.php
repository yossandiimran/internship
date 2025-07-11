<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterDivisi;
use App\Models\SuratBalasanPemohon;
use App\Models\Jobdesc;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Pdf;
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
            'user.jurusanDetail',
        ])
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('action', function ($val) {
                $key = encrypt("Jobdesc" . $val->id);
                $html = '<div class="btn-group">';

                $html .= '<a target="_blank" href="'.url('/admin/sertifikat/downloadSertifikat').'/'.$key.'" class="btn btn-success btn-sm btn-download" title="Downlad Sertifikat"><i class="fas fa-download"></i></a>&nbsp;';
                $html .= '<button class="btn btn-primary btn-sm btn-view" data-key="' . $key . '" title="Edit"><i class="fas fa-edit"></i></button>';
                $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="' . $key . '" title="Hapus"><i class="fas fa-trash"></i></button>';

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'foto', 'status_internship', 'pemohon_lain'])
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
                ]);

            } else {
                // Validation
                $key = str_replace("Jobdesc", "", decrypt($req->key));
                $data = Jobdesc::findOrFail($key);

                // Update Data
                $data->update([
                    "kedisiplinan" => $req->kedisiplinan,
                    "tanggung_jawab" => $req->tanggung_jawab,
                    "kerapihan" => $req->kerapihan,
                    "komunikasi" => $req->komunikasi,
                    "pemahaman_pekerjaan" => $req->pemahaman_pekerjaan,
                    "manahemen_waktu" => $req->manajemen_waktu,
                    "kerja_sama" => $req->kerja_sama,
                    "kriteria" => $req->kriteria,
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
            // Validation
            $key = str_replace("Jobdesc", "", decrypt($req->key));
            $data = Jobdesc::findOrFail($key);
            // Delete Process
            $data->delete();
            return $this->sendResponse(null, "Berhasil menghapus data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }
}
