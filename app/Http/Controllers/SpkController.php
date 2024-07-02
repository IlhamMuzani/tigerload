<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spk;
use App\Models\Detail_suratpenawaran;
use App\Models\Kendaraan;
use App\Models\Typekaroseri;
use App\Models\Spesifikasi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SpkController extends Controller
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
                
        $pembelians = Spk::where('id', $id)->first();

        // Check if the main record exists
        if (!$pembelians) {
            return abort(404, 'Surat Penawaran not found');
        }

        // Retrieve the related records
        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();

        // Check if the related records exist
        if (!$karoseries) {
            return abort(404, 'Typekaroseri not found');
        }

        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        return view('admin.surat_penawaran.qrcode_detail', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }
}