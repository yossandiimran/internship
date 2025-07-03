<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterJurusan;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Validator;
use Pdf;

class InternshipController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {

        $usr = Auth::user()->load('jurusanDetail');
        $pengajuan = SuratBalasan::with([
            'statusDetail',
            'pemohonUtama',
            'pemohon'
        ])
            ->rightJoin('surat_balasan_pemohon as sbp', 'sbp.id_surat', '=', 'surat_balasan.id')
            ->where('sbp.email', $usr->email)
            ->select('surat_balasan.*')
            ->orderBy('id', 'desc')
            ->first();
        $pemohon = User::where('is_internship', true)->with('jurusanDetail')->get();
        return view('admin.internshipMember.internship.index', [
            'user' => $usr,
            'pemohon' => $pemohon,
            'jurusan' => MasterJurusan::all(),
            'pengajuan' => $pengajuan,
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


    public function getInternshipUser()
    {
        $users = User::where('is_internship', true)->get();
        return response()->json($users);
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
            'pemohon'
        ])
            ->rightJoin('surat_balasan_pemohon as sbp', 'sbp.id_surat', '=', 'surat_balasan.id')
            ->where('sbp.email', $user->email)
            ->select('surat_balasan.*')
            ->get();
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
                $pemohonLain = SuratBalasanPemohon::where('id_surat', $val->id)->with('jurusan')->get();
                $html = '<ul>';
                foreach ($pemohonLain as $pm) {
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
                    //  $html .= '<button class="btn btn-warning btn-sm btn-proses" data-key="'.$key.'" title="Proses Pengajuan"><i class="fas fa-check"></i></button>';
                } else if ($val->statusDetail->id == 2) {
                    // $html .= '<button class="btn btn-secondary btn-sm btn-proses" data-key="' . $key . '" title="Upload Surat MOU"><i class="fas fa-upload"></i></button>';
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                } else if ($val->statusDetail->id == 3) {
                    // $html .= '<button class="btn btn-secondary btn-sm btn-proses" data-key="' . $key . '" title="Upload Surat MOU"><i class="fas fa-upload"></i></button>';
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                } else if ($val->statusDetail->id == 4) {
                    $html .= '<button class="btn btn-secondary btn-sm btn-proses" data-key="' . $key . '" title="Upload Surat MOU"><i class="fas fa-upload"></i></button>';
                    // $html .= '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                } else if ($val->statusDetail->id == 5) {
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
    public function store(Request $req)
    {
        $pwRules = 'nullable';
        $user = Auth::user();

        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
        ]);

        if ($req->file('file_surat_pengantar')) {
            $suratPengantar = $req->file('file_surat_pengantar')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if (empty($req->key)) {
                // Create Data
                $data = SuratBalasan::create([
                    'id_pemohon' => $user->id,
                    'tanggal_surat_pengantar' => $req->tanggal_surat_pengantar,
                    'asal_sekolah_pemohon' => $req->asal_sekolah_pemohon,
                    'nomor_surat_pengantar' => $req->nomor_surat_pengantar,
                    'status_surat' => '1',
                    'file_surat_pengantar' => $suratPengantar,
                ]);

                $data2 = SuratBalasanPemohon::create([
                    'id_surat' => $data->id,
                    'email' => $user->email,
                    'no_hp' => $user->no_hp,
                    'nim' => $user->nim,
                    'nama_pemohon' => $user->name,
                    'id_jurusan' => $user->jurusan,
                ]);
                
                if ($req->anggota) {
                    foreach ($req->anggota as $ag) {
                        SuratBalasanPemohon::create([
                            'id_surat' => $data->id,
                            'email' => $ag["email"],
                            'no_hp' => $ag["no_hp"],
                            'nim' => $ag["nim"],
                            'nama_pemohon' => $ag["nama"],
                            'id_jurusan' => $ag["jurusan"],
                        ]);
                    }
                }
            } else {
                // Validation
                $key = str_replace("surat", "", decrypt($req->key));
                $data = MasterDivisi::findOrFail($key);

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

    public function uploadMou(Request $req)
    {
        $validator = Validator::make($req->input(), [
            'key_proses' => 'nullable|string',
            'tanggal_surat_mou' => 'nullable|string',
            'nomor_surat_mou' => 'nullable|string',
        ]);

        if ($req->file('file_surat_mou')) {
            $suratPengantar = $req->file('file_surat_mou')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            $key = str_replace("surat", "", decrypt($req->key_proses));
            $data = SuratBalasan::findOrFail($key);
            $data->update([
                'status_surat' => '5',
                'tanggal_surat_mou' => $req->tanggal_surat_mou,
                'nomor_surat_mou' => $req->nomor_surat_mou,
                'file_surat_mou' => $suratPengantar,
            ]);
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
}
