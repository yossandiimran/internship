<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterJurusan;
use App\Models\MasterDivisi;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Pdf;
use Validator;

class PenilaianSertifikatController extends Controller
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
        ->where('sb.status_surat', '>=', 4)
        ->select('surat_balasan_pemohon.*')
        ->get();

        return view('admin.penilaian.index', [
            'divisi' => MasterDivisi::all(),
            'pemohon' => $pemohon,
        ]);
    }
    
    public function downloadSertifikat($keys)
    {
        $key = str_replace("penilaian", "", decrypt($keys));
        $data = Penilaian::findOrFail($key);

        $pdf = Pdf::loadView('pdf.sertifikat', [
            'data' => $data,
        ])->setPaper('A4', 'landscape');

        $filename = 'Sertifikat-' . $data->nomor_surat_balasan . '.pdf';

        return $pdf->stream($filename);
    }
    
    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = Penilaian::with([
            'user.jurusanDetail',
        ])
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('action', function ($val) {
                $key = encrypt("penilaian" . $val->id);
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
                $data = Penilaian::create([
                    "nomor_surat_penilaian" => $req->nomor_surat_penilaian,
                    "user" => $req->user,
                    "kedisiplinan" => $req->kedisiplinan,
                    "tanggung_jawab" => $req->tanggung_jawab,
                    "kerapihan" => $req->kerapihan,
                    "komunikasi" => $req->komunikasi,
                    "pemahaman_pekerjaan" => $req->pemahaman_pekerjaan,
                    "manahemen_waktu" => $req->manajemen_waktu,
                    "kerja_sama" => $req->kerja_sama,
                    "kriteria" => $req->kriteria,
                ]);

            } else {
                // Validation
                $key = str_replace("penilaian", "", decrypt($req->key));
                $data = Penilaian::findOrFail($key);

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
            $key = str_replace("penilaian", "", decrypt($req->key));
            $data = Penilaian::with([
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
            $key = str_replace("penilaian", "", decrypt($req->key));
            $data = Penilaian::findOrFail($key);
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
