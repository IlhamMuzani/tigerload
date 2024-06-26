<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat_penawaran;
use App\Models\Detail_suratpenawaran;
use App\Models\Typekaroseri;
use App\Models\Spesifikasi;

class SuratPenawaranController extends Controller
{
    public function detail($kode)
    {
        // Retrieve the main record
        $pembelians = Surat_penawaran::where('id', $kode)->first();

        // Check if the main record exists
        if (!$pembelians) {
            return abort(404, 'Surat Penawaran not found');
        }

        // Retrieve the related records
        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();

        // Check if the related records exist
        if (!$karoseries) {
            return abort(404, 'Typekaroseri not found');
        }

        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        return view('admin.surat_penawaran.qrcode_detail', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }
}