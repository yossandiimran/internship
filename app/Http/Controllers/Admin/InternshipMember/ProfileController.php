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

}
