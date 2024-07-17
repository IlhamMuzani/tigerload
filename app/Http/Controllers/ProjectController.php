<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProjectController extends Controller
{
    public function qrcode_detail($kode)
    {
        $cetakpdf = Project::where('kode_project', $kode)->first();

        if (!$cetakpdf) {
            abort(404, 'Project not found');
        }

        return view('admin.project.qrcode_detail', compact('cetakpdf'));
    }
}