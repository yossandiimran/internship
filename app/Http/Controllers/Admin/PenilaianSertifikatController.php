<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterJurusan;
use App\Models\MasterDivisi;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
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
        return view('admin.penilaian.index', [
            'divisi' => MasterDivisi::all(),
        ]);
    }
    
    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = SuratBalasanPemohon::with([
            'divisi',
            'jurusan',
            'pemohon',
            'header.statusDetail',
        ])
        ->join('surat_balasan as sb', 'sb.id', '=', 'surat_balasan_pemohon.id_surat')
        ->where('sb.status_surat', '>=', 4)
        ->select('surat_balasan_pemohon.*')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('status_internship', function ($val) {
                if ($val->header->statusDetail->id == 1) {
                    return '<button class="btn btn-primary btn-sm">' . $val->header->statusDetail->status . '</button>';
                } else if ($val->header->statusDetail->id == 2) {
                    return '<button class="btn btn-warning btn-sm">' . $val->header->statusDetail->status . '</button>';
                } else if ($val->header->statusDetail->id == 3) {
                    return '<button class="btn btn-danger btn-sm">' . $val->header->statusDetail->status . '</button>';
                } else if ($val->header->statusDetail->id == 4) {
                    return '<button class="btn btn-warning btn-sm">' . $val->header->statusDetail->status . '</button>';
                } else if ($val->header->statusDetail->id == 5) {
                    return '<button class="btn btn-success btn-sm">' . $val->header->statusDetail->status . '</button>';
                } else if ($val->header->statusDetail->id == 6) {
                    return '<button class="btn btn-secondary btn-sm">' . $val->header->statusDetail->status . '</button>';
                }
            })
            ->addColumn('asal_sekolah', function ($val) {
                return $val->pemohon->asal_sekolah;
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("surat" . $val->id);
                $html = '<div class="btn-group">';

                $html .= '<button class="btn btn-primary btn-sm btn-view" data-key="' . $key . '" title="Detail"><i class="fas fa-eye"></i></button>';

                if ($val->header->statusDetail->id == 5) {
                    $html .= '<button class="btn btn-warning btn-sm btn-absensi" data-key="' . $key . '" title="Absensi"><i class="fas fa-calendar"></i></button>';
                    $html .= '<button class="btn btn-default btn-sm btn-sertifikat" data-key="' . $key . '" title="Nilai & Sertifikat"><i class="fas fa-star"></i></button>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'foto', 'status_internship', 'pemohon_lain'])
            ->make(true);
    }

    /**
     * Return sap bus settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("surat", "", decrypt($req->key));
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


    /**
     * Store create or update sap bus settings
     */
    public function uploadSuratBalasan(Request $req)
    {
        $validator = Validator::make($req->input(), [
            'key_proses' => 'nullable|string',
            'tanggal_surat_balasan' => 'nullable|string',
            'nomor_surat_balasan' => 'nullable|string',
        ]);

        // if($req->file('file_surat_balasan')){
        //     $suratPengantar = $req->file('file_surat_balasan')->store('uploads', 'public');
        // }

        if ($req->file('ttd_digital')) {
            $suratPengantar = $req->file('ttd_digital')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            $key = str_replace("surat", "", decrypt($req->key_proses));
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
            $key = str_replace("surat", "", decrypt($req->key));
            $data = MasterDivisi::findOrFail($key);
            // Delete Process
            $data->delete();
            return $this->sendResponse(null, "Berhasil menghapus data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function accDivisi(Request $req)
    {
        try {
            // Validation
            $key = str_replace("surat", "", decrypt($req->key));
            $data = SuratBalasan::findOrFail($key);


            $data->update([
                'status_surat' => '5'
            ]);

            foreach ($req->anggota as $ag) {
                SuratBalasanPemohon::where('email', $ag['email'])->update([
                    'id_divisi' => $ag['divisi']
                ]);
            }
            return $this->sendResponse(null, "Proses Berhasil.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            dd($err);
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function tolak(Request $req)
    {
        try {
            // Validation
            $key = str_replace("surat", "", decrypt($req->key));
            $data = SuratBalasan::findOrFail($key);
            // Delete Process
            $data->update([
                'status_surat' => '3'
            ]);
            return $this->sendResponse(null, "Proses Berhasil.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

    public function selesai(Request $req)
    {
        try {
            // Validation
            $key = str_replace("surat", "", decrypt($req->key));
            $data = SuratBalasan::findOrFail($key);
            // Delete Process
            $data->update([
                'status_surat' => '6'
            ]);
            return $this->sendResponse(null, "Proses Berhasil.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }
}
