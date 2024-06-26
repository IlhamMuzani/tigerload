<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Stnk;
use App\Models\Surat_penawaran;

class SuratPenawaranController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $pembelians = Surat_penawaran::where('kode_spk', $kode)->first();
        return view('admin.surat_penawaran.qrcode_detail', compact('pembelians'));
    }
}