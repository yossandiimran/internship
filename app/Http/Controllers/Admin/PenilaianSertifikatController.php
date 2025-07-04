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

                $html .= '<button class="btn btn-success btn-sm btn-view" data-key="' . $key . '" title="Downlad Sertifikat"><i class="fas fa-download"></i></button>';
                $html .= '<button class="btn btn-primary btn-sm btn-edit" data-key="' . $key . '" title="Edit"><i class="fas fa-edit"></i></button>';

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
            $data = SuratBalasan::with([
                'statusDetail',
                'pemohon.pemohon.jurusanDetail',
                'pemohon.divisi',
                'pemohonUtama.jurusanDetail',
            ])->whereId($key)->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }

    public function uploadSuratBalasan(Request $req)
    {
        $validator = Validator::make($req->input(), [
            'key_proses' => 'nullable|string',
            'tanggal_surat_balasan' => 'nullable|string',
            'nomor_surat_balasan' => 'nullable|string',
        ]);

        if ($req->file('ttd_digital')) {
            $suratPengantar = $req->file('ttd_digital')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            $key = str_replace("penilaian", "", decrypt($req->key_proses));
            $data = SuratBalasan::findOrFail($key);
            $data->update([
                'status_surat' => $req->status_surat,
                'pembimbing' => $req->pembimbing,
                'nomor_surat_balasan' => $req->nomor_surat_balasan,
                'tanggal_surat_balasan' => $req->tanggal_surat_balasan,
                'periode_awal' => $req->periode_awal,
                'periode_akhir' => $req->periode_akhir,
                'ttd_digital' => $suratPengantar,
            ]);
            
            if ($req->anggota) {
                foreach ($req->anggota as $ag) {
                    SuratBalasanPemohon::where('email', $ag['email'])->update([
                        'id_divisi' => $ag['divisi']
                    ]);
                }
            }

            return $this->sendResponse(null, "Berhasil memproses data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            dd($err);
            return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
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
