<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan_pembayaran;

class PenerimaanpembayaranController extends Controller
{
    public function detail($kode)
    {
        $cetakpdf = Penerimaan_pembayaran::where('kode_qrcode', $kode)->first();

        // Check if the main record exists
        if (!$cetakpdf) {
            return abort(404, 'Penerimaan pembayaran not found');
        }

        return view('admin.penerimaan_pembayaran.qrcode_detail', compact('cetakpdf'));
    }
}