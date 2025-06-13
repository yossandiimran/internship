<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterStatusSurat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;

class MasterStatusSuratController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.master.statusSurat.index');
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $data = MasterStatusSurat::select('*')->orderBy('id');
        return DataTables::of($data)
                ->addIndexColumn()
                ->removeColumn('id')
                ->addColumn('action', function($val) {
                    $key = encrypt("statusSurat".$val->id);
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
            $key = str_replace("statusSurat", "", decrypt($req->key));
            $data = MasterStatusSurat::select('*')->whereId($key)->firstOrFail();
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
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if(empty($req->key)){
                // Create Data
                $data = MasterStatusSurat::create([
                    'status' => $req->status,
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("statusSurat", "", decrypt($req->key));
                $data = MasterStatusSurat::findOrFail($key);

                if(!$req->file('foto')){
                    $foto = $data->foto;
                }
                // Update Data
                $data->update([
                    'status' => $req->status,
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
            $key = str_replace("statusSurat", "", decrypt($req->key));
            $data = MasterStatusSurat::findOrFail($key);
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
