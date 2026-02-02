<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\MasterDivisi;
use App\Models\MasterJurusan;
use App\Models\SuratBalasan;
use App\Models\SuratBalasanPemohon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;
use Pdf;
use DB;

class PesertaInternshipController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.pesertaInternship.index', [
            'divisi' => MasterDivisi::all(),
            'jurusan' => MasterJurusan::all(),
        ]);
    }

    public function downloadSertifikat($keys, $id_surat_balasan)
    {
        // decrypt param safely
        try {
            $decrypted = decrypt($keys);
            $key = str_replace("peserta", "", $decrypted);
        } catch (DecryptException $e) {
            return $this->sendError("Tautan tidak valid atau sudah kedaluwarsa.");
        } catch (\Throwable $e) {
            return $this->sendError("Kesalahan saat memproses permintaan.");
        }

        try {
            $data = Penilaian::where('user', $key)
                ->where('id_surat_balasan', $id_surat_balasan)
                ->firstOrFail();

            // give more time for PDF generation (temporary mitigation)
            if (!ini_get('max_execution_time') || (int)ini_get('max_execution_time') < 120) {
                ini_set('max_execution_time', 300);
            }
            set_time_limit(300);

            $pdf = Pdf::loadView('pdf.sertifikat', [
                'data' => $data,
            ])->setPaper('A4', 'landscape');

            // prevent DOMPDF from attempting remote http/https fetches
            try {
                $pdf->setOptions([
                    'isRemoteEnabled' => false,
                    'isHtml5ParserEnabled' => true,
                ]);
            } catch (\Throwable $e) {
                // not critical, continue
            }

            $safeNumber = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $data->nomor_surat_balasan ?? 'unknown');
            $filename = 'Sertifikat-' . $safeNumber . '.pdf';

            return $pdf->stream($filename);
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $e) {
            \Log::error('downloadSertifikat error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->sendError("Kesalahan sistem saat menghasilkan sertifikat.");
        }
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
            }else{
                $data->where('sb.status_surat', '5');
            }
            if (!empty($filter['filter-periode_awal']) || !empty($filter['filter-periode_akhir'])) {
                if (empty($filter['filter-periode_akhir'])) {
                    $data->whereDate("sb.periode_awal", ">=", $filter['filter-periode_awal']);
                } else if (empty($filter['filter-periode_awal'])) {
                    $data->whereDate("sb.periode_awal", "<=", $filter['filter-periode_akhir']);
                } else {
                    $data->whereBetween(DB::raw('sb.periode_awal::date'), [$filter['filter-periode_awal'], $filter['filter-periode_akhir']]);
                }
            }
            if (!empty($filter['filter-divisi']) && trim($filter['filter-divisi']) != '') {
                $data->where('id_divisi', $filter['filter-divisi']);
            }
            if (!empty($filter['filter-jurusan']) && trim($filter['filter-jurusan']) != '') {
                $data->where('id_jurusan', $filter['filter-jurusan']);
            }
        }else{
            $data->where('sb.status_surat', '5');
        }

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
            ->addColumn('divisi', function ($val) {
                return $val->divisi->divisi;
            })
            ->addColumn('periode_internship', function ($val) {
                return '<b>'.$val->header->periode_awal . '</b><br>s/d<br><b>' . $val->header->periode_akhir.'</b>' ;
            })
            ->addColumn('action', function ($val) {
                $key = encrypt("peserta" . $val->email);
                $html = '<div class="btn-group">';

                $html .= '<button class="btn btn-primary btn-sm btn-view" data-key="' . $key . '" title="Detail"><i class="fas fa-eye"></i></button>';

                if ($val->header->statusDetail->id == 5) {
                } else if ($val->header->statusDetail->id == 6) {
                    $html .= '<a target="_blank" href="' . url('/admin/peserta/downloadSertifikat') . '/' . $key . '/'.$val->header->id.'" class="btn btn-success btn-sm btn-download" title="Downlad Sertifikat"><i class="fas fa-download"></i></a>&nbsp;';
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
            $data = SuratBalasanPemohon::with([
                'divisi',
                'jurusan',
                'pemohon',
                'header.statusDetail',
            ])
                ->select('surat_balasan_pemohon.*')
                ->where('email', $key)->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }
}
