<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Popembelian;
use App\Models\Spk;

class LaporanPopembelianController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan pembelian ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Popembelian::orderBy('id', 'DESC');

            if ($status == "posting") {
                $inquery->where('status', $status);
            } else {
                $inquery->where('status', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
            }

            // $inquery = $inquery->get();

            // kondisi sebelum melakukan pencarian data masih kosong
            $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);
            $inquery = $hasSearch ? $inquery->get() : collect();

            return view('admin.laporanpopembelian.index', compact('inquery'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function print_laporanpopembelian(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan pembelian ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $query = Popembelian::orderBy('id', 'DESC');

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

            $pdf = PDF::loadView('admin.laporanpopembelian.print', compact('inquery'));
            return $pdf->stream('Laporan_po_pembelian.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}