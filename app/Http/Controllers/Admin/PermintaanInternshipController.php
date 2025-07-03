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

class PermintaanInternshipController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.permintaanInternship.index', [
            'divisi' => MasterDivisi::all(),
        ]);
    }

    public function downloadSuratBalasan($keys)
    {
        $key = str_replace("surat", "", decrypt($keys));
        $data = SuratBalasan::with(['statusDetail', 'pemohonUtama', 'pemohon'])->findOrFail($key);

        $pdf = Pdf::loadView('pdf.suratBalasan', compact('data'))->setPaper('A4', 'portrait');

        $filename = 'Surat-Balasan-' . $data->nomor_surat_balasan . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = SuratBalasan::with([
            'statusDetail',
            'pemohonUtama',
            'pemohon',
        ])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('status_surat', function ($val) {
                if ($val->statusDetail->id == 1) {
                    return '<button class="btn btn-primary btn-sm">' . $val->statusDetail->status . '</button>';
                } else if ($val->statusDetail->id == 2) {
                    return '<button class="btn btn-warning btn-sm">' . $val->statusDetail->status . '</button>';
                } else if ($val->statusDetail->id == 3) {
                    return '<button class="btn btn-danger btn-sm">' . $val->statusDetail->status . '</button>';
                } else if ($val->statusDetail->id == 4) {
                    return '<button class="btn btn-warning btn-sm">' . $val->statusDetail->status . '</button>';
                } else if ($val->statusDetail->id == 5) {
                    return '<button class="btn btn-success btn-sm">' . $val->statusDetail->status . '</button>';
                } else if ($val->statusDetail->id == 6) {
                    return '<button class="btn btn-secondary btn-sm">' . $val->statusDetail->status . '</button>';
                }
            })
            ->addColumn('pemohon_lain', function ($val) {
                $html = '<ul>';
                foreach ($val->pemohon as $pm) {
                    $html .= '<li>' . $pm->nama_pemohon . ' (' . $pm->jurusan->jurusan . ')</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('asal_sekolah', function ($val) {
                return $val->pemohonUtama->asal_sekolah;
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("surat" . $val->id);
                $html = '<div class="btn-group">';

                $html .= '<button class="btn btn-primary btn-sm btn-view" data-key="' . $key . '" title="Detail"><i class="fas fa-eye"></i></button>';

                if ($val->statusDetail->id == 1) {
                    $html .= '<button class="btn btn-warning btn-sm btn-proses" data-key="' . $key . '" title="Proses Pengajuan"><i class="fas fa-check"></i></button>';
                    //  $html .= '<button class="btn btn-danger btn-sm btn-tolak" data-key="'.$key.'" title="Tolak Pengajuan"><i class="fas fa-times"></i></button>';
                } else if ($val->statusDetail->id == 2) {
                    $html .= '<button class="btn btn-danger btn-sm btn-tolak" data-key="' . $key . '" title="Tolak Pengajuan"><i class="fas fa-times"></i></button>';
                } else if ($val->statusDetail->id == 3) {
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                } else if ($val->statusDetail->id == 4) {
                    $html .= '<button class="btn btn-danger btn-sm btn-tolak" data-key="' . $key . '" title="Batalkan Pengajuan"><i class="fas fa-times"></i></button>';
                    //  $html .= '<button class="btn btn-danger btn-sm btn-tolak" data-key="'.$key.'" title="Tolak Pengajuan"><i class="fas fa-times"></i></button>';
                    //  $html .= '<button class="btn btn-success btn-sm btn-acc" data-key="'.$key.'" title="Acc Pengajuan"><i class="fas fa-check"></i></button>';
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                } else if ($val->statusDetail->id == 5) {
                    $html .= '<button class="btn btn-secondary btn-sm btn-selesai" data-key="' . $key . '" title="Selesai"><i class="fas fa-check-circle"></i></button>';
                    $html .= '<button class="btn btn-danger btn-sm btn-tolak" data-key="' . $key . '" title="Batalkan Pengajuan"><i class="fas fa-times"></i></button>';
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'foto', 'status_surat', 'pemohon_lain'])
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
