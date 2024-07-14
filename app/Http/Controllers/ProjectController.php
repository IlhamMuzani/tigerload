<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProjectController extends Controller
{
    // public function detail($encryptedId)
    // {
    //     try {
    //         // Dekripsi ID
    //         $id = Crypt::decryptString($encryptedId);
    //     } catch (DecryptException $e) {
    //         // Tangani kesalahan jika ID tidak dapat didekripsi
    //         return abort(404, 'Invalid encrypted ID');
    //     }

    //     // Retrieve the main record
    //     $cetakpdf = Project::where('id', $id)->first();

    //     // Check if the main record exists
    //     if (!$cetakpdf) {
    //         return abort(404, 'Project not found');
    //     }

    //     return view('admin.project.detail', compact('cetakpdf'));
    // }

   public function qrcode_detail($encryptedId)
    {
        try {
            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            // Tangani kesalahan jika ID tidak dapat didekripsi
            return abort(404, 'Invalid encrypted ID');
        }

        // Retrieve the main record
        $cetakpdf = Project::where('id', $id)->first();

        // Check if the main record exists
        if (!$cetakpdf) {
            return abort(404, 'Project not found');
        }

        return view('admin.project.qrcode_detail', compact('cetakpdf'));
    }
}