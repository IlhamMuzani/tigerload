<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perintah_kerja;
use App\Models\Detail_suratpenawaran;
use App\Models\Detailperintah;
use App\Models\Typekaroseri;
use App\Models\Spesifikasi;

class PerintahkerjaController extends Controller
{
    public function detail($kode)
    {
        // Retrieve the main record
        $cetakpdf = Perintah_kerja::where('id', $kode)->first();

        // Check if the main record exists
        if (!$cetakpdf) {
            return abort(404, 'Perintah kerja not found');
        }

        // Retrieve the related records
        $karoseries = Typekaroseri::where('id', $cetakpdf->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $cetakpdf->id)->get();

        return view('admin.perintah_kerja.qrcode_detail', compact('cetakpdf', 'karoseries', 'spesifikasis', 'parts'));
    }
}
