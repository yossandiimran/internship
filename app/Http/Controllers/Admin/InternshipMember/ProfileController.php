<?php

namespace App\Http\Controllers\Admin\InternshipMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterDivisi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;

class ProfileController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        $data['user'] = Auth::user();
        return view('admin.internshipMember.profile.index', $data);
    }

    public function updateProfile(Request $req)
    {
        $user = Auth::user();

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'nim' => 'required|string',
            'asal_sekolah' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'name' => $req->name,
            'alamat' => $req->alamat,
            'no_hp' => $req->no_hp,
            'kota' => $req->kota,
            'provinsi' => $req->provinsi,
            'nim' => $req->nim,
            'asal_sekolah' => $req->asal_sekolah,
        ]);

        return response()->json(['message' => 'Profile berhasil diupdate!']);
    }
}
