<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan_pembayaran;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PenerimaanpembayaranController extends Controller
{
    public function detail($encryptedId)
    {
        try {
            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            // Tangani kesalahan jika ID tidak dapat didekripsi
            return abort(404, 'Invalid encrypted ID');
        }

        // Retrieve the main record
        $cetakpdf = Penerimaan_pembayaran::where('id', $id)->first();

        // Check if the main record exists
        if (!$cetakpdf) {
            return abort(404, 'Penerimaan pembayaran not found');
        }

        return view('admin.penerimaan_pembayaran.qrcode_detail', compact('cetakpdf'));
    }
}