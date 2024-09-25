<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Perintah_kerja;

class LaporanperintahkerjaController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Perintah_kerja::orderBy('id', 'DESC');

        if ($status == "posting" || $status == "selesai") {
            $inquery->where('status', $status);
        } else {
            $inquery->whereIn('status', ['posting', 'selesai']);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_perintahkerja.index', compact('inquery'));
    }

    public function print_laporanperintahkerja(Request $request)
    {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Perintah_kerja::orderBy('id', 'DESC');

        if ($status == "posting" || $status == "selesai") {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['posting', 'selesai']);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_perintahkerja.print', compact('inquery'));
        return $pdf->stream('Laporan_Spk.pdf');
    }
}