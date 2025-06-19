<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Validator;

class InternshipController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        $data['user'] = Auth::user();
        return view('admin.internshipMember.internship.index', $data);
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = SuratBalasan::select('*')->where('id_pemohon',  $user->id);
        return DataTables::of($data)
                ->addIndexColumn()
                ->removeColumn('id')
                ->addColumn('action', function($val) {
                    $key = encrypt("surat".$val->id);
                    return '<div class="btn-group">'.
                                '<button class="btn btn-warning btn-sm btn-edit" data-key="'.$key.'" title="Ubah Data"><i class="fas fa-pen"></i></button>'.
                                '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>'.
                            '</div>';
                })
                ->rawColumns(['action', 'foto', 'status'])
                ->make(true);
    }

    /**
     * Return sap bus settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("surat", "", decrypt($req->key));
            $data = MasterDivisi::select('*')->whereId($key)->firstOrFail();
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

        if($req->file('file_surat_pengantar')){
            $suratPengantar = $req->file('file_surat_pengantar')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if(empty($req->key)){
                // Create Data
                $data = SuratBalasan::create([
                    'id_pemohon' => $user->id,
                    'tanggal_surat_pengantar' => $req->tanggal_surat_pengantar,
                    'asal_sekolah_pemohon' => $req->asal_sekolah_pemohon,
                    'nomor_surat_pengantar' => $req->nomor_surat_pengantar,
                    'file_surat_pengantar' => $suratPengantar,
                ]);

                $data2 = SuratBalasanPemohon::create([
                    'id_surat' => $data->id,
                    'email' => $user->email,
                    'nama_pemohon' => $user->name,
                ]);
                

                // Save Log
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
