<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pengambilanbahan;
use App\Models\Spk;

class LaporanPengambilanbahanspkController extends Controller
{
    public function index(Request $request)
    {
        $spks = Spk::get();
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $spk = $request->spk_id; // New variable to store kendaraan_id

        $inquery = Pengambilanbahan::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($spk) {
            $inquery->where('spk_id', $spk);
        }

        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir) || $spk;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporanpengambilanbahanspk.index', compact('inquery', 'spks'));
    }

    public function print_laporanpengambilanbahanspk(Request $request)
    {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Pengambilanbahan::orderBy('id', 'DESC');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporanpengambilanbahanspk.print', compact('inquery'));
        return $pdf->stream('Laporan_Pengambilan_bb.pdf');
    }
}