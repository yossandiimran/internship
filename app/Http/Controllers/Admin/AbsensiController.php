<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\MasterDivisi;
use App\Models\MasterJurusan;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Carbon;
use DB;

class AbsensiController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.absensi.index', [
            'divisi' => MasterDivisi::all(),
            'jurusan' => MasterJurusan::all(),
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
            ->select('surat_balasan_pemohon.*');

        if ($req->filterData) {
            $filter = [];
            parse_str($req->filterData, $filter);
            if (!empty($filter['filter-status']) && trim($filter['filter-status']) != '') {
                $data->where('sb.status_surat', $filter['filter-status']);
            } else {
                $data->where('sb.status_surat', '5');
            }
            if (!empty($filter['filter-divisi']) && trim($filter['filter-divisi']) != '') {
                $data->where('id_divisi', $filter['filter-divisi']);
            }
            if (!empty($filter['filter-jurusan']) && trim($filter['filter-jurusan']) != '') {
                $data->where('id_jurusan', $filter['filter-jurusan']);
            }
        } else {
            $data->where('sb.status_surat', '5');
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('asal_sekolah', function ($val) {
                return $val->pemohon->asal_sekolah;
            })
            ->addColumn('divisi', function ($val) {
                return $val->divisi->divisi;
            })
            ->addColumn('periode_internship', function ($val) {
                return '<b>' . $val->header->periode_awal . '</b><br>s/d<br><b>' . $val->header->periode_akhir . '</b>';
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("peserta" . $val->email);
                $html = '<div class="btn-group">';

                $html .= '<button class="btn btn-warning btn-sm btn-view" data-key="' . $key . '" title=""><i class="fas fa-calendar"></i>&nbsp;&nbsp;Lihat Absensi</button>';

                if ($val->header->statusDetail->id == 5) {
                } else if ($val->header->statusDetail->id == 6) {
                    $html .= '<a target="_blank" href="' . url('/admin/peserta/downloadSertifikat') . '/' . $key . '/' . $val->header->id . '" class="btn btn-success btn-sm btn-download" title="Downlad Sertifikat"><i class="fas fa-download"></i></a>&nbsp;';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'periode_internship', 'status_internship', 'divisi'])
            ->make(true);
    }

    public function detail(Request $req)
    {
        try {
            $key = str_replace("peserta", "", decrypt($req->key));

            if ($req->tgl_awal == null) {
                $tglAwal = now()->startOfMonth()->toDateString();
                $tglAkhir = now()->endOfMonth()->toDateString();
            } else {
                $tglAwal = $req->tgl_awal;
                $tglAkhir = $req->tgl_akhir ?? $tglAwal;
            }

            $data = User::with(['kehadiran' => function ($q) use ($tglAwal, $tglAkhir) {
                $q->whereBetween('created_at', [
                    Carbon::parse($tglAwal)->startOfDay(),
                    Carbon::parse($tglAkhir)->endOfDay()
                ]);
            }])
                ->where('email', $key)
                ->firstOrFail();

            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }
}
