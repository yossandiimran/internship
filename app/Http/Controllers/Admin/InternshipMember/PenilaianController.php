<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Pdf;
use Auth;
use Validator;

class PenilaianController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.internshipMember.penilaian.index');
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $user = Auth::user();
        $data = Penilaian::with([
            'user.jurusanDetail',
        ])->where('user', $user->email)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('action', function ($val) {
                $key = encrypt("penilaian" . $val->id);
                $html = '<div class="btn-group">';
                $html .= '<a target="_blank" href="' . url('/admin/InternshipMember/penilaian/downloadSertifikat') . '/' . $key . '" class="btn btn-success btn-sm btn-download" title="Download Sertifikat"><i class="fas fa-download"></i> Download</a>&nbsp;';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'foto', 'status_internship', 'pemohon_lain'])
            ->make(true);
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

    /**
     * Return sap bus settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("penilaian", "", decrypt($req->key));
            $data = Penilaian::select('*')->whereId($key)->firstOrFail();
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
                $data = Penilaian::create([
                    'divisi' => $req->divisi,
                    'lokasi' => $req->lokasi,
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("penilaian", "", decrypt($req->key));
                $data = Penilaian::findOrFail($key);

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
