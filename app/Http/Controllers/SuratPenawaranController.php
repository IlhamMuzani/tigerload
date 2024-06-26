<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Detail_suratpenawaran;
use App\Models\Kendaraan;
use App\Models\Spesifikasi;
use App\Models\Stnk;
use App\Models\Surat_penawaran;
use App\Models\Typekaroseri;

class SuratPenawaranController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $pembelians = Surat_penawaran::where('kode_spk', $kode)->first();
        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();
        return view('admin.surat_penawaran.qrcode_detail', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }
}
