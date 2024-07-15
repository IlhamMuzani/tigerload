<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProjectController extends Controller
{
    public function qrcode_detail($encodedId)
    {
        try {
            // Decode the base64 string and decrypt it to get the original ID
            $decodedId = base64_decode($encodedId . str_repeat('=', strlen($encodedId) % 4));
            $id = Crypt::decryptString($decodedId);
        } catch (DecryptException $e) {
            // Handle error if ID cannot be decrypted
            return abort(404, 'Invalid encoded ID');
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