<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MonitoringprojectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $pelanggan_id = $request->pelanggan_id;
        $pelanggans = Pelanggan::get();
        $inquery = Perintah_kerja::query();

        // Filter berdasarkan status jika ada
        if ($status) {
            $inquery->where('status_pengerjaan', $status);
        }

        // Jika pelanggan_id bukan 'all' atau kosong, filter berdasarkan pelanggan_id
        if ($pelanggan_id && $pelanggan_id !== 'all') {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        // Filter berdasarkan tanggal awal dan akhir
        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal, tampilkan data hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        // Urutkan data berdasarkan id secara descending
        $inquery->orderBy('id', 'DESC');

        // Ambil hasil query
        $inquery = $inquery->get();

        // Tampilkan view dengan data yang sudah difilter
        return view('admin.monitoring_project.index', compact('inquery', 'pelanggans'));
    }



    public function show($id)
    {
        $progres = Perintah_kerja::where('id', $id)->first();
        return view('admin.monitoring_project.show', compact('progres'));
    }
}